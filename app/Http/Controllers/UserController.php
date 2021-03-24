<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
