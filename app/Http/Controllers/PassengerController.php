<?php


namespace App\Http\Controllers;


use App\Models\Trip;
use App\Models\User;

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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * passager veut retrait d'un trajet rejoint
     * @param int $idRide:id de trajet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteJoinedRide(int $idRide){
        $user = User::where('username', '=', session()->get('LoggedUser')) -> first();
        $idUser=$user->id;
        $select=DB::select('link_user_trip where id_trip=?',[$idRide]);
        if($select->validated==true) {
            $idUser = $user->id;
            return redirect()->action('App\Http\Controllers\RideController@delete_user_from_ride', ['id' => $idUser, 'idTrip' => $idRide]);
        } else {
            return back()->with("la réponse n'est pas confirmé,interdit d'annuler");
        }
    }

    public function deletdAnswerRide(int $idRide){
        $user = User::where('username', '=', session()->get('LoggedUser')) -> first();
        $idUser=$user->id;
        $select=DB::select('link_user_trip where id_trip=?',[$idRide]);
        if($select->validated==false) {
            return redirect()->action('App\Http\Controllers\RideController@delete_user_from_ride', ['id' => $idUser, 'idTrip' => $idRide]);
        } else{
            return back()->with("la réponse est confirmé,interdit d'annuler");
        }
    }

}
