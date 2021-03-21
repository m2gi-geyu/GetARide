@extends('layouts.sidebar')
<link href="{{ asset('/css/user_edit.css') }}" rel="stylesheet" type="text/css" >
@section('content')
    <form class="col-md-8" action="{{ url('users/edit') }}" method="POST">
        @csrf
            <div class="form-group row">

                <div class="col-md-3 col-form-label my-auto" >
                        <img src="{{ asset('/images/avatar_gros.png') }}" class="resize" alt="avatar">
                </div>
                <div class="custom-file col-md-9 avatar my-auto">
                    <input type="file" class="custom-file-input" id="avatar" name="avatar">
                    <label class="custom-file-label input-avatar" for="avatar">Changer ma photo de profil</label>
                </div>


                <label class="col-md-3 col-form-label label-modif" for="email">Adresse E-Mail </label>
                <div class="col-md-9">
                    <input class="form-control input-modif" type="text" name="email" id="email">
                </div>

                <label class="col-md-3 col-form-label label-modif" for="mdp">Nouveau mot de passe </label>
                <div class="col-md-9">
                    <input class="form-control input-modif" type="password" name="mdp" id="mdp">
                </div>

                <label class="col-md-3 col-form-label label-modif" for="rmdp">Répéter le mot de passe </label>
                <div class="col-md-9">
                    <input class="form-control input-modif" type="password" name="rmdp" id="rmdp">
                </div>

                <label class="col-md-3 col-form-label label-modif" for="nom">Nom </label>
                <div class="col-md-9">
                    <input class="form-control input-modif" type="text" name="nom" id="nom">
                </div>

                <label class="col-md-3 col-form-label label-modif" for="prenom">Prénom </label>
                <div class="col-md-9">
                    <input class="form-control input-modif" type="text" name="prenom" id="prenom">
                </div>

                <label class="col-md-3 col-form-label label-modif" for="sexe_H">Civilité </label>
                <div class="col-md-9 radio-group">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sexe_H" name="sexe" class="custom-control-input">
                        <label class="custom-control-label radio-before text-left radio-bold" for="sexe_H">Mr</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sexe_F" name="sexe" class="custom-control-input">
                        <label class="custom-control-label radio-bold" for="sexe_F">Mme</label>
                    </div>
                </div>

                <label class="col-md-3 col-form-label label-modif" for="tel">Téléphone </label>
                <div class="col-md-9">
                    <input class="form-control input-modif" type="text" name="tel" id="tel">
                </div>

                <label class="col-md-3 col-form-label label-modif" for="voiture_oui">Voiture </label>
                <div class="col-md-9 radio-group">
                    <div class="custom-control custom-radio custom-control-inline">
                        <label class="custom-control-label radio-before radio-bold" for="voiture_oui">Oui</label>
                        <input type="radio" id="voiture_oui" name="voiture" class="custom-control-input">
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="voiture_non" name="voiture" class="custom-control-input">
                        <label class="custom-control-label radio-bold" for="voiture_non">Non</label>
                    </div>
                </div>

        </div>

        <div class="form-group row">
            <div class="col-md-8 text-right">
                <button type="submit" class="btn-form">Enregistrer les changements</button>
            </div>
            <div class="col text-right">
                <button type="button" class="btn-form">Supprimer mon compte</button>
            </div>
        </div>
    </form>


{{--    @php--}}
{{--    $test = 3.5;--}}
{{--    @endphp--}}

{{--    @for ($i = 0; $i < 5; $i++)--}}
{{--        @if ($test > $i)--}}
{{--            <span class="fa fa-star checked_orange" style="color: orange"></span>--}}
{{--        @else--}}
{{--            <span class="fa fa-star"></span>--}}
{{--        @endif--}}
{{--    @endfor--}}
@endsection
