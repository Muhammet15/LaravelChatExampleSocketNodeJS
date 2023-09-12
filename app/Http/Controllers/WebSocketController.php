<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BeyondCode\LaravelWebSockets\WebSockets\WebSocket;
use BeyondCode\LaravelWebSockets\WebSockets\Channels\ChannelManager;

class WebSocketController extends Controller
{
    public function handleMessage(Request $request, WebSocket $webSocket, ChannelManager $channelManager)
    {
        $message = $request->input('message');

        // İşlem yapılacak kodu buraya ekleyin

        return response()->json(['status' => 'success']);
    }
}
