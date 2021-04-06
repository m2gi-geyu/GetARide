@extends('layouts.sidebar')

<link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
<link href="{{ asset('/css/welcome.css') }}" rel="stylesheet" type="text/css" >
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
@section('content')<div class="panel-body">
    <header class="header" style="color: #d6d8db;font-family: 'Agency FB'">
        <h3 align="center">Mes trajets</h3>
    </header>
    <div id="mes_trajets_table" class="row">
        <table class="table table-striped">
            <thead>
            <tr>
                <th style="color: #d6d8db">Ville de départ</th>
                <th style="color: #d6d8db">Ville d'arrivée</th>
                <th style="color: #d6d8db">Date et heure de départ</th>
                <th style="color: #d6d8db">Nombre de places</th>
                <th style="color: #d6d8db">Prix (€)</th>
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
                    <td><label style="color: #d6d8db" for={{$trip->date_trip}}>{{$date_hour[0]}}<br>{{$date_hour[1]}}</label></td>
                    <td><label style="color: #d6d8db" for={{$trip->number_of_seats}}>{{$trip->number_of_seats}}</label></td>
                    <td><label style="color: #d6d8db" for={{$trip->price}}>{{$trip->price}}</label></td>
                    <td><button type="button" name="open" id="open" class="btn-perso-small open" data-toggle="modal"
                                data-id-trip="{{$trip->id}}"
                                data-starting-town="{{$trip->starting_town}}"
                                data-ending-town="{{$trip->ending_town}}"
                                data-date-trip="{{$date_hour[0]}}"
                                data-hour-trip="{{$date_hour[1]}}"
                                data-nb-seat="{{$trip->number_of_seats}}"
                                data-price="{{$trip->price}}"
                                data-rdv ="{{$trip->precision}}"
                                data-info ="{{$trip->description}}"
                                data-stage="{{$stages_trips}}"
                                data-target="#detailsModal">+ de détails</button>
                        <div class=" modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModal" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div id="contenuModal" class="modal-content">
                                    <div id="body-modal" class="modal-body" align="center">
                                        <form id="insert_form" action="{{ route('trip/modified') }}" method="post">
                                            @csrf
                                            <div class="results">
                                                @if(Session::get('success'))
                                                    <div class="alert alert-success">
                                                        {{Session::get('success')}}
                                                    </div>
                                                @endif
                                                @if(Session::get('fail'))
                                                    <div class="alert alert-danger">
                                                        {{Session::get('fail')}}
                                                    </div>
                                                @endif
                                            </div>
                                            <label for="id_trip">Voyage n°</label>
                                            <input  type="text" readonly="readonly" id="id_trip" name="id_trip"  ><br>
                                            <div class="row text-center"align="center">
                                                <div class="col-xs-6" style="width:50%" align="center">
                                                    <label for="departure">Ville de départ</label>
                                                    <input style="width: 80%" class="form-control" type="text" autocomplete="off" list="departurelist" name="departure" id="departure" placeholder="Enter departure city" >
                                                    <datalist  id="departurelist"></datalist>
                                                    <span class="text-danger">@error('departure'){{$message}}@enderror</span>
                                                </div>
                                                <div class="col-xs-6" style="width:50%" align="center">
                                                    <label for="final">Ville d'arrivée</label>
                                                    <input style="width: 80%"  class="form-control" type="text" autocomplete="off" list="finallist" name="final" id="final" placeholder="Enter final city" >
                                                    <datalist  id="finallist"></datalist>
                                                    <span class="text-danger">@error('final'){{$message}}@enderror</span>
                                                </div>
                                            </div>
                                            <br>
                                        <div class="row text-center" align="center"style="width:100%">
                                            <div class="col-xs-12" style="width:100%" align="center">
                                                <label for="stage">Ville(s) intermédiaire(s)</label>
                                                <div class="table-responsive" id="table_etapes">
                                                    <span id="error"></span>
                                                    <table class="table " id="item_table">
                                                        <tr>
                                                            <td><input type="text" autocomplete="off" name="stage[]" list="stagelist" id="stage" class="form-control stage" ></td>
                                                            <datalist  id="stagelist"></datalist>
                                                            <td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div align="center" id="add_div" style="margin-top:5px">
                                                    <button type="button" name="add" class="btn-rond add">+</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row text-center"align="center">
                                             <div class="col-xs-6" style="width:50%" align="center">
                                                 <label for="date">Date</label>
                                                 <input style="width: 80%" type="date" class="form-control" id="date_modal" name="date" >
                                                 <span class="text-danger">@error('date'){{$message}}@enderror</span>
                                             </div>
                                            <div class="col-xs-6" style="width:50%" align="center">
                                                 <label for="time">Heure</label>
                                                 <input style="width: 80%" type="time" class="form-control" id="time_modal" name="time" >
                                                 <span class="text-danger">@error('time'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row text-center"align="center">
                                            <div class="col-xs-12" style="width:100%;height: 100%">
                                                <label for="rdv">Précision RDV</label>
                                                <textarea name="rdv" id="rdv"></textarea>
                                                <span class="text-danger">@error('rdv'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row text-center"align="center">
                                            <div class="col-xs-6" style="width:50%" align="center">
                                                <label for="nb_passengers">Nombre de places</label>
                                                <input style="width: 80%" type="number" class="form-control" name="nb_passengers" id="nb_passengers" min="1" max="6"  >
                                                <span class="text-danger">@error('nb_passengers'){{$message}}@enderror</span>
                                            </div>
                                            <div class="col-xs-6" style="width:50%" align="center">
                                                <label for="price">Prix (€)</label>
                                                <input style="width: 80%" type="number" class="form-control"  name="price" id="price" min="1" max="10000" step="1" >
                                                <span class="text-danger">@error('price'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                            <br>
                                        <div class="row">
                                            <div class="col-xs-12" style="width:100%" align="center">
                                                <label for="info">Contraintes / Commentaires</label>
                                                <textarea name="info" id="info"></textarea>
                                            </div>
                                        </div>
                                            <br>
                                        <div class="row" style="width: 100%" align="center">
                                            <div class="col-xs-6" style="width: 50%" align="center">
                                                <button style="width: 80%" type="button" class="btn-perso-small" data-dismiss="modal">Retour</button>
                                            </div>
                                            <div class="col-xs-6" style="width: 50%" align="center">
                                                <button style="width: 80%" type="submit" class="btn-perso-small" >Sauvegarder</button>
                                            </div>
                                        </div>
                                    </form>
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
    <div class="row">
        <a href="../dashboard" align="center" style="width:100%">
            <button class="btn-perso" type="button">Revenir à l'accueil</button>
        </a>
    </div>
    <script type="text/javascript" src="{{asset('js/creation_trajet.js')}}"></script>

@endsection
