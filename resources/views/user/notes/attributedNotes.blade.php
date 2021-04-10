@extends('layouts.sidebar')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="{{ asset('/css/notifs.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('/css/user.css') }}" rel="stylesheet" type="text/css" >
<script src="{{ asset('js/rating.js') }}" defer></script>
@section('content')
    <script src="{{ asset('js/user.js') }}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <div class="col-md-9">
        <br/><br/>
{{--
        @foreach ($users as $user) exemple
--}}
    <!--                        TODO temporaire (pour back end) -->

            <?php
            $user = '1'; $trip = '2'; $count = 1;
            ?>
            <div class="label-notif" id = "row_{{ $user }}_{{ $trip }}">
                <div class="row" style="padding-top: 1vw;">
                    <div class="col" >
                        <img src="{{ isset($user->profile_pic) ? asset('storage/'.$user->username.'/'.$user->profile_pic) : asset('/images/avatar_notif.png') }}" class="avatar_notif" alt="avatar">
                    </div>
                    <div class="col-md-5 col-form-label my-auto">
                        <span style="font-family: Roboto,serif; font-size: 1vw;">
                            Prénom Nom
                        </span>
                    </div>
                    <div class="col-md-5 col-form-label my-auto" style="padding-top: 2vw">
                        @include('include.rating', ['rating' => 2.8, 'count' => $count])
                    </div>
                    <div class="frame">
                        <input type="image" src="{{ asset('images/triple_dot.png') }}" class="input-note" border="0" id="defiler_{{ $user }}_{{ $trip }}" onclick="defilerNote(this);" value="{{ $user }}_{{ $trip }}" alt="Détails"/>
                    </div>
                </div>
                <div class="row special_row">
                    <div class="special_col" id="special_col_{{ $user }}_{{ $trip }}">
<!--                        TODO nouvelles routes -->
                        @include('include.rating_specific_user_trip', ['user' => $user, 'trip', $trip])
                        <form action = "" id="form-read-js">
                            <input type="hidden" value = "{{ $user }}_{{ $trip  }}" >
                            <input type="submit" class="btn-form delete_button" value="Valider"/>
                            <a href="" type="button" class="btn-form delete_button">Supprimer la note</a>
                        </form>
                    </div>
                </div>
            </div>
        {{--
                @endforeach
        --}}
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
