<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


/**
 * Class AuthCheck servant à vérifier si l'utilisateur est connecté
 * @package App\Http\Middleware
 */
class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if(!session()->has('LoggedUser')){
            return redirect('login')->with('fail','You must be logged in');
        }
        return $next($request);
    }
}
