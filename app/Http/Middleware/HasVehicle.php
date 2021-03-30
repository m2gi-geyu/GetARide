<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class HasVehicle
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
            return redirect('login')->with('fail','Vous devez être connecté pour accéder à cette page');
        }else{
            $username = session()->get('LoggedUser'); // pseudo de l'utilisateur connecté
            $user = User::where('username', '=', $username)->first();
            if($user->vehicle==false){
                return redirect('dashboard')->with('fail','Il faut que vous ayez un véhicule pour créer un groupe');
            }
        }
        return $next($request);
    }
}
