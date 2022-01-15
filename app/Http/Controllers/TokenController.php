<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function store(Request $request){

        $token = new Token();
        $token->user_id = $request->input('user_id');
        $token->device_name = $request->input('device_name');
        $token->device_model = $request->input('device_model');
        $token->operating_system = $request->input('operating_system');
        $token->token = $request->input('token');
        $token->firebase_token = $request->input('firebase_token');
        $token->save();
        $token = $token->toArray();

        return ['success'=>true, 'response'=>['token'=>$token], 'error'=>'', 'message'=> 'Token Created Successfully'];
    }
    
    public function read(Request $request){
        
        $token = Token::all()->toArray();
        return ['success'=>true, 'response'=>['tokens'=>$token], 'error'=>'', 'message'=> 'All Tokens Retrived'];
    }

    public function empty(){
        Token::truncate();
        return ['success'=>true, 'response'=>[], 'error'=>'', 'message'=> 'Token Table Cleared'];
    }
}
