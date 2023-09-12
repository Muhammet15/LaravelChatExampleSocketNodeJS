const express = require('express');
const app = express();

const http = require('http').Server(app);
var io = require('socket.io')(http,{
    cors:{
        origin: '*',
    }
});

const axios = require('axios');
var mysql = require('mysql');
var moment = require('moment');
const { log, group } = require('console');
var sockets = {};


var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'root',
  password : '',
  database : 'socketnode'
});

connection.connect(function(err){
    if (err) {
        throw err;
    }
    console.log("db connected");
});
io.on('connection', function(socket){
        if (!sockets[socket.handshake.query.user_id]) {
            sockets[socket.handshake.query.user_id] = [];
        }
        sockets[socket.handshake.query.user_id].push(socket);
        socket.broadcast.emit('user_connected',socket.handshake.query.user_id);
        connection.query(`UPDATE users SET is_online=1 WHERE id=${socket.handshake.query.user_id}`, function(err, res){
            if (err) {
                throw err;
            }
            console.log('user connected', socket.handshake.query.user_id);
        });
        socket.on('send_message',function(data){
            group_id=(data.user_id>data.other_user_id)?data.user_id+data.other_user_id:data.other_user_id+data.user_id;
            var time = moment().format("h:mm");
            var created_at = moment().format("YYYY-MM-DD HH:mm");
            data.time = time;
            connection.query(`INSERT INTO chats (user_id, other_user_id, message, group_id, created_at) VALUES (${data.user_id}, ${data.other_user_id}, '${data.message}', ${group_id},'${created_at}' )`, function(err, res) {
                if (err) {
                    throw err;
                }
                console.log('Mesaj başarıyla gönderildi.');
                data.id = res.insertId;
                for(var index in sockets[data.user_id]){
                    sockets[data.user_id][index].emit('receive_message',data);

                }
                connection.query(`SELECT count(id) as unread_messages from chats where user_id=${data.user_id} and other_user_id=${data.other_user_id} and is_read=0`,function(err,res){
                    if (err) {
                        throw err;
                    }
                    console.log("--->", data.unread_messages = res[0].unread_messages);
                    data.unread_messages = res[0].unread_messages;
                    for(var index in sockets[data.other_user_id]){
                        sockets[data.other_user_id][index].emit('receive_message',data);

                    }
                });

            });

        });
        socket.on('read_message',function(id){
            connection.query(`UPDATE chats set is_read=1 where id=${id}`,function(err, res){
                if (err) {
                    throw err;
                }
                console.log("messagered");
            })
        });
        socket.on('user_typing',function(data){
            for(var index in sockets[data.other_user_id]){
                sockets[data.other_user_id][index].emit('user_typing',data);
            }
        });

    socket.on('disconnect',function(err){
        socket.broadcast.emit('user_disconnected',socket.handshake.query.user_id);
        for(var index in sockets[socket.handshake.query.user_id])
        {
            if (socket.id == sockets[socket.handshake.query.user_id][index].id) {
                sockets[sockets[ socket.handshake.query.user_id].splice(index,1)];
            }
        }
        connection.query(`UPDATE users SET is_online=0 WHERE id=${socket.handshake.query.user_id}`, function(err, res){
            if (err) {
                throw err;
            }
            console.log('user disconnected', socket.handshake.query.user_id);
        });

    });
});
http.listen(3000, function () {
    console.log("Listening to port 3000.");
});


