@extends('layouts.sidebar')
<link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
<link href="{{ asset('/css/welcome.css') }}" rel="stylesheet" type="text/css" >
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
@section('content')
<div class="panel-body container" align="center" >
    <div class="container">
        <h4 style="font-size: 50px; color: #f4a261">{{$user->username}}</h4>
    </div>
    <img src="{{ $user->profile_pic ? asset('/storage/'.$user->username.'/'.$user->profile_pic) : asset('/images/avatar_gros.png') }}" id="output" class="resize" alt="avatar">
    <div class="container">
        @if($user->ratings==null)
            <h4>Pas encore d'évaluation</h4>
        @else
            <h4>Note:{{$user->ratings}}</h4>
        @endif
    </div>
    <header class="header">
        <h3 align="center">Ses trajets</h3>
    </header>
    <div style="width:80%" class="table-responsive container" id="ses_trajets_div">
        <table class="table table-striped table-bordered" id="ses_trajets">
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
                    <td class="first_cell" style="color: #d6d8db">{{$trip->number_of_seats}}</td>
                    <td style="color: #d6d8db">{{$trip->starting_town}}</td>
                    <td style="color: #d6d8db">{{$trip->ending_town}}</td>
                    <td style="color: #d6d8db">{{$trip->date_trip}}</td>
                    <td style="color: #d6d8db">{{$trip->price}}</td>
                    <td style="color: #d6d8db">{{$trip->description}}</td>
                    <td class="before_last_cell" style="color: #d6d8db">{{$trip->precision}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="container">
        <a href="../search"><button class="btn-perso" type="button">Moteur de recherche</button></a>
    </div>
</div>
</div>


@endsection
