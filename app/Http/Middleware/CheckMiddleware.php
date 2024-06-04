<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    
    public function handle(Request $request, Closure $next): Response
    {
        $roles = ["ADMIN", "TIM DAPUR"];
        foreach($roles as $role) {
            if(Auth::user()->role->nama_role === $role) {
                return $next($request); 
            }
        } 
        abort(403, 'Anda tidak memiliki hak untuk mengakses halaman ini.');
    }
}
