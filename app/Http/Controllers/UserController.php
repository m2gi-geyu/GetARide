<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /*        $this->middleware('auth');*/
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
        return view('user/edit');
    }

    /**
     * Fonction permettant à l'utilisateur de modifier les données de son compte
     * @param Request $request requête de l'utilisateur (données du formulaire)
     * @return back un message positif si la modification s'est bien déroulée, négatif sinon
     */
    public function formSubmission(Request $request){
        return back() -> with('success', 'Données du compte mise à jour');
    }

    /**
     * Show the basic user informations and modifications fields.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function deleteAccountUser()
    {
        /*manque confirmation*/
        return view('user.edit');
    }

    /**
     * Show the basic user informations and modifications fields.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkEditUser(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|max:255',
            'nom' => 'required|max:255|regex:/^[a-zA-Z0-9-_]+/i',
            'prenom' => 'required|max:255|regex:/^[a-zA-Z0-9-_]+/i',
            'mdp' => 'required|max:255|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[#?!@$%^&*-]).{8,}$/i',
            'tel' => 'required|min:10',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
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
        if($validator->fails()) return Redirect::back()->withErrors($validator)->withInput($request->all());
        return Redirect::back();
        //faire les modif en bdd
    }
}
