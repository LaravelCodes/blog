<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /* AJAX DATA LOAD */
    public function read(Request $request){
        // return $request->all();
        if ($request->ajax()) {
            $data = Service::where('is_deleted', $request->get('is_deleted'));

            $recordsTotal = $data->count();

            // Filters 
            if ($request->has('search')) {
                $data = $data->where('name','LIKE', '%'.$request->get('search')['value'].'%')
                            ->orWhere('slug','LIKE', '%'.$request->get('search')['value'].'%')
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

            $service['draw'] = intval($request->get('draw'));
            $service['recordsTotal'] = $recordsTotal;
            $service['data'] = $data->get();
            $service['recordsFiltered'] = $recordsFiltered;
            return $service;
        }
    }

    public function store(Request $request){

        $validatedData = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:512',
                'slug' => 'required|string|unique:services,slug',
            ],
            [
                'required' => 'Please fill out :attribute field',
                'unique' => 'This :attribute is already registered'
            ],
            [
                'name' => 'Name',
                'slug' => 'Slug',
            ]
        );
        if ($validatedData->fails()){
            return ['success'=>false, 'response'=>[], 'error'=>$validatedData->errors()->first(), 'message'=> ''];
        };

        $service = new Service;
        $service->name = $request->input('name');
        $service->slug = $request->input('slug');
        $service->save();
    
        return ['success'=>true, 'response'=>['service'=>$service], 'error'=>'', 'message'=> 'Service Created Successfully'];
    }

    /* Get Single Service For Update */
    public function update_data(Request $request){

        // Slug IN CASE FOR PARTICUAR Service
        if(!empty($request->input('slug'))){
            $service = Service::where('slug', $request->input('slug'))->first();

            if($service === null){
            return ['success'=>false, 'response'=>[], 'error'=>'Services database is empty or Slug is invalid', 'message'=> ''];
            }
            $serviceData = $service->toArray();
            return ['success'=>true, 'response'=>['service'=>$serviceData], 'error'=>'', 'message'=> $serviceData['name'].' Retrived'];
        }
    }

    /* Update Service */
        
    public function update(Request $request){

        $service = Service::where('slug', $request->input('old_slug'))->first();

        $validatedData = Validator::make(
            $request->all(),
            [
                'name' => 'string|max:512',
                'slug' => 'string|max:512|unique:services,slug,'.$service->id,
            ],
            [
                'required' => 'Please fill out :attribute field',
                'unique' => 'This :attribute is already registered'
            ],
            [
                'name' => 'Name',
                'slug' => 'Slug',
            ]
        );
        if ($validatedData->fails()){
            return ['success'=>false, 'response'=>[], 'error'=>$validatedData->errors()->first(), 'message'=> ''];
        };

        // IF ADMIN WISHES TO CHANGE NAME
        if(!empty($request->input('name'))){
            $service->name = $request->input('name');
        }

        // IF ADMIN WISHES TO CHANGE NAME
        if(!empty($request->input('slug'))){
            $service->slug = $request->input('slug');
        }
        
        $service->save();

        return ['success'=>true, 'response'=>['service'=>$service->toArray()], 'error'=>'', 'message'=> $service->name.' Updated Successfully!'];
    }

    /* Service Action */
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

    /* Read All Services */
    public function readForUser(Request $request){
        $services = Service::where('is_deleted', 0)->get()->toArray();
        return ['success'=>true, 'response'=>['services'=>$services], 'error'=>'', 'message'=> 'All Users Retrived'];
    }
    /* Pluck All Slugs */
    public function slugs(Request $request){
        return Service::where('is_deleted', 0)->pluck('slug')->toArray();
    }
    
}
