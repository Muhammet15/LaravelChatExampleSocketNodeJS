<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;
class MessageController extends Controller
{
    public function index()
    {

    }
    public function logins()
    {
        return view('login');
    }


    public function info()
    {
        return Auth()->user();
    }

    public function login(Request $request)
    {

                $credentials = $request->only('email', 'password');

                if (Auth::attempt($credentials)) {
                    $user = Auth::user();
                        $token = $user->createToken("login")->plainTextToken;
                        return  $data['login_token'] = $token;
                    }
                else {
                    return  $credentials ;
                }


    }

    public function loginc(Request $request)
    {

                $credentials = $request->only('email', 'password');

                if (Auth::attempt($credentials)) {
                    $user = Auth::user();
                        $token = $user->createToken("login")->plainTextToken;
                        return redirect()->route('chat-deneme')->with('success', 'Super Admin Girişi Başarılı.');
                    }
                else {
                    return  $credentials ;
                }


    }
}
