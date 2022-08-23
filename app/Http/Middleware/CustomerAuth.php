<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Auth;
use Closure;
class CustomerAuth
{

    public function handle($request, Closure $next) {
      	$isAuthenticatedAdmin = (Auth::guard('customer')->check() );
      	//This will be excecuted if the new authentication fails.
      	if (!$isAuthenticatedAdmin)
        {
          return response()->json(['status' => 0,'message' => 'unauthorize']);
        }

       return $next($request);
    }

}
