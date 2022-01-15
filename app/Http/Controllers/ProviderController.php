<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProviderController extends Controller
{
    public function store(Request $request){
        
        $validatedData = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|exists:users,id|unique:providers,user_id',
                'services' => 'required|string',
                'from' => 'required',
                'to' => 'required',
                'range' => 'required|integer',
            ],
            [
                'required' => 'Please fill out :attribute field',
            ],
            [
                'user_id' => 'User ID',
                'services' => 'Services',
                'from' => 'Start Time',
                'to' => 'End Time',
                'range' => 'Range',
            ]
        );
        if ($validatedData->fails()){
            return ['success'=>false, 'response'=>[], 'error'=>$validatedData->errors()->first(), 'message'=> ''];
        };

        $user = User::find($request->input('user_id'))->first();
        if($user->type !== 'Provider'){
            return ['success'=>false, 'response'=>[], 'error'=>'User Is Not Provider', 'message'=> ''];
        }

        $provider = new Provider;
        $provider->user_id = $request->input('user_id') ;
        $provider->services = $request->input('services');
        $provider->from = Carbon::parse($request->input('from'))->format('h:i:s a');
        $provider->to = Carbon::parse($request->input('to'))->format(' h:i:s a');
        $provider->range = $request->input('range');
        $provider->save();
    
        return ['success'=>true, 'response'=>['provider'=> $provider], 'error'=>'', 'message'=> 'Provider Created Successfully'];
    }

    public function update(Request $request){
        
        $validatedData = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|exists:users,id',
                'services' => 'required|string',
                'from' => 'required',
                'to' => 'required',
                'range' => 'required|integer',
            ],
            [
                'required' => 'Please fill out :attribute field',
            ],
            [
                'user_id' => 'User ID',
                'services' => 'Services',
                'from' => 'Start Time',
                'to' => 'End Time',
                'range' => 'Range',
            ]
        );
        if ($validatedData->fails()){
            return ['success'=>false, 'response'=>[], 'error'=>$validatedData->errors()->first(), 'message'=> ''];
        };

        $user = User::find($request->input('user_id'))->first();
        if($user->type !== 'Provider'){
            return ['success'=>false, 'response'=>[], 'error'=>'User Is Not Provider', 'message'=> ''];
        }

        $provider = Provider::find($request->input('user_id'))->first();

        if(!empty($request->input('services'))){
            $provider->services = $request->input('services');
        }
        if(!empty($request->input('from'))){
            $provider->from = Carbon::parse($request->input('from'))->format('h:i:s a');
        }
        if(!empty($request->input('to'))){
            $provider->from = Carbon::parse($request->input('to'))->format('h:i:s a');
        }
        if(!empty($request->input('range'))){
            $provider->range = $request->input('range');
        }
        $provider->save();
    
        return ['success'=>true, 'response'=>['provider'=> $provider], 'error'=>'', 'message'=> 'Provider Updated Successfully'];
    }

    public function empty(){
        Provider::truncate();
        return ['success'=>true, 'response'=>[], 'error'=>'', 'message'=> 'Provider Table Cleared'];
    }
}
