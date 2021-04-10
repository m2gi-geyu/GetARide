@extends('layouts.sidebar')
<link href="{{ asset('/css/user.css') }}" rel="stylesheet" type="text/css" >
@section('content')
    <script src="{{ asset('js/user.js') }}" defer></script>
    <form class="col-md-8" action="{{ route('editUser') }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="form-group row">
                <div class="col-md-3 col-form-label my-auto" >
                        <img src="{{ $profile_pic ? asset('storage/'.$username.'/'.$profile_pic) : asset('/images/avatar_gros.png') }}" id="output" class="resize" alt="avatar">
                </div>
                <div class="custom-file col-md-9 avatar my-auto">
                    <input type="file" class="custom-file-input" id="avatar" name="avatar" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                    <label class="custom-file-label input-avatar" for="avatar"> Changer ma photo de profil @if(old('avatar')) : {{ old('avatar') }} @endif</label>
                </div>

                <label class="col-md-3 col-form-label label-modif" for="email">Adresse E-Mail </label>
                <div class="col-md-9">
                    <input class="form-control input-modif" type="email" name="email" id="email" value="{{ old('email', $email) }}">
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
                    <input class="form-control input-modif" type="text" name="nom" id="nom" value="{{ old('nom', $surname) }}">
                </div>

                <label class="col-md-3 col-form-label label-modif" for="prenom">Prénom </label>
                <div class="col-md-9">
                    <input class="form-control input-modif" type="text" name="prenom" id="prenom" value="{{ old('prenom', $name) }}">
                </div>

                <label class="col-md-3 col-form-label label-modif" for="civilite_H">Civilité </label>
                <div class="col-md-9 radio-group">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="civilite_H" name="civilite" class="custom-control-input" value="H" @if(old('civilite', $gender) == 'H') checked @endif>
                        <label class="custom-control-label radio-before text-left radio-bold" for="civilite_H">Mr</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="civilite_F" name="civilite" class="custom-control-input" value="F" @if(old('civilite', $gender) == 'F') checked @endif>
                        <label class="custom-control-label radio-before text-left radio-bold" for="civilite_F">Mme</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="civilite_A" name="civilite" class="custom-control-input" value="A" @if(old('civilite', $gender) == 'A') checked @endif>
                        <label class="custom-control-label radio-before text-left radio-bold" for="civilite_A">Autre</label>
                    </div>
                </div>

                <label class="col-md-3 col-form-label label-modif" for="phone">Téléphone </label>
                <div class="col-md-9">
                    <input class="form-control input-modif" type="tel" name="phone" id="phone" value="{{ old('phone', $phone) }}">
                </div>

                <label class="col-md-3 col-form-label label-modif" for="voiture_oui">Voiture </label>
                <div class="col-md-9 radio-group">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="voiture_oui" name="voiture" class="custom-control-input" value="1" @if(old('voiture', $vehicle)) checked @endif>
                        <label class="custom-control-label radio-before radio-bold" for="voiture_oui">Oui</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="voiture_non" name="voiture" class="custom-control-input" value="0" @if(!old('voiture', $vehicle)) checked @endif>
                        <label class="custom-control-label radio-bold" for="voiture_non">Non</label>
                    </div>
                </div>
        </div>

        <div class="form-group row">
            <div class="col-md-8 text-right">
                <button type="submit" class="btn-form">Enregistrer les changements</button>
            </div>
            <div class="col text-right">
                <a href="{{ route('deleteUser') }}" type="button" class="btn-form delete_button">Supprimer mon compte</a>
            </div>
        </div>
    </form>

    <div class="note_user">
        <label class="label-modif ma_note">Ma note</label>
        <div class="rotate_note">
            <!-- TODO à changer en back end -->
            <?php $rating = 2.8; ?>
            @include('include.rating', ['rating' => $rating])
        </div>
        <label class="label-modif x_notations">X notations</label>
    </div>
@endsection
