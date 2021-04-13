<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;


/**
 * Class UserAuthController --> controller d'authentification de l'utilisateur
 * @package App\Http\Controllers
 */
class UserAuthController extends Controller
{


    public function home(){
        return view('welcome');
    }
    /**
     * Fonction login retournant la page/vue de connexion
     * @return view la page/vue de connexion
     */
    function login(){
        if(session()->has('LoggedUser')){
            return redirect('dashboard');
        }
        return view('auth/login');
    }


    /**
     * Fonction register retournant la page/vue d'inscription / de création de compte
     * @return view  la page/vue de connexion
     */
    function register(){
        if(session()->has('LoggedUser')){
            return redirect('dashboard');
        }
        return view('auth/register');
    }

    /**
     * Fonction permettant à utilisateur de créer un compte
     * @param Request $request requête de l'utilisateur (données du formulaire)
     * @return back un message positif si l'inscription s'est bien déroulée, un message négatif sinon
     */
    function create (Request $request){
        $request ->validate([
           'username'=> 'required|max:255|unique:users|regex:/^[a-zA-Z0-9-_]+/i',
            'surname'=> 'required|max:255|regex:/^[a-zA-Z-_]+/i',
            'name'=> 'required|max:255|regex:/^[a-zA-Z-_]+/i',
            'email' => 'required|max:255|email|unique:users',
            'password' => 'required|min:8|confirmed|max:255|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[#?!@$%^&*-;.]).{8,}$/i',
            //'password_confirmation' => 'required|min:8|max:255|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[#?!@$%^&*-;.]).{8,}$/i',
            'phone' => ['required','unique:users','regex:/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/'],
            'gender' => 'required',
            'vehicle' => 'required',
            'mail_notifications' =>'required',
            'profile_pic'=>'nullable|max:2048',
            'about'=>'nullable|max:255'
        ],[ // Vérification des données du formulaire
            'phone.regex' => 'Numéro de téléphone incorrect',
            'email.required' => 'Email ne peut pas être vide.',
            'surname.required' => 'Nom ne peut pas être vide.',
            'name.required' => 'Prénom ne peut pas être vide.',
            'phone.required' => 'Numéro de téléphone ne peut pas être vide.',
            'gender.required' => 'La civilité ne peut pas être vide ne peut pas être vide.',
            'email.max' => 'Email trop long.',
            'surname.max' => 'Nom trop long.',
            'name.max' => 'Prénom trop long.',
            'password.max' => 'Mot de passe trop long.',
            'password.regex' => 'Mot de passe incorrect : il faut au moins 8 caractères dont au moins un caractère spécial, une majuscule et une minuscule.',
            'password.confirmed' => 'Veuillez bien retapez le même mot de passe dans les 2 champs svp.',
            //'password_confirmation.max' => 'Mot de passe trop long.',
            //'password_confirmation.regex' => 'Mot de passe incorrect : il faut au moins 8 caractères dont au moins un caractère spécial, une majuscule et une minuscule.',
            'surname.regex' => 'Nom incorrect : lettres minuscules/majuscules, chiffres et tirets seulement.',
            'name.regex' => 'Prénom incorrect : lettres minuscules/majuscules, chiffres et tirets seulement.',
            'profile_pic.mimes' => "Format d'image incorrect.",
            'profile_pic.max' => 'Image trop lourde.',
        ]);


        $user= new User; //création d'un user et récolte des données entrées
        $user->username = $request->username;
        $user->surname = $request->surname;
        $user->name = $request->name;
        $user->email = $request->email;


        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->about = $request ->about;

        if($request->vehicle == 'non')
        {
            $user->vehicle = false;
        }
        else
        {
            $user->vehicle = true;
        }

        if($request->mail_notifications == 'non'){
            $request->mail_notifications = false;
        }else{
            $request->mail_notifications = true;
        }


        //ici on stocke l'image de l'utilisateur dansl'arborescence suivante dans le dossier storage --> public/pseudo_de_l'user/l'image.extension
        if($request->hasFile('profile_pic')){
            $filename = $request->profile_pic->getClientOriginalName();
            $request->profile_pic->storeAs($user->username,$filename,'public');
            $user->profile_pic = $filename;
        }else{
            //sinon on crée un dossier vide dans public/storage
            $path =  'storage/'.$user->username;
            mkdir($path, 0777, true);
        }

        $query = $user ->save(); //sauvegarde des infos dans la base de données (table users)
        if($query){
            event(new Registered($user));
            return back()->with('success','Votre compte a été crée avec succès');
        }else{
            return back()->with('fail','OUPS! Il y a une erreur...');
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
                if($user->email_verified_at==null){
                    return redirect()->route("verification.notice",['id'=>$user->id]);
                }
                $request->session()->put("LoggedUser", $user->username); //LoggedUser est la variable de session
                $request->session()->put("LoggedUserPic", $user->profile_pic);
                $request->session()->put("LoggedUserID",$user->id);
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
            session()->pull("LoggedUserPic");
            session()->pull("LoggedUserID");
        }
        return redirect('login');
    }


}
