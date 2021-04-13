@extends('layouts.regular_no_sidebar')
<link href="{{ asset('/css/user.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('/css/welcome.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('/css/help.css') }}" rel="stylesheet" type="text/css" >
@section('content')
    <div class="notice">
        <h2>Comment ça marche ?</h2><br/>
        <h3>Get a Ride, qu'est-ce que c'est?</h3><br/>

        <p>Get a Ride est une plateforme de covoiturage visant à faciliter les voyages d'une ville A à une ville B,
        tout en permettant à ses utilisateurs de réaliser des économies et d'adopter un comportement plus écologique.</p><br/><br/>



        <h3>Comment créer une proposition de trajet?</h3><br/>

        <p>Si vous n'avez pas coché la case "Oui" pour la questiion "Possède véhicule" lors de l'inscription, vous ne pouvez pas créer de trajet.
        Pour créer un trajet il faut se rendre sur la page "Créer un trajet", il faut rentrer une ville de départ, la date de départ, l'heure de départ,
        quelques précisions sur le trajet comme le lieu de rendez-vous par exemple, une ville d'arrivée, le nombre de places disponibles, le prix d'une place en euros,
        des contraintes si vous en avez comme par exemple "pas d'animal à bord", et des villes étapes où vous souhaitez vous arrêter si vous le souhaitez.

        Par la suite, si vous cochez la case "Public", votre trajet sera disponible pour tous les usagers de la plateforme. Sinon, si vous cochez la case "Privé", il faudra choisir l'un des groupes privés que vous avez créé
        pour diffuser votre offre de trajet aux membres de ce groupe.

        ATTENTION, vous pouvez toujours supprimer vos trajets crées jusqu'à 24H avant le départ, s'il reste moins de 24H, il est impossible de supprimer le trajet.</p><br/><br/>


        <h3>Comment changer les informations de mon profil?</h3><br/>

        <p>En vous dirigeant sur la page "Modifier mon compte" vous pouvez modifier vos données comme votre photo de profil, votre mot de passe ou bien l'attibut "Possède voiture".
            Si nos notifications par mail polluent votre boîte de réception, vous pouvez aussi désactiver cette fonctionnalité! ;)</p><br/><br/>


        <h3>Comment demander à rejoindre un trajet?</h3><br/>
        <p>Pour demander à rejoindre un trajet, il faut vous rendre sur la page de recherche de trajet, y rentrer vos critères de recherche, et si un trajet vous convient vous pouvez cliquer
        sur le bouton "Participer à ce trajet". Il faudra attendre la confirmation du créateur de ce trajet. Si vous êtes accepté pour ce trajet, vous pouvez vous retirer jusqu'à 24H avant le départ,
            s'il reste moins de 24H, il est impossible de supprimer le trajet."</p><br/><br/>
        <h3>Comment créer un groupe?</h3><br/>
        <p>Si vous n'avez pas coché la case "Oui" pour la questiion "Possède véhicule" lors de l'inscription, vous ne pouvez pas créer de groupe.

        Pour créer un groupe il faut se rendre sur la page "Créer un groupe", il faut rentrer une nom de groupe que vous n'avez pas déjà utilisé, ensuite vous êtes redirigé vers une page où vous pouvez rechercher et ajouter des utilisateurs de la plateforme via leurs pseudos.
            Vous pouvez modifier ou bien supprimer l'un de vos groupes via la page "Mes groupes créés".</p><br/><br/>
        <a href="{{ route('dashboard') }}" type="button" class="btn-perso-blue" style="padding-top: 0.3vw; text-decoration: none; color: white">Se diriger vers l'accueil</a>
    </div>
@endsection
