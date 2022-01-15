<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function store(Request $request){

        $validatedData = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:512',
                'username' => 'required|string|unique:users,username',
                'password' => 'required',
                'email' => 'required|email|max:512|unique:users,email',
                'number' => 'required|integer',
                'type' => 'required|string',
            ],
            [
                'required' => 'Please fill out :attribute field',
                'unique' => 'This :attribute is already registered'
            ],
            [
                'name' => 'Name',
                'username' => 'Username',
                'password' => 'Password',
                'email' => 'Email Address',
                'number' => 'Phone Number',
                'type' => 'User Type',
            ]
        );
        if ($validatedData->fails()){
            return ['success'=>false, 'response'=>[], 'error'=>$validatedData->errors()->first(), 'message'=> ''];
        };

        $user = new User;
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->number = $request->input('number');
        $user->type = $request->input('type');
        $user->save();

        /* If User Is Provider */
        if($request->input('type') === 'Provider' && !empty($request->input('services'))){
            $request->request->add(['user_id' => $user->id]);
            $request->request->add(['services' => $request->input('services')]);
            $provider = App::call([new ProviderController, 'store']);
            // dd($provider);
        }

        // EMAIL VERIFICATION TOKEN
        $verify = URL::to('user/email_verification/'.sha1($user->username));
        /*
            Mail::send('email.forgot_email', ['verify_key' => $verify_key, 'user' => $user], function ($m) use ($user) {
                $m->from('', 'Your Application');
                
                $m->to(
                    $user->email, 
                    $user->name
                    )->subject('Your Reminder!');
                });
        */

        // TOKEN GENREATION FOR LOGIN
        $request->request->add(['user_id'=>$user->id]);
        $request->request->add(['device_name'=>'']);
        $request->request->add(['device_model'=>'']);
        $request->request->add(['operating_system'=>'']);
        $request->request->add(['token'=> Hash::make($user->id)]);
        $request->request->add(['firebase_token'=>'**Not Null**']);
        $token = App::call([new TokenController, 'store']);
        $token = $token['response']['token'];
    
        return ['success'=>true, 'response'=>['user'=>$user, 'token'=>$token, 'verify' => $verify], 'error'=>'', 'message'=> 'User Created Successfully'];
    }
    
    public function update(Request $request){

        $user = User::where('username', $request->input('username'))->first();

        $validatedData = Validator::make(
            $request->all(),
            [
                'name' => 'string|max:512',
                'email' => 'email|max:512|unique:users,email,'.$user->id,
                'password' => 'required',
                'number' => 'integer',
                'type' => 'string',
            ],
            [
                'required' => 'Please fill out :attribute field',
                'unique' => 'This :attribute is already registered'
            ],
            [
                'name' => 'Name',
                'password' => 'Password',
                'email' => 'Email Address',
                'number' => 'Phone Number',
                'type' => 'Type',
            ]
        );
        if ($validatedData->fails()){
            return ['success'=>false, 'response'=>[], 'error'=>$validatedData->errors()->first(), 'message'=> ''];
        };

        // PASSWORD CONFIRMATION CHECK
        if (!$request->input('password') === $user->password) {
            return ['success'=>false, 'response'=>[], 'error'=>'Password is Incorrect', 'message'=> ''];
        }

        // IF USER WISHES TO CHANGE NAME
        if(!empty($request->input('name'))){
            $user->name = $request->input('name');
        }
        
        // IF USER WISHES TO CHANGE EMAIL
        if(!empty($request->input('email'))){
            $user->email = $request->input('email');
        }

        // IF USER WISHES TO CHANGE PASSWORD
        if(!empty($request->input('new_password'))){
            $user->password = Hash::make($request->input('new_password'));
        }

        // IF USER WISHES TO CHANGE NUMBER
        if(!empty($request->input('number'))){
            $user->number = $request->input('number');
        }

        // IF USER WISHES TO CHANGE TYPE
        if(!empty($request->input('type'))){
            $user->type = $request->input('type');
        }
        
        $user->save();

        return ['success'=>true, 'response'=>['user'=>$user->toArray()], 'error'=>'', 'message'=> $user->name.' Updated Successfully!'];
    }

    public function action(Request $request){

        
        $validatedData = Validator::make(
            $request->all(),
            [
                'username' => 'required|string|exists:users,username',
                'recover' => 'boolean',
                'delete' => 'boolean',
            ],
            ['required' => 'Please fill out :attribute field'],
            ['username' => 'Username']
        );
        if ($validatedData->fails()){
            return ['success'=>false, 'response'=>[], 'error'=>$validatedData->errors()->first(), 'message'=> ''];
        };

        $user = User::where('username', $request->input('username'))->first();
        
        // Message 
        $message = 'No Action Selected';
        
        // IF DELETE IS TRUE
        if($request->input('delete')){
            $user->is_deleted = 1;
            $message = $user->name.' Deleted';
        }

        // IF RECOVER IS TRUE
        if($request->input('recover')){
            $user->is_deleted = 0;
            $message = $user->name.' Recovered';
        }

        $user->save();

        return ['success'=>true, 'response'=>[], 'error'=>'', 'message'=> $message];
    }

    public function login(Request $request){

        $validatedData = Validator::make(
            $request->all(),
            [
                'email' => 'required|string|exists:users,email',
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

        // Login USER VIA Email
        $user = User::where('email', $request->input('email'))->first();
        
        // PASSWORD CONFIRMATION CHECK
        if (!Hash::check($request->input('password'), $user->password)) {
            return ['success'=>false, 'response'=>[], 'error'=>'Password is Incorrect', 'message'=> ''];
        }
        
        // TOKEN GENREATION FOR LOGIN
        $request->request->add(['user_id'=>$user->id]);
        $request->request->add(['device_name'=>'']);
        $request->request->add(['device_model'=>'']);
        $request->request->add(['operating_system'=>'']);
        $request->request->add(['token'=> Hash::make($user->id)]);
        $request->request->add(['firebase_token'=>'**Not Null**']);
        $token = App::call([new TokenController, 'store']);
        $token = $token['response']['token'];

        return ['success'=>true, 'response'=>['user'=>$user, 'token'=>$token], 'error'=>'', 'message'=> 'User Logged In Successfully !'];

    }

    public function forgot_step1(Request $request){
        $validatedData = Validator::make(
            $request->all(),
            ['email' => 'required|email|max:512|exists:users,email'],
            ['required' => 'Please fill out :attribute field',],
            ['email' => 'Email Address',]
        );
        if ($validatedData->fails()){
            return ['success'=>false, 'response'=>[], 'error'=>$validatedData->errors()->first(), 'message'=> ''];
        };

        $user = User::where('email', $request->input('email'))->first();
        $request->request->add(['user_id'=>$user->id]);
        $verification = App::call([new VerificationController, 'store']);
      
        $user = $user->toArray();
        $verification = $verification['response']['verification'];
        // dd($user, $verification);

        /*
            Mail::send('email.forgot_email', ['pin' => $pin, 'user' => $user], function ($m) use ($user) {
                $m->from('', 'Your Application');

                $m->to(
                    $user->email, 
                    $user->name
                    )->subject('Your Reminder!');
            });
        */

        return ['success'=>true, 'response'=>['user'=>$user, 'verification'=>$verification], 'error'=>'', 'message'=> 'A 4-Digit Pin Is Send To '.$request->input('email')];
    } 

    public function forgot_step2(Request $request){
        $validatedData = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|exists:users,id',
                'pin' => 'required|exists:verifications,pin',
            ],
            ['required' => 'Please fill out :attribute field',],
            [
                'user_id' => 'User ID',
                'pin' => 'Verification Pin',
            ]
        );
        if ($validatedData->fails()){
            return ['success'=>false, 'response'=>[], 'error'=>$validatedData->errors()->first(), 'message'=> ''];
        };

        $user = User::find($request->input('user_id'))->toArray();
        // dd($user);

        return ['success'=>true, 'response'=>['user'=>$user], 'error'=>'', 'message'=> $user['name'].' Authenticated Successfully'];
    } 

    public function forgot_step3(Request $request){
        $validatedData = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|exists:users,id',
                'password' => 'required',
                'r_password' => 'required',
            ],
            ['required' => 'Please fill out :attribute field',],
            [
                'user_id' => 'User ID',
                'password' => 'Password',
                'r_password' => 'Repeat Password',
            ]
        );
        if ($validatedData->fails()){
            return ['success'=>false, 'response'=>[], 'error'=>$validatedData->errors()->first(), 'message'=> ''];
        };

        if($request->input('password') !== $request->input('r_password')){
            return ['success'=>false, 'response'=>[], 'error'=>'Both Passwords Should Match', 'message'=> ''];
        }
        
        $user = User::find($request->input('user_id'));
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // TOKEN GENREATION FOR LOGIN
        $request->request->add(['user_id'=>$user->id]);
        $request->request->add(['device_name'=>'']);
        $request->request->add(['device_model'=>'']);
        $request->request->add(['operating_system'=>'']);
        $request->request->add(['token'=> Hash::make($user->id)]);
        $request->request->add(['firebase_token'=>'**Not Null**']);
        $token = App::call([new TokenController, 'store']);
        $token = $token['response']['token'];

        $user = $user->toArray();

        return ['success'=>true, 'response'=>['user'=>$user, 'token'=>$token], 'error'=>'', 'message'=> $user['name'].' Password Changed Successfully'];
    } 

    public function email_verification(Request $request){

        $user = User::where(DB::raw('sha1(username)'),$request->input('username'))->first();

        if($user === null){
            return ['success'=>false,'error'=>'Verification Expired','message'=>'','response'=>[]];
        }

        $user->is_verified = 1;
        $user->save();
        $user = $user->toArray();

        return ['success'=>true,'error'=>'','message'=>'Email Verified Successfully','response'=>["user"=>$user]];

    }
    
    public function empty(){
        User::truncate();
        return ['success'=>true, 'response'=>[], 'error'=>'', 'message'=> 'User Table Cleared'];
    }

    /* */
    /* */
    /* */
    /* AJAX DATA LOAD */
    public function read(Request $request)
    {
        // return $request->all();
        if ($request->ajax()) {
            $data = User::where('is_deleted', $request->get('is_deleted'));

            $recordsTotal = $data->count();

            // Filters 
            if ($request->has('search')) {
                $data = $data->where('name','LIKE', '%'.$request->get('search')['value'].'%')
                            ->orWhere('username','LIKE', '%'.$request->get('search')['value'].'%')
                            ->orWhere('email','LIKE', '%'.$request->get('search')['value'].'%')
                            ->orWhere('number','LIKE', '%'.$request->get('search')['value'].'%')
                            ->orWhere('type','LIKE', '%'.$request->get('search')['value'].'%')
                            ->orWhere('created_at','LIKE', '%'.$request->get('search')['value'].'%');
            }
            if ($request->has('order') && !empty($request->get('order'))) {
                $column = ['name','number','address','date','created_at'][$request->get('order')[0]['column']];
                $data = $data->orderBy($column, $request->get('order')[0]['dir']);
            }
            // Filters

            $recordsFiltered = $data->count();

            // Pagination
            if ($request->has('start') && $request->get('start') > 0) {
                $data = $data->skip($request->get('start'));
            }

            if ($request->has('length') && $request->get('length') > 0) {
                $data = $data->take($request->get('length'));
            }
            // Pagination

            $user['draw'] = intval($request->get('draw'));
            $user['recordsTotal'] = $recordsTotal;
            $user['data'] = $data->get();
            $user['recordsFiltered'] = $recordsFiltered;
            return $user;
        }
    }

    /* */
    /* */
    /* */
    /* Get Single User For Update */
    public function update_data(Request $request){

        // Username IN CASE FOR PARTICUAR USER
        if(!empty($request->input('username'))){
            $user = User::where('username', $request->input('username'))->first();

            if($user === null){
            return ['success'=>false, 'response'=>[], 'error'=>'Users database is empty or Id is invalid', 'message'=> ''];
            }
            $userData = $user->toArray();
            return ['success'=>true, 'response'=>['user'=>$userData], 'error'=>'', 'message'=> $userData['name'].' Retrived'];
        }
    }
    
    /*
    public function read(Request $request){

        // ID IN CASE FOR PARTICUAR USER
        if(!empty($request->input('id'))){
            $user = User::find($request->input('id'));

            if($user === null){
            return ['success'=>false, 'response'=>[], 'error'=>'Users database is empty or Id is invalid', 'message'=> ''];
            }
            // dd($user);
            $userData = $user->toArray();
            // dd($userData);
            return ['success'=>true, 'response'=>['user'=>$userData], 'error'=>'', 'message'=> $userData['name'].' Retrived'];
        }

        // IF DELETED IS TRUE GET DELETED USERS
        if($request->input('deleted')){
            $user = User::where('is_deleted', 1)->get()->toArray();
            // dd($user);
            return ['success'=>true, 'response'=>['user'=>$user], 'error'=>'', 'message'=> 'Deleted Users Retrived'];
        }

        // IF VERIFIED IS TRUE GET VERIFIED USERS
        if($request->input('verified')){
            $user = User::where('is_verified', 1)->get()->toArray();
            // dd($user);
            return ['success'=>true, 'response'=>['user'=>$user], 'error'=>'', 'message'=> 'Verified Users Retrived'];
        }

        
        // ELSE RETRIEVE ALL USERS
        $user = User::where('is_deleted', 0)->get()->toArray();
        // dd($user);
        return ['success'=>true, 'response'=>['user'=>$user], 'error'=>'', 'message'=> 'All Users Retrived'];
    }
    */

}

