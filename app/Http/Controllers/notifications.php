<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class notifications extends Controller
{
    public function view()
    {

        $username = session()->get('LoggedUser'); // pseudo de l'utilisateur connecté
        $user = User::where('username', '=', $username)->first();

        
        return view('user/notifications',['notifications'=>$user->getNotification()]);
        
    }

    public function deleteNotification (Request $request)
    {
        $username = session()->get('LoggedUser'); // pseudo de l'utilisateur connecté
        $user = User::where('username', '=', $username)->first();

        DB::table('notifications')
            ->where('id_user', '=', $user->id)
            ->where('id', '=', $request->input('id'))
            ->delete();

        return response()->json(['status'=> 'OK']);
        


    }

}
