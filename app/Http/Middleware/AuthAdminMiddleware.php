<?php

namespace App\Http\Middleware;

use Closure;

class AuthAdminMiddleware
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
        if(!checkAdminAuth()){
            return redirect('/admin');
        }
        return $next($request);
    }
}
