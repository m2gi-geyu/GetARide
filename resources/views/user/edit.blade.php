@extends('layouts.sidebar')
<link href="{{ asset('/css/user_edit.css') }}" rel="stylesheet" type="text/css" >
@section('content')
    <form class="col-md-8" action="{{ route('editUserForm') }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="form-group row">

                <div class="col-md-3 col-form-label my-auto" >
                        <img src="{{ asset('/images/avatar_gros.png') }}" class="resize" alt="avatar">
                </div>
                <div class="custom-file col-md-9 avatar my-auto">
                    <input type="file" class="custom-file-input" id="avatar" name="avatar">
                    <label class="custom-file-label input-avatar" for="avatar"> Changer ma photo de profil @if(old('avatar')) : {{ old('avatar') }} @endif</label>
                </div>


                <label class="col-md-3 col-form-label label-modif" for="email">Adresse E-Mail </label>
                <div class="col-md-9">
                    <input class="form-control input-modif" type="email" name="email" id="email" value="{{ old('email') }}">
                </div>

                <label class="col-md-3 col-form-label label-modif" for="mdp">Nouveau mot de passe </label>
                <div class="col-md-9">
                    <input class="form-control input-modif" type="password" name="mdp" id="mdp" value="{{ old('mdp') }}">
                </div>

                <label class="col-md-3 col-form-label label-modif" for="mdp_confirmation">Répéter le mot de passe </label>
                <div class="col-md-9">
                    <input class="form-control input-modif" type="password" name="mdp_confirmation" id="mdp_confirmation" value="{{ old('mdp_confirmation') }}">
                </div>

                <label class="col-md-3 col-form-label label-modif" for="nom">Nom </label>
                <div class="col-md-9">
                    <input class="form-control input-modif" type="text" name="nom" id="nom" value="{{ old('nom') }}">
                </div>

                <label class="col-md-3 col-form-label label-modif" for="prenom">Prénom </label>
                <div class="col-md-9">
                    <input class="form-control input-modif" type="text" name="prenom" id="prenom" value="{{ old('prenom') }}">
                </div>

                <label class="col-md-3 col-form-label label-modif" for="civilite_H">Civilité </label>
                <div class="col-md-9 radio-group">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="civilite_H" name="civilite" class="custom-control-input" value="H" @if(old('civilite') == 'H') checked @endif>
                        <label class="custom-control-label radio-before text-left radio-bold" for="civilite_H">Mr</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="civilite_F" name="civilite" class="custom-control-input" value="F" @if(old('civilite') == 'F') checked @endif>
                        <label class="custom-control-label radio-before text-left radio-bold" for="civilite_F">Mme</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="civilite_A" name="civilite" class="custom-control-input" value="A" @if(old('civilite') == 'A') checked @endif>
                        <label class="custom-control-label radio-before text-left radio-bold" for="civilite_A">Autre</label>
                    </div>
                </div>

                <label class="col-md-3 col-form-label label-modif" for="tel">Téléphone </label>
                <div class="col-md-9">
                    <input class="form-control input-modif" type="tel" name="tel" id="tel" value="{{ old('tel') }}">
                </div>

                <label class="col-md-3 col-form-label label-modif" for="voiture_oui">Voiture </label>
                <div class="col-md-9 radio-group">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="voiture_oui" name="voiture" class="custom-control-input" value="1" @if(old('voiture')) checked @endif>
                        <label class="custom-control-label radio-before radio-bold" for="voiture_oui">Oui</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="voiture_non" name="voiture" class="custom-control-input" value="0" @if(!old('voiture')) checked @endif>
                        <label class="custom-control-label radio-bold" for="voiture_non">Non</label>
                    </div>
                </div>

        </div>

        <div class="form-group row">
            <div class="col-md-8 text-right">
                <button type="submit" class="btn-form">Enregistrer les changements</button>
            </div>
            <div class="col text-right">
                <a href="{{ url("user/delete") }}" type="button" class="btn-form delete_button">Supprimer mon compte</a>
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
