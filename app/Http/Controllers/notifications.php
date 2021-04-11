<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redirect;

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
            ->where('id', '=', $request->input('id'))
            ->delete();


        return back()->with('success','notification supprimée.');
    }

    public function readNotification (Request $request)
    {
        $username = session()->get('LoggedUser'); // pseudo de l'utilisateur connecté
        $user = User::where('username', '=', $username)->first();

        $user->unreadNotifications->where('id', $request->input('id'))->markAsRead();

        return response()->json(['status'=> 'OK']);
    }

    public function deleteAllNotifications(Request $request)
    {
        $username = session()->get('LoggedUser'); // pseudo de l'utilisateur connecté
        $user = User::where('username', '=', $username)->first();

        $user->notifications()->delete();

        return Redirect::back();
    }

    public function desactivateAllNotifications (Request $request)
    {
        //Todo desactivate all notifs
        return Redirect::back();
    }
}
