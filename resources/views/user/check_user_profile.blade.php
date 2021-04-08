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
    <img src="{{ $user->profile_pic ? asset('storage/'.$user->username.'/'.$user->profile_pic) : asset('/images/avatar_gros.png') }}" id="output" class="resize" alt="avatar">
        <div class="container">
            @if($user->ratings==null)
                    <h3>Pas encore d'évaluation</h3>
            @else
                <div class="" >
                    <h3>Note:{{$user->ratings}}</h3>
                </div>
            @endif
        </div>
        <div class="container">
            <a href="../search"><button class="btn-perso" type="button">Moteur de recherche</button></a>
        </div>
    </div>
</div>
@endsection
