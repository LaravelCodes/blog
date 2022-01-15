<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AdminApiController extends Controller
{
    public function render($response, $status = 200){
        return response()->json(['response'=> $response],$status);
    }
    /* */
    /* */
    /* */
    /* */
    /* */
    // -----ADMIN API METHODS-----
    public function login_page(Request $request){
        return view('admin.features.login');
    }
    public function login(Request $request){
        $admin = App::call([new AdminController, 'login']);

        if(!$admin['success']){
            return redirect('admin/login')->withError($admin['error']);
        }
        // ddd($admin, session()->get('admin_login'));
        return redirect('admin/dashboard')->withSuccess($admin['message']);
    }
    public function dashboard(Request $request){
        return view('admin.features.dashboard');
    }
    public function logout(Request $request){
        $request->session()->forget('admin_login');
        return redirect('admin/login');
    }
    /* */
    /* */
    /* */
    /* */
    /* */
    // -----USERS API METHODS-----
    public function users_table(Request $request){
        return view('admin.users.table');
    }
    public function users_data(Request $request){
        $request->request->add(['is_deleted' => 0]);
        return App::call([new UserController, 'read']);
    }
    public function users_suspended_table(Request $request){
        return view('admin.users.suspended_table');
    }
    public function users_suspended_data(Request $request){
        $request->request->add(['is_deleted' => 1]);
        return App::call([new UserController, 'read']);
    }
    public function create_user_page(Request $request){
        $services = App::call([new ServiceController, 'readForUser']);
        return view('admin.users.add', ['services' => $services['response']['services']]);
    }
    public function create_user(Request $request){
        $user = App::call([new UserController, 'store']);

        if(!$user['success']){
            return redirect('admin/users/add')->withError($user['error']);
        }
        return redirect('admin/users/table')->withSuccess($user['message']);
    }
    public function suspend_user(Request $request){
        $request->request->add(['delete' => true]);
        App::call([new UserController, 'action']);
    }
    public function recover_user(Request $request){
        $request->request->add(['recover' => true]);
        App::call([new UserController, 'action']);
    }
    public function update_user_page(Request $request, $username){
        $request->request->add(['username' => $username]);
        $user = App::call([new UserController, 'update_data']);
        $user['response']['user']['password'] = 'hidden';
        return view('admin.users.update', ['user' => $user['response']['user']]);
    }
    public function update_user(Request $request){
        $user = App::call([new UserController, 'update_data']);
        $request->request->add(['password' => $user['response']['user']['password']]);
        $user = App::call([new UserController, 'update']);
        return redirect('admin/users/table')->withSuccess($user['message']);
    }
    // -----USERS API METHODS ENDS-----
    /* */
    /* */
    /* */
    /* */
    /* */
    // -----SERVICES API METHODS-----
    public function services_table(Request $request){
        return view('admin.services.table');
    }
    public function services_data(Request $request){
        $request->request->add(['is_deleted' => 0]);
        return App::call([new ServiceController, 'read']);
    }
    public function services_suspended_table(Request $request){
        return view('admin.services.suspended_table');
    }
    public function services_suspended_data(Request $request){
        $request->request->add(['is_deleted' => 1]);
        return App::call([new ServiceController, 'read']);
    }
    public function create_service_page(Request $request){
        return view('admin.services.add');
    }
    public function create_service(Request $request){
        $service = App::call([new ServiceController, 'store']);

        if(!$service['success']){
            return redirect('admin/services/add')->withError($service['error']);
        }
        return redirect('admin/services/table')->withSuccess($service['message']);
    }
    public function suspend_service(Request $request){
        $request->request->add(['delete' => true]);
        App::call([new ServiceController, 'action']);
    }
    public function recover_service(Request $request){
        $request->request->add(['recover' => true]);
        App::call([new ServiceController, 'action']);
    }
    public function update_service_page(Request $request, $slug){
        $request->request->add(['slug' => $slug]);
        $service = App::call([new ServiceController, 'update_data']);
        return view('admin.services.update', ['service' => $service['response']['service']]);
    }
    public function update_service(Request $request){
        $service = App::call([new ServiceController, 'update']);

        if(!$service['success']){
            return redirect()->back()->withError($service['error']);
        }
        return redirect('admin/services/table')->withSuccess($service['message']);
    }
    // -----SERVICES API METHODS ENDS-----
    
}
