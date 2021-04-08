@extends('layouts.sidebar')
<link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
<link href="{{ asset('/css/welcome.css') }}" rel="stylesheet" type="text/css" >
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
                            <button type="button" class="btn-perso-small" data-toggle="modal" data-target="#detailsModal">+ de détails</button><br>
                            <div class=" modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModal" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div id="contenuModal" class="modal-content">
                                        <div id="body-modal" class="modal-body" align="center">
                                            <!-- Input pour changer le nom du groupe-->
                                            <!-- Récupérer ici les membres du groupes et les afficher dans une table-->
                                            <button type="submit" class="btn-perso">Sauvegarder</button>
                                            <button type="button" class="btn-perso" data-dismiss="modal">Retour</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn-perso-small" data-toggle="modal" data-target="#modalSuppression">Supprimer</button>
                            <div class="modal fade" id="modalSuppression" tabindex="-1" role="dialog" aria-labelledby="modalSuppression" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" id="confirmation">
                                        <div class="modal-body">
                                            <h2>Êtes-vous sûr ?</h2>
                                            Vous êtes sur le point de supprimer le groupe <span style="font-weight:bold">{{$group->name}}</span>.<br>Une fois confirmé, le système supprimera le groupe et ce dernier ne pourra plus être récupéré.
                                            <br><br><a href="/group/delete_group/{{$group->id}}"><button type="submit" class="btn-perso-blue">Confirmer</button></a>
                                            <br><br><button type="button" class="btn-perso-blue" data-dismiss="modal">Annuler</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

