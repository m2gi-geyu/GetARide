@extends('layouts.sidebar')
<link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
<link href="{{ asset('/css/welcome.css') }}" rel="stylesheet" type="text/css" >
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
@section('content')
    <div class="panel-body container" align="center">
        <header class="header">
            <h3 align="center">Mes groupes crées</h3>
        </header>
        <div class="table-responsive container" align="center" id="table_created_group_div">
            <table class="table table-striped table-bordered" id="table_created_group">
                <thead>
                <tr>
                    <th>Nom</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $group)
                    <tr>
                        <td>
                            <label style="color: #d6d8db" for={{$group->name}}>{{$group->name}}</label>
                        </td>
                        <td class="last_cell" style="width:30%;border:0px">
                            <a href="#"><button type="submit" class="btn-perso-small">+ de détails</button></a><br>
                            <a href="/group/delete_group/{{$group->id}}"><button type="submit" class="btn-perso-small" onclick="return confirm('Êtes-vous sûr? Vous supprimez un groupe. Une fois confirmé, le système supprimera le groupe et ce dernier ne pourra plus être récupéré.')">Supprimer</button></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="container" align="center">
            <a href="../dashboard"><button class="btn-perso" type="button">Revenir à l'accueil</button></a>
        </div>
    </div>
@endsection

