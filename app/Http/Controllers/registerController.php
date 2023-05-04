<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class registerController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|string|unique:users',
            'password'=>'required|string'
        ]);

        $user= new User([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);

        $user->save();
        $token=$user->createToken('Token')->accessToken;
        return response()->json([
            'message'=>'User has been registered',
            'user' => $user,
            'token' => $token,
        ],200);
    }
}
