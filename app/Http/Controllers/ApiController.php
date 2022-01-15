<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ApiController extends Controller
{
    public function render($success, $response, $error, $message, $status = 200){
        return response()->json([
            'status'=> $status,
            'success'=> $success,
            'error' => $error,
            'message' => $message,
            'response'=> $response,
        ],$status);
    }

    // -----USER API METHODS-----
    public function create_user(Request $request){
        $user = App::call([new UserController, 'store']);
        return $this->render($user['success'], $user['response'], $user['error'], $user['message']);
    }
    public function read_user(Request $request){
        $user = App::call([new UserController, 'read']);
        return $this->render($user['success'], $user['response'], $user['error'], $user['message']);
    }
    public function update_user(Request $request){
        $user = App::call([new UserController, 'update']);
        return $this->render($user['success'], $user['response'], $user['error'], $user['message']);
    }
    public function action_user(Request $request){
        $user = App::call([new UserController, 'action']);
        return $this->render($user['success'], $user['response'], $user['error'], $user['message']);
    }
    public function empty_user(Request $request){
        $user = App::call([new UserController, 'empty']);
        return $this->render($user['success'], $user['response'], $user['error'], $user['message']);
    }    
    public function empty_provider(Request $request){
        $user = App::call([new ProviderController, 'empty']);
        return $this->render($user['success'], $user['response'], $user['error'], $user['message']);
    }    
    public function login_user(Request $request){
        $user = App::call([new UserController, 'login']);
        return $this->render($user['success'], $user['response'], $user['error'], $user['message']);
    }
    public function forgot_step1(Request $request){
        $user = App::call([new UserController, 'forgot_step1']);
        return $this->render($user['success'], $user['response'], $user['error'], $user['message']);
    }
    public function forgot_step2(Request $request){
        $user = App::call([new UserController, 'forgot_step2']);
        return $this->render($user['success'], $user['response'], $user['error'], $user['message']);
    }
    public function forgot_step3(Request $request){
        $user = App::call([new UserController, 'forgot_step3']);
        return $this->render($user['success'], $user['response'], $user['error'], $user['message']);
    }
    public function email_verification(Request $request, $username){
        $request->request->add(['username'=>$username]);
        $user = App::call([new UserController, 'email_verification']);
        return $this->render($user['success'], $user['response'], $user['error'], $user['message']);
    }
    public function provider_services(Request $request){
        $user = App::call([new ProviderController, 'store']);
        return $this->render($user['success'], $user['response'], $user['error'], $user['message']);
    }
    public function provider_services_update(Request $request){
        $user = App::call([new ProviderController, 'update']);
        return $this->render($user['success'], $user['response'], $user['error'], $user['message']);
    }
    // -----USER API METHODS ENDS-----
    /* */
    /* */
    /* */
    /* */
    /* */
    // -----Verifications API METHODS-----
    public function read_verification(Request $request){
        $verification = App::call([new VerificationController, 'read']);
        return $this->render($verification['success'], $verification['response'], $verification['error'], $verification['message']);
    }
    public function empty_verification(Request $request){
        $verification = App::call([new VerificationController, 'empty']);
        return $this->render($verification['success'], $verification['response'], $verification['error'], $verification['message']);
    }
    // -----Verifications API METHODS ENDS-----
    /* */
    /* */
    /* */
    /* */
    /* */
    // -----Token API METHODS-----
    public function read_token(Request $request){
        $token = App::call([new TokenController, 'read']);
        return $this->render($token['success'], $token['response'], $token['error'], $token['message']);
    }
    public function empty_token(Request $request){
        $token = App::call([new TokenController, 'empty']);
        return $this->render($token['success'], $token['response'], $token['error'], $token['message']);
    }
    // -----Token API METHODS ENDS-----
    /* */
    /* */
    /* */
    /* */
    /* */
}
