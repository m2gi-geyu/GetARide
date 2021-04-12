<?php


namespace App\Http\Controllers;


class HelpController
{
    /**
     * Fonction qui retourne la page d'explication du site
     * @return view la page Comment ça marche ?
     */
    function help(){
        return view('help');
    }
}
