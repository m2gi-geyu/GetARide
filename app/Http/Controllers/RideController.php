<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Psr\Log\NullLogger;

class RideController extends Controller
{
    //


    public function create_ride_form()
    {

        $driver=Auth::id();

        $data = DB::select('SELECT * FROM `groups` WHERE id_creator=:id',['id'=>"1"]);
        return view('trip.create_trip',['data'=>$data]);
    }

    public function create_ride_form_submission(Request $request){
        //vérification des champs obligatoires
        $request->validate([
            'departure'=> 'required',
            'date'=>'required',
            'time'=>'required',
            'final'=>'required',
        ]);
/*
        $ride = new Ride;
        $ride->price = $request->price;
        $ride->nb_passengers = $request->nb_passengers;
        if($request->privacy == 'public'){
            $ride->isprivate = false;
        }else{
            $ride->isprivate = true;
            $ride->group = $request->group
        }
        $query = $ride->save();

        if($query){

        }else{

        }*/


        //return view('dashboard', Null );
    }


}
