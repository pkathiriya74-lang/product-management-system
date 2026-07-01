<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next,String $role): Response
    {
        if(!Auth::check()){
            return redirect('/login');
        }

        if(Auth::user()->role != $role){
            abort(403,'Unauthorized');
        }
        return $next($request);
    }
}
