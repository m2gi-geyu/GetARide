@extends('layouts.sidebar')
<link href="{{ asset('/css/user_edit.css') }}" rel="stylesheet" type="text/css" >
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
@section('content')<div class="panel-body">

    <header class="header" style="color: #d6d8db;font-family: 'Agency FB'">
        <h3 align="center">Mes groupes crées</h3>
    </header>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th style="color: #d6d8db">Nom du groupe</th>
            <th style="color: #d6d8db">Accéder aux détail du groupe</th>
        </tr>
        </thead>
        <tbody>
    @foreach($data as $group)
        <tr>
        <td><label style="color: #d6d8db" for={{$group->name}}>{{$group->name}}</label></td>
        <td><a href="#"><button type="submit" class="btn btn-block btn-primary">+ de détails</button></a></td>
        </tr>
    @endforeach
        </tbody>
    </table>

    <div><a href="../dashboard"><button class="btn-dark btn" type="button">Revenir à l'accueil</button></a></div>
@endsection

