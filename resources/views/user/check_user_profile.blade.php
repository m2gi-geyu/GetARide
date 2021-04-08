@extends('layouts.sidebar')
<link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
<link href="{{ asset('/css/welcome.css') }}" rel="stylesheet" type="text/css" >
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
@section('content')

    <div class="justify-content-center col-md-8">
        <div class="col-md-3 col-form-label justify-content-center" >
            <img src="{{ $user->profile_pic ? asset('storage/'.$user->username.'/'.$user->profile_pic) : asset('/images/avatar_gros.png') }}" id="output" class="resize" alt="avatar">
        </div>

        <div class="col-md-12 col-form-label justify-content-center" >
            <h3>{{$user->username}}</h3>
        </div>

        @if($user->ratings==null)
            <div class="col-md-12 col-form-label justify-content-center" >
                <h4>Pas encore d'évaluation</h4>
            </div>
        @else
            <div class="col-md-12 col-form-label justify-content-center" >
                <h4>Note:{{$user->ratings}}</h4>
            </div>
        @endif
        <thead>

        <div class="col-form-label justify-content-center" >
            <a href="../search"><button class="btn-perso justify-content-center" type="button">Moteur de recherche</button></a>
        </div>
    </div>

    <div class="pour-walid">
        <h1>Trajets crées</h1>

        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th style="color: #d6d8db">Nombre de sièges</th>
                <th style="color: #d6d8db">Ville de départ</th>
                <th style="color: #d6d8db">Ville d'arrivée</th>
                <th style="color: #d6d8db">Date et heure du trajet</th>
                <th style="color: #d6d8db">Prix</th>
                <th style="color: #d6d8db">Description</th>
                <th style="color: #d6d8db">Précisions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($created_trips as $trip)
                <tr>
                    <td style="color: #d6d8db">{{$trip->number_of_seats}}</td>
                    <td style="color: #d6d8db">{{$trip->starting_town}}</td>
                    <td style="color: #d6d8db">{{$trip->ending_town}}</td>
                    <td style="color: #d6d8db">{{$trip->date_trip}}</td>
                    <td style="color: #d6d8db">{{$trip->price}}</td>
                    <td style="color: #d6d8db">{{$trip->description}}</td>
                    <td style="color: #d6d8db">{{$trip->precision}}</td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>

@endsection
