<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FixarAuth
{
    public function handle(Request $request, Closure $next)
    {
        if($request->header('token') !== sha1('FixarWorldOnlineInternational')){
            return response()->json([
                'status'=> 500,
                'success'=> false,
                'error' => 'Token Is Incorrect',
                'message' => '',
                'response'=> '',
            ],500);
        }
        return $next($request);
    }
}
