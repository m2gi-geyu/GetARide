<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserAuthController extends Controller
{
    function login(){
        return view('auth/login');
    }

    function register(){
        return view('auth/register');
    }

    function create (Request $request){
        $request ->validate([
           'username'=> 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'required',
            'vehicle' => 'required'
        ]);

        $user= new User;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->vehicle = $request->vehicle;

        $query = $user ->save();

        if($query){
            return back()->with('success','You have been successfully registered');
        }else{
            return back()->with('fail','Something went wrong');
        }
    }

    function check(Request $request){
        return $request->validate([
            'email' => 'required',
            'password'=>'required| min:8'
        ]);

        $user = User::where('email','=', $request->email)->first() ;

        if($user){
            if(Hash::check($request->password, $user->password)){
                return redirect('welcome');
            }else{
                return back()->with('fail','Invalid password');
            }
        }else{
            return back()->with('fail','Invalid password');
        }
    }

    function logout(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect('login');
        }
    }


}
