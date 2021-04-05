<?php


namespace App\Http\Controllers;
use App\Models\LinkUserTrip;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PassengerController extends Controller
{

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        /*$this->middleware('auth');*/
    }

    /**
     * passager veut retrait d'un trajet rejoint
     * @param int $idRide:id de trajet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteJoinedRide(int $idRide){
        $user = User::where('username', '=', session()->get('LoggedUser')) -> first();
        $idUser=$user->id;
        $link_trip=LinkUserTrip::where("id_trip",$idRide)->where("id_user",$idUser)->first();
        if($link_trip->validated==true) {
            return redirect()->route('trip/delete_user', ['id' => $idUser, 'idRide' => $idRide]);
        } else {
            return back()->with("la réponse n'est pas confirmé,interdit d'annuler");
        }
    }

    public function deletdAnswerRide(int $idRide){
        $user = User::where('username', '=', session()->get('LoggedUser')) -> first();
        $idUser=$user->id;
        $link_trip=LinkUserTrip::where("id_trip",$idRide)->where("id_user",$idUser)->first();
        if($link_trip->validated==false) {
            return redirect()->route('trip/delete_user', ['id' => $idUser, 'idRide' => $idRide]);
        } else{
            return back()->with("la réponse est confirmé,interdit d'annuler");
        }
    }

}
