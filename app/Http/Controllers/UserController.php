<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    //protected $user; //TODO: Limiter la duplication de code ()
    
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
     * Show the basic user informations and modifications fields.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function form()
    {
        // Récupération des données du compte dans la BDD
        $user = User::where('username', '=', session()->get('LoggedUser')) -> first();
        return view('user/edit') -> with($user -> toArray()); // et accès à la page de modifications du compte avec les données de celui-ci à afficher
    }

    /**
     * Show the basic user informations and modifications fields.
     * Fonction permettant à l'utilisateur de modifier les données de son compte
     * 
     * @param  \Illuminate\Http\Request $request requête de l'utilisateur (données du formulaire)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function formSubmit(Request $request)
    {
        // Récupération des données du formulaire
        $validator = Validator::make($request->all(),[
            'email' => 'required|max:255',
            'nom' => 'required|max:255|regex:/^[a-zA-Z0-9-_]+/i',
            'prenom' => 'required|max:255|regex:/^[a-zA-Z0-9-_]+/i',
            'mdp' => 'required|max:255|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[#?!@$%^&*-]).{8,}$/i',
            'tel' => 'required|min:10',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [ // Vérification des données du formulaire
            'email.required' => 'Email ne peut pas être vide.',
            'nom.required' => 'Nom ne peut pas être vide.',
            'prenom.required' => 'Prénom ne peut pas être vide.',
            'mdp.required' => 'Mot de passe ne peut pas être vide.',
            'mdp.confirmed' => 'Confirmation différente du mot de passe.',
            'tel.required' => 'Numéro de téléphone ne peut pas être vide.',
            'email.max' => 'Email trop long.',
            'nom.max' => 'Nom trop long.',
            'prenom.max' => 'Prénom trop long.',
            'mdp.max' => 'Mot de passe trop long.',
            'mdp.regex' => 'Mot de passe incorrect : il faut au moins 8 caractères dont au moins un caractère spécial, une majuscule et une minuscule.',
            'nom.regex' => 'Nom incorrect : lettres minuscules/majuscules, chiffres et tirets seulement.',
            'prenom.regex' => 'Prénom incorrect : lettres minuscules/majuscules, chiffres et tirets seulement.',
            'avatar.mimes' => 'Format d image incorrect.',
            'avatar.max' => 'Image trop lourde.',
            'tel.min' => 'Numéro de téléphone trop court (il faut 10 chiffres).',
        ]);
        
        if($validator->fails()){ // Si formulaire erroné, message d'erreur et reste sur le formulaire
            return Redirect::back()->withErrors($validator)->withInput($request->all());
        }
        // TODO: vérifier si les données ont changées avant d'update pour n'update que celles-ci
        // Récupération des données du compte dans la BDD
        $user = User::where('username', '=', session()->get('LoggedUser')) -> first();
        // Mise à jour des données de l'utilisateur connecté
        $user -> surname = $request -> nom;
        $user -> name = $request -> prenom;
        $user -> email = $request -> email;
        $user -> password = Hash::make($request -> mdp);
        $user -> phone = $request -> tel;
        $user -> gender = $request -> civilite;
        $user -> profile_pic = $request -> avatar;
        $user -> vehicle = $request -> voiture;

        $user -> save(); // Sauvegarder les changements
        return Redirect::back();
    }

    /**
     * Show the basic user informations and modifications fields.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function deleteUserAccount()
    {
        //TODO: Confirmer la suppression du compte (avec le mot de passe). Pour l'instant ça rafraîchit juste la page        
        return Redirect::back();
    }
}
