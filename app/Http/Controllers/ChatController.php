<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;
use App\Models\Chat;
class ChatController extends Controller
{
    public function index()
    {
        return view('chat.index');
    }
    public function saveMessage(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $message = new Message([
            'text' => $request->input('message'),
        ]);

        $user->messages()->save($message);

        // Mesaj gönderildikten sonra WebSocket ile diğer kullanıcılara gönderme kodu burada olacak
        // WebSocket kodunu implemente etmeye devam edin.

        return response()->json(['message' => 'Message sent successfully']);
    }
    public function index2(Request $request, $id=null)
    {
        $messages = [];
        $user_id = Auth::id();
        $otherUser = null;
        if ($id) {
            $otherUser = User::findOrFail($id);
            $group_id = (Auth::id()>$id)?Auth::id().$id:$id.Auth::id();
            $messages = Chat::where('group_id',$group_id)->get()->toArray();
            Chat::where(['user_id'=>$id,'other_user_id'=>$user_id,'is_read'=>0])->update(['is_read'=>1]);
        }
     $friends = User::where('id','!=',Auth::id())->select('*',DB::raw("(SELECT count(id) from chats where
       chats.other_user_id=$user_id and chats.user_id = users.id and chats.is_read = 0) as unread_messages "))->get()->toArray();
        return view('chat',compact('friends','messages','otherUser','id'));
    }
    public function send(Request $request)
    {
        $message = $request->input('message');

        // Mesajı Socket.io sunucusuna göndermek için gerekli kodları ekleyin
        // Örnek olarak, sendMessage işlevini kullanabilirsiniz.

        return redirect()->back();
    }

}
