<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function createAccount(Request $request){
        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|max:6|confirmed'
        ]);

        $user = User::create([
            'name' => $attr['name'],
            'password' => bcrypt($attr['password']),
            'email' => $attr["email"] 
        ]);

        return $this->success([
            'token' => $user->createToken('Tokens')->plainTextToken,
            'user' => $user
        ]);
    }

    public function signin(Request $request){
        $attr = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|max:6'
        ]);

        if(!Auth::attempt($attr)){
            return $this->error('credentials do not match', 401);
        }

            /** @var \App\Models\User */
            $user = Auth::user();

        return $this->success([
            'token' => $user->createToken('Tokens')->PlainTextToken,
            'user' => $user
        ]);
        
    }

    public function logout(){
        /** @var \App\Models\User */
        $user = Auth::user();

        $user->tokens()->delete();

        return[
            'message' => 'tokens revoked'
        ];
    }
}
