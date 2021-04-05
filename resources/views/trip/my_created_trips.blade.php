@extends('layouts.sidebar')
<link href="{{ asset('/css/welcome.css') }}" rel="stylesheet" type="text/css" >
<link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
@section('content')<div class="panel-body">
    <header class="header" style="color: #d6d8db;font-family: 'Agency FB'">
        <h3 align="center">Mes trajets</h3>
    </header>
    <div class="row">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th style="color: #d6d8db">Ville de départ</th>
                <th style="color: #d6d8db">Ville d'arrivée</th>
                <th style="color: #d6d8db">Date et heure de départ</th>
                <th style="color: #d6d8db">Nombre de places</th>
                <th style="color: #d6d8db">Prix (€)</th>
                <th style="color: #d6d8db">Villes étapes</th>

            </tr>
            </thead>
            <tbody>

            @foreach($data as $trip)
                <?php
                    $date_hour = explode(' ',$trip->date_trip);
                ?>
                <tr>
                    <td><label style="color: #d6d8db" for={{$trip->starting_town}}>{{$trip->starting_town}}</label></td>
                    <td><label style="color: #d6d8db" for={{$trip->ending_town}}>{{$trip->ending_town}}</label></td>
                    <td><label style="color: #d6d8db" for={{$trip->date_trip}}>{{$trip->date_trip}}</label></td>
                    <td><label style="color: #d6d8db" for={{$trip->number_of_seats}}>{{$trip->number_of_seats}}</label></td>
                    <td><label style="color: #d6d8db" for={{$trip->price}}>{{$trip->price}}</label></td>
                    <td><button type="button" class="btn-perso-small" data-toggle="modal" data-target="#detailsModal">+ de détails</button>
                        <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModal" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div id="contenuModal" class="modal-content">
                                    <div class="modal-body">
                                        <div><label for="departure">Ville de départ</label>
                                            <input class="form-control" type="text" autocomplete="off" list="departure" name="departure" id="departure" value="{{$trip->starting_town}}"></div>
                                        <div>
                                            <label for="final">Ville d'arrivée</label>
                                            <input class="form-control" type="text" autocomplete="off" list="final" name="final" id="final" value="{{$trip->ending_town}}">
                                            <datalist  id="final"></datalist>
                                        </div>
                                        <div>Ville(s) intermédiaire(s) :@foreach($stages_trips as $step)
                                                @if($step->id_trip == $trip->id)
                                                    {{$step->stage}}
                                                @endif
                                            @endforeach</div>
                                        <div><label for="date">Date</label>
                                            <label for="time">Heure</label>
                                            <input type="date" class="form-control" id="date" name="date" value="{{$date_hour[0]}}">
                                            <input type="time" class="form-control" id="time" name="time" value="{{$date_hour[1]}}">
                                        </div>
                                        <div><label for="rdv">Précision RDV</label>
                                            <textarea name="rdv">{{$trip->precision}}</textarea>
                                        </div>
                                        <div><label for="nb_passengers">Nombre de places</label>
                                            <input type="number" class="form-control" name="nb_passengers" min="1" max="6" value="{{$trip->number_of_seats}}">
                                        </div>
                                        <div><label for="price">Prix (€)</label>
                                            <input type="number" class="form-control"  name="price" min="1" max="10000" step="1" value="{{$trip->price}}">
                                        </div>
                                        <div><label for="info">Contraintes / Commentaires</label>
                                            <textarea name="info">{{$trip->description}}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="width: 100%" align="center">
                                            <button type="button" class="btn-perso-small col-xs-6" data-dismiss="modal">Retour</button>
                                            <button type="button" class="btn-perso-small  col-xs-6">Sauvegarder</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="/trip/delete_trip/{{$trip->id}}"><button type="submit" class="btn-perso-small" onclick="return alert('Êtes-vous sûr? Vous supprimez ce trajet. Une fois confirmé, le système supprimera le trajet et ce dernier ne pourra plus être récupéré.')">Supprimer</button></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row"><a href="../dashboard" align="center" style="width:100%"><button class="btn-perso" type="button">Revenir à l'accueil</button></a></div>
    <!-- Modal -->

@endsection
