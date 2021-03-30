<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    //protected $user; //TODO: Limiter la duplication de code (appeler User::where qu'une seule fois)

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
     * Renvoie la page du formulaire de modification des données du compte avec les données
     * actuelles du compte pour les afficher
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function form()
    {
        // Récupération des données du compte dans la BDD
        $user = User::where('username', '=', session()->get('LoggedUser')) -> first();
        return view('user/edit') -> with($user -> toArray()); // et accès à la page de modifications du compte avec les données de celui-ci à afficher
    }

    /**
     * Vérifie que les données du formulaire ne sont pas erronées avant de les envoyer vers
     * la fonction de mise à jour.
     * Si données erronées: affiche popup d'erreur avec liste des problèmes
     * @param  \Illuminate\Http\Request $request requête de l'utilisateur (données du formulaire)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function formSubmit(Request $request)
    {
        return $this -> formCheck($request);
    }

    public function formCheck(Request $request){
        // Récupération des données du formulaire
        $validator = Validator::make($request->all(),[
            'email' => 'required|max:255',
            'nom' => 'required|max:255|regex:/^[a-zA-Z0-9-_]+/i',
            'prenom' => 'required|max:255|regex:/^[a-zA-Z0-9-_]+/i',
            'mdp' => 'nullable|max:255|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[#?!@$%^&*-]).{8,}$/i',
            'tel' => 'required|min:10',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [ // Vérification des données du formulaire
            'tel.regex' => 'Téléphone doit être uniquement en chiffres',
            'email.required' => 'Email ne peut pas être vide.',
            'nom.required' => 'Nom ne peut pas être vide.',
            'prenom.required' => 'Prénom ne peut pas être vide.',
            'mdp.confirmed' => 'Confirmation différente du mot de passe.',
            'tel.required' => 'Numéro de téléphone ne peut pas être vide.',
            'email.max' => 'Email trop long.',
            'nom.max' => 'Nom trop long.',
            'prenom.max' => 'Prénom trop long.',
            'mdp.max' => 'Mot de passe trop long.',
            'mdp.regex' => 'Nouveau mot de passe incorrect : il faut au moins 8 caractères dont au moins un caractère spécial, une majuscule et une minuscule.',
            'nom.regex' => 'Nom incorrect : lettres minuscules/majuscules, chiffres et tirets seulement.',
            'prenom.regex' => 'Prénom incorrect : lettres minuscules/majuscules, chiffres et tirets seulement.',
            'avatar.mimes' => 'Format d image incorrect.',
            'avatar.max' => 'Image trop lourde.',
            'tel.min' => 'Numéro de téléphone trop court (il faut 10 chiffres).',
            'tel.max' => 'Numéro de téléphone trop long (il faut 10 chiffres.',
        ]);

        if($validator->fails()){ // Si formulaire erroné, message d'erreur et reste sur le formulaire
            return Redirect::back()->withErrors($validator)->withInput($request->all());
        }

        return $this -> updateAccount($request); // Tout est ok, donc on met à jour les données
    }

    /**
     * Après la vérification, effectue la mise à jour des données du compte de l'utilisateur avec
     * celles rentrées dans le formulaire
     * @param \Illuminate\Http\Request $request requête de l'utilisateur (données du formulaire)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAccount(Request $request){
        // Récupération des données du compte dans la BDD
        $user = User::where('username', '=', session()->get('LoggedUser')) -> first();
        // Mise à jour des données de l'utilisateur connecté
        //* Pas besoin de vérifier si le champ a été modifié, SQL ne fera pas d'Update si la donné est la même
        $user -> surname = $request -> nom;
        $user -> name = $request -> prenom;
        $user -> email = $request -> email;
        if ($request -> mdp != null){ // Si il y a un nouveau mot de passe...
            $user -> password = Hash::make($request -> mdp); //... On remplace l'actuel
        }
        $user -> phone = $request -> tel;
        $user -> gender = $request -> civilite;
        $user -> profile_pic = $request -> avatar;
        $user -> vehicle = $request -> voiture;

        $user -> save(); // Sauvegarder les changements
        return Redirect::back(); // Rediriger vers la même page (rafraîchir)
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

    public function quit_trip(int $idTrip){
        $user = User::where('username', '=', session()->get('LoggedUser')) -> first();
        $idRetrait=$user->id;
        return redirect()->action('App\Http\Controllers\RideController@delete_user_from_ride',['id'=>$idRetrait,'idTrip'=>$idTrip]);
    }
}
