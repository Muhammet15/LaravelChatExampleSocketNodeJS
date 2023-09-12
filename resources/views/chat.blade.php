<!DOCTYPE html>
<html lang="en">
    <head>
        <title itemprop="name">Preview Bootstrap snippets. white chat</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />

        <style type="text/css">
                body {
                    margin-top: 20px;
                }

                .chat-online {
                    color: #34ce57;
                }

                .chat-offline {
                    color: #e4606d;
                }

                .chat-messages {
                    display: flex;
                    flex-direction: column;
                    height: calc(100vh - 200px);
                    overflow-y: scroll;
                }

                .chat-message-left,
                .chat-message-right {
                    display: flex;
                    flex-shrink: 0;
                }

                .chat-message-left {
                    margin-right: auto;
                }

                .chat-message-right {
                    flex-direction: row-reverse;
                    margin-left: auto;
                }
                .py-3 {
                    padding-top: 1rem !important;
                    padding-bottom: 1rem !important;
                }
                .px-4 {
                    padding-right: 1.5rem !important;
                    padding-left: 1.5rem !important;
                }
                .flex-grow-0 {
                    flex-grow: 0 !important;
                }
                .border-top {
                    border-top: 1px solid #dee2e6 !important;
                }
            </style>
    </head>
    <body>
        <div id="snippetContent">
            <main class="content">
                <div class="container p-0">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-12 col-lg-5 col-xl-3 border-right" style="height: calc(100vh - 100px); overflow-y: scroll;">
                                @foreach ($friends as $friend )
                                    <a href="{{route('chat-deneme',$friend['id'])}}" class="list-group-item list-group-item-action border-0">

                                        <div id="unread-count-{{$friend['id']}}"></div>

                                        <div class="d-flex align-items-start">
                                            <img src="https://ui-avatars.com/api/?name={{$friend['name']}}" class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40" />
                                            <div class="flex-grow-1 ml-3">
                                            {{$friend['name']}}
                                                <div class="small" id="status_{{$friend['id']}}">
                                                    @if ($friend['is_online'] == 1)
                                                    <span class="fa fa-circle chat-online"></span> Online</div>
                                                    @else
                                                    <span class="fa fa-circle chat-offline"></span> Offline</div>
                                                    @endif

                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                                <hr class="d-block d-lg-none mt-1 mb-0" />
                            </div>
                            <div class="col-12 col-lg-7 col-xl-9">
                                @if ($id)
                                <div class="py-2 px-4 border-bottom d-none d-lg-block">
                                    <div class="d-flex align-items-center py-1">
                                        <div class="position-relative"><img src="https://ui-avatars.com/api/?name={{$otherUser->name}}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40" /></div>
                                        <div class="flex-grow-1 pl-3">
                                            <strong>{{$otherUser->name}}</strong>
                                            <div class="text-muted small" id="typing-in"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="position-relative">
                                    <div class="chat-messages p-4">
                                        @foreach ($messages as $message )
                                        @if ( $message['user_id'] == Auth::id() )
                                            <div class="chat-message-right pb-4">
                                                <div>
                                                    <img src="https://ui-avatars.com/api/?name={{Auth::user()->name}}" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40" />
                                                    <div class="text-muted small text-nowrap mt-2">{{substr($message['created_at'],11, 5)}}</div>
                                                </div>
                                                <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                                    <div class="font-weight-bold mb-1">You</div>
                                                    {{$message['message']}}
                                                </div>
                                            </div>
                                        @else
                                            <div class="chat-message-left pb-4">
                                                <div>
                                                    <img src="https://ui-avatars.com/api/?name={{$otherUser->name}}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40" />
                                                    <div class="text-muted small text-nowrap mt-2">{{substr($message['created_at'],11, 5)}}</div>
                                                </div>
                                                <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                                    <div class="font-weight-bold mb-1">{{$otherUser->name}}</div>
                                                    {{$message['message']}}
                                                </div>
                                            </div>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="flex-grow-0 py-3 px-4 border-top">
                                    <form id="chat-form">
                                        <div class="input-group">
                                            <input type="text" id="message-input" class="form-control" placeholder="Type your message" style="margin-right: 10px;"/>
                                            <button class="btn btn-primary" type="submit">Send</button>
                                        </div>
                                    </form>
                                </div>
                                @else

                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    {{-- </div> --}}

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.2/socket.io.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script>
            var tout ;
            $(function(){

                var user_id = '{{ Auth::id() }}';
                var other_user_id = '{{ ($otherUser)?$otherUser->id:''}}';
                var otherUserName = '{{ ($otherUser)?$otherUser->name:''}}';
                var socket = io("http://localhost:3000", { query: { user_id: user_id } });
                $('#chat-form').on('submit',function(e){
                    e.preventDefault();
                    var message = $("#message-input").val();
                    if (message.trim().length == 0) {
                        $("#message-input").focus();
                    }else{
                        var data = {
                            user_id:user_id,
                            other_user_id:other_user_id,
                            message:message,
                            otherUserName:otherUserName,

                        }
                        socket.emit('send_message',data);
                        $("#message-input").val('');
                    }
                })
                socket.on('user_connected',function(data){
                    $("#status_"+data).html('<span class="fa fa-circle chat-online"></span> Online');
                    // console.log(data);
                });
                socket.on('user_disconnected',function(data){
                    $("#status_"+data).html('<span class="fa fa-circle chat-offline"></span> Offline');
                });
                socket.on('receive_message',function(data){
                    // console.log("receive_message",data);
                    if ((data.user_id ==  user_id && data.other_user_id == other_user_id)|| (data.user_id == other_user_id && data.other_user_id == user_id))
                    {
                        if (data.user_id == user_id) {
                            var html = `
                             <div class="chat-message-right pb-4">
                                    <div>
                                        <img src="https://ui-avatars.com/api/?name={{Auth::user()->name}}" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40" />
                                        <div class="text-muted small text-nowrap mt-2">${data.time}</div>
                                    </div>
                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                        <div class="font-weight-bold mb-1">You</div>
                                            ${data.message}
                                    </div>
                            </div>`
                        }else {
                            socket.emit('read_message',data.id);
                            var html = `
                            <div class="chat-message-left pb-4">
                                                <div>
                                                    <img src="https://ui-avatars.com/api/?name=${data.otherUserName}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40" />
                                                    <div class="text-muted small text-nowrap mt-2">${data.time}</div>
                                                </div>
                                                <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                                    <div class="font-weight-bold mb-1">${data.otherUserName}</div>
                                                    ${data.message}
                                                </div>
                                            </div>`
                        }
                        $(".chat-messages").append(html);
                        $(".chat-messages").animate({scroolTop:$(".chat-messages").prop("scrollHeight")},1000)
                    }else{
                        $("#unread-count-"+data.user_id).html('<div class="badge bg-success float-right">'+data.unread_messages+'</div>')
                    }
                });
                socket.on('user_typing', function(data){
                // console.log("user typing",data);
                if (data.user_id==other_user_id) {
                    $("#typing-in").html('<em>Typing</em>')
                    clearTyping();
                    clearTimet();
                }
            });
                    $('#message-input').on('keyup',function(){
                        socket.emit('user_typing',{user_id:user_id, other_user_id : other_user_id});
                    });


            })
            function clearTyping(){
                tout =  setTimeout(function(){
                    $("#typing-in").html('')
                },4000)
            }
            function clearTimet(){
                setTimeout(tout);
            }
        </script>
    </body>
</html>
