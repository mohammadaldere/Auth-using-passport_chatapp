<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
class loginController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required|string'
        ]);
        $credentials=request(['email','password']);
        if(Auth::attempt($credentials)){
            $token=Auth()->user()->createToken('Token');
            $token2=$token->accessToken;
            $expiration = $token->token;
            $expiration->expires_at = Carbon::now()->addWeeks(1);
            $expiration->save;
            return response()->json(['data' =>[
                'user' => Auth::user(),
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString()
    
            ]
             
            ]);
        }
        else{
            return response()->json(['message'=>'Unauthorized'],401);
        }

        
        
    }
}
