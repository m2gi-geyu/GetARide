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
                                    <div id="body-modal" class="modal-body">
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
                                            <label for="departure">Ville de départ</label>
                                        <input class="form-control" type="text" autocomplete="off" list="departurelist" name="departure" id="departure" placeholder="Enter departure city" >
                                        <datalist  id="departurelist"></datalist><span class="text-danger">@error('departure'){{$message}}@enderror</span>

                                        <label for="final">Ville d'arrivée</label>
                                        <input class="form-control" type="text" autocomplete="off" list="finallist" name="final" id="final" placeholder="Enter final city" >
                                        <datalist  id="finallist"></datalist>
                                                    <span class="text-danger">@error('final'){{$message}}@enderror</span>

                                        <div><label for="stage">Ville(s) intermédiaire(s) :</label>
                                                    <div class="table-responsive" id="table_etapes">
                                                        <span id="error"></span>
                                                        <table class="table " id="item_table">
                                                            <tr>
                                                            <tr>
                                                                <td><input type="text" autocomplete="off" name="stage[]" list="stagelist" id="stage" class="form-control stage" ></td>
                                                                <datalist  id="stagelist"></datalist>
                                                                <td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td></tr>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                <div align="center" id="add_div">
                                                    <button type="button" name="add" class="btn-rond add">+</button>
                                                </div>
                                        </div>
                                        <div class="row" align="center">
                                                <label style="width:45%" for="date">Date</label>
                                                <label style="width:45%" for="time">Heure</label>
                                                <input style="background-color:red;width:45%" type="date" class="form-control" id="date" name="date" >
                                                <span class="text-danger">@error('date'){{$message}}@enderror</span>
                                                <input style="width:45%" type="time" class="form-control" id="time" name="time" >
                                                <span class="text-danger">@error('time'){{$message}}@enderror</span>
                                        </div>
                                        <div><label for="rdv">Précision RDV</label>
                                            <textarea name="rdv" id="rdv"></textarea>
                                            <span class="text-danger">@error('rdv'){{$message}}@enderror</span>
                                        </div>
                                        <div><label for="nb_passengers">Nombre de places</label>
                                            <input type="number" class="form-control" name="nb_passengers" id="nb_passengers" min="1" max="6"  >
                                            <span class="text-danger">@error('nb_passengers'){{$message}}@enderror</span>

                                        </div>
                                        <div><label for="price">Prix (€)</label>
                                            <input type="number" class="form-control"  name="price" id="price" min="1" max="10000" step="1" >
                                            <span class="text-danger">@error('price'){{$message}}@enderror</span>

                                        </div>
                                        <div><label for="info">Contraintes / Commentaires</label>
                                            <textarea name="info" id="info"></textarea>
                                        </div>

                                    <div class="modal-footer" style="width: 100%" align="center">
                                            <button type="button" class="btn-perso-small col-xs-6" data-dismiss="modal">Retour</button>
                                            <button type="submit" class="btn-perso-small col-xs-6" >Sauvegarder</button>
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
    <div class="row"><a href="../dashboard" align="center" style="width:100%"><button class="btn-perso" type="button">Revenir à l'accueil</button></a></div>
    <!-- Modal -->
<script type="text/javascript" src="{{asset('js/creation_trajet.js')}}">

</script>
@endsection
