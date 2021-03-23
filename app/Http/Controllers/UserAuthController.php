<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


/**
 * Class UserAuthController --> controller d'authentification de l'utilisateur
 * @package App\Http\Controllers
 */
class UserAuthController extends Controller
{

    /**
     * Fonction login retournant la page/vue de connexion
     * @return view la page/vue de connexion
     */
    function login(){
        return view('auth/login');
    }


    /**
     * Fonction register retournant la page/vue d'inscription / de création de compte
     * @return view  la page/vue de connexion
     */
    function register(){
        return view('auth/register');
    }

    /**
     * Fonction permettant à utilisateur de créer un compte
     * @param Request $request requête de l'utilisateur (données du formulaire)
     * @return back un message positif si l'inscription s'est bien déroulée, un message négatif sinon
     */
    function create (Request $request){
        $request ->validate([
           'username'=> 'required|unique:users',
            'surname'=> 'required',
            'name'=> 'required|',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'required|unique:users',
            'gender' => 'required',
            'vehicle' => 'required'
        ]);

        $user= new User; //création d'un user et récolte des données entrées
        $user->username = $request->username;
        $user->surname = $request->surname;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->gender = $request->gender;

        if($request->vehicle == 'non')
        {
            $user->vehicle = false;
        }
        else
        {
            $user->vehicle = true;
        }




        //$user->ratings=NULL;

        $query = $user ->save(); //sauvegarde des infos dans la base de données (table users)

        if($query){
            return back()->with('success','You have been successfully registered');
        }else{
            return back()->with('fail','Something went wrong');
        }
    }


    /**
     * Fonction permettant à un utilisateur ayant déjà un compte de se connecter
     * @param Request $request requête de l'utilisateur (données du formulaire de donnexion)
     * @return . la page de bienvenue la connexion s'est bien faite, un message d'erreur sinon
     */
    function check(Request $request){
        $request->validate([
            'email' => 'required',
            'password'=>'required| min:8'
        ]);

        $user = User::where('email','=', $request->email)->first();
        if($user==null){
            //return back()->with('fail','user is null');
            $user = User::where('username','=', $request->email)->first();
        }

        if($user){
            if(Hash::check($request->password, $user->password)){
                $request->session()->put("LoggedUser", $user->username); //LoggedUser est la variable de session

                return redirect('dashboard');
            }else{
                return back()->with('fail','Invalid password');
            }
        }else{
            return back()->with('fail','No account found for this email/username');
        }
    }


    /**
     * Fonction vérifiant la session active de l'utilisateur qui veut accéder à sa page de bienvenue
     * @return dashboard ----> la page de bienvenue de l'utilisateur si ce dernier est connecté
     */
    function dashboard(){

        if(session()->has('LoggedUser')){
            $user = User::where('username','=',session('LoggedUser'))->first();
            $data = [
                'LoggedUserInfo'=>$user
            ];

        }
        return view('dashboard', $data);
    }

    /**
     * Fonction permettant à un utilisateur de se déconnecter
     * @return la page de dconnexion
     */
    function logout(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect('login');
        }
    }


}
