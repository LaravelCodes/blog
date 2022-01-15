<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FixarAdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if(!$request->session()->has('admin_login')){
            return redirect('/admin/login')->withError('Not Logged In !');
        }
        return $next($request);
    }
}
