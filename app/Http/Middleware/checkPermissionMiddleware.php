<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class checkPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $currentRouteName = Route::currentRouteName();

        if(stristr($currentRouteName,'update') || stristr($currentRouteName,'store') || stristr($currentRouteName,'detail') )
            return $next($request);
//        if(!Auth::user()->hasPermissions($currentRouteName) ){
//          return $next($request);
//        }
//        else {
//           return redirect('admin/unauthorize')->with('error','Permission Denied!');
//        }
        return $next($request);
//        return redirect()->back()->with('error','Permission Denied!');
    }
}
