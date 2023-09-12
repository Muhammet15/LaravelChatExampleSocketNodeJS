const express = require("express");
const http = require("http");
const axios = require('axios');
const { Server } = require("socket.io");

const app = express();
const server = http.createServer(app);
const io = new Server(server,{
    cors: {
        origin: '*',
    }
});

io.on('connection', function (socket) {
    console.log('connection');

    socket.on('senChatToServer',(message)=>{
        console.log(message);

        io.sockets.emit('senChatToClient',message);
        // socket.broadcast.emit('senChatToClient',message);
    });


    socket.on('disconnect', function () {
        console.log(`Disconnect`);
    });
});

server.listen(3000, function () {
    console.log("Listening to port 3000.");
});


