<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function login(Request $request){

        $validatedData = Validator::make(
            $request->all(),
            [
                'email' => 'required|string|exists:admins,email',
                'password' => 'required'
            ],
            ['required' => 'Please fill out :attribute field'],
            [
                'email' => 'Email',
                'password' => 'Password'
            ]
        );
        if ($validatedData->fails()){
            return ['success'=>false, 'response'=>[], 'error'=>$validatedData->errors()->first(), 'message'=> ''];
        };

        $admin = Admin::where('email', $request->input('email'))->first();
        
        // PASSWORD CONFIRMATION CHECK
        if (!Hash::check($request->input('password'), $admin->password)) {
            return ['success'=>false, 'response'=>[], 'error'=>'Password is Incorrect', 'message'=> ''];
        }
        
        if(!$request->session()->has('admin_login')){
            $request->session()->put('admin_login', $admin->toArray());
        }
 
        return ['success'=>true, 'response'=>['admin'=>$admin], 'error'=>'', 'message'=> 'Admin Logged In Successfully !'];

    }
}
