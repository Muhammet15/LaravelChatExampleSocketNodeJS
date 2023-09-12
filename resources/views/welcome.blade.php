<!DOCTYPE html>
<html>
<head>
    <title>Laravel WebSocket Example</title>
    <style>
        .chat-row{
            margin: 50px;
        }
        ul{
            margin: 0;
            padding: 0;
            list-style: none;
        }
        ul li {
            padding: 8px;
            background: #928787;
            margin-bottom: 20px;
        }
        ul li:nth-child(2n-2){
        background: #c3c5c5;

        }
        .chat-input{
            border: 1px solid lightgray;
            border-top-right-radius: 10px;
            border-top-left-radius: 10px;
            padding: 8px 10px;
        }
    </style>
</head>
<body>
    <!-- Sayfanızın içeriği -->
 <div class="container">
    <div class="row">
        <div class="chat-content">
            <ul>
                <li>asdasda</li>
            </ul>
        </div>
        <div class="chat-section">
            <div class="chat-box">
                <div class="chat-input bg-white" id="chatInput" contenteditable="">

                </div>
            </div>
        </div>
    </div>
 </div>
    <script src="https://cdn.socket.io/4.6.0/socket.io.min.js" integrity="sha384-c79GN5VsunZvi+Q/WObgk2in0CbZsHnjEqvFxC5DxHn9lTfNce2WW6h2pH6u/kF+"
    crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src='./js/socket.js'></script> <!-- socket.js dosyasını ekler --> --}}
    <script>
        $(function(){
        let ip_address = '127.0.0.1';
        let socket_port= '3000';
        let socket = io(ip_address+':'+socket_port);
        let chatInput = $('#chatInput');

        chatInput.keypress(function(e){
            let message = $(this).html();
            console.log(message);
            if (e.which === 13 && !e.shiftKey) {
                socket.emit('senChatToServer',message);
                chatInput.html('');
                return false;
            }
        });
        socket.on('senChatToClient',(message)=>{
            $('.chat-content ul').append(`<li>${message}</li>`);
        });

    });

    </script>
    {{--
<script src="{{ asset('js/socket.js') }}"></script> --}}
    {{-- @vite(['resources/js/app.js']) --}}
    {{-- @vite(['resources/js/socket.js']) --}}

    {{-- <script src="{{ asset('js/socket.js') }}"></script> --}}

</body>
</html>
