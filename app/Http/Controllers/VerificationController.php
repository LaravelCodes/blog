<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Verification;

class VerificationController extends Controller
{

    public function store(Request $request){

        $verification = new Verification;
        $verification->user_id = $request->input('user_id');
        $pin = mt_rand(1000,9999);
        $verification->pin = $pin;
        $verification->save();
        $verification = $verification->toArray();

        return ['success'=>true, 'response'=>['verification'=>$verification], 'error'=>'', 'message'=> 'Verification Created Successfully'];
    }
    
    public function read(Request $request){
        
        $verification = Verification::all()->toArray();
        return ['success'=>true, 'response'=>['verifications'=>$verification], 'error'=>'', 'message'=> 'All Verifications Retrived'];
    }

    public function empty(){
        Verification::truncate();
        return ['success'=>true, 'response'=>[], 'error'=>'', 'message'=> 'Verification Table Cleared'];
    }
}
