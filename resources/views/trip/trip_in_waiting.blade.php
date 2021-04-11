@extends('layouts.sidebar')
<link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
<link href="{{ asset('/css/welcome.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('/css/trips_waiting_expired.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('/css/user.css') }}" rel="stylesheet" type="text/css" >
@section('content')
    <div class="panel-body container">
<!--            TODO ajouter les deux routes tout trip et trip privés-->
            <a href="" type="button" class="btn-form delete_button">Tous les trajets</a>
            <a href="" type="button" class="btn-form delete_button">Trajets privés uniquement</a>

            <header class="header">
            <h3 align="center">Mes trajets en attente</h3>
        </header>
        <div class="table-responsive container" id="liste_trajet_div">
            <table class="table table-striped table-bordered" id="liste_trajet">
                <thead style="text-align: center;vertical-align: middle;">
                    <tr>
                        <th class="waiting_th_td">Conducteur</th>
                        <th class="waiting_th_td">Trajet</th>
                        <th class="waiting_th_td">Horaire</th>
                        <th class="waiting_th_td">Prix (€)</th>
                        <th class="waiting_th_td">Etat</th>
                        <th class="waiting_th_td">Autres</th>
                    </tr>
                </thead>
                    <tbody style="text-align: center;vertical-align: middle" >
                        @foreach ($trips as $trip)
                            <tr style="text-align: center;vertical-align: middle">
                               <td class="waiting_th_td">
                                   <div class="clear_trip">
                                       <img src="{{ isset($trip->profile_pic) ? asset('storage/'.$trip->username.'/'.$user->profile_pic) : asset('/images/avatar_notif.png') }}" class="avatar_trip" alt="avatar">
                                       <span>{{$trip->driver_name}}</span>
                                   </div></td>
                                <td class="waiting_th_td">{{$trip->starting_town}}->{{$trip->ending_town}}</td>
                                <td class="waiting_th_td">{{$trip->date_trip}}</td>
                                <td class="waiting_th_td">{{$trip->price}}</td>
                                <td class="waiting_th_td">
                                @foreach($link_trips as $link_trip)
                                    @if($trip->id==$link_trip->id_trip)
                                        @if($link_trip->validated==false)
                                               En attente
                                        @else
                                                Confirmé
                                        @endif
                                    @endif
                                @endforeach
                                </td>
                                <!--<td >
                                    <a href="#" onclick="showHideCode()" style="color: #d6d8db">...</a>
                                </td>-->

                                     <td  class="before_last_cell waiting_th_td">
                                        <!--<div id = "showdiv" style="display:none;color: #d6d8db">-->
                                            @foreach($link_trips as $link_trip)
                                                @if($trip->id==$link_trip->id_trip)
                                                    Précision RDV :  {{$trip->precision}}<br>
                                                    Description :{{$trip->description}}<br>
                                                    Opération :
                                                    <br>
                                                    @if($link_trip->validated==true )
                                                        @if($trip->reste<0)
                                                            <button type="button" class="btn btn-perso btn-lg" style="color: blue" disabled="true">Noter</button>
                                                        @else
                                                            <button type="button" class="btn btn-perso btn-lg" style="color: blue" disabled="true">Noter</button>
                                                        @endif
                                                        <br>
                                                        @if($trip->reste>86400)
                                                            <a href="{{route("trip/quit",[$trip->id])}}"><button type="button" onclick="return confirm('Êtes-vous sûr de vouloir vous retirer de ce trajet?')" class="btn-perso-small" style="color: red" >Se retirer</button></a>
                                                        @else
                                                            <a href="{{route("trip/quit",[$trip->id])}}"><button type="button" onclick="return confirm('Êtes-vous sûr de vouloir vous retirer de ce trajet?')" class="btn-perso-small" style="color: red" disabled="true">Se retirer</button></a>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                        <!--</div>-->
                                     </td>
                                <td class="last_cell" style="border:transparent;vertical-align: middle" >
                                    @foreach($link_trips as $link_trip)
                                        @if($trip->id==$link_trip->id_trip)
                                            @if($link_trip->validated==false)
                                                @if($trip->reste>86400)
                                                    <a href="{{route("trip/cancel",[$trip->id])}}"><button type="button" class="btn-perso-small" style= ";text-align: center;vertical-align: middle" >Annuler</button></a>
                                                @else
                                                    <a href="{{route("trip/cancel",[$trip->id])}}"><button type="button" class="btn-perso-small" style= "color: red;text-align: center;vertical-align: middle" disabled="true">Annuler</button></a>
                                                @endif
                                            @endif
                                        @endif
                                    @endforeach
                                        {{-- //TODO back-end gérer si privé ou non alors l'afficher
                                        si terminé -> bouton noter
                                        --}}
                                        <a href="{{route("note.noteTrip",[$trip->id])}}"><button type="button" class="btn-perso-small" style= ";text-align: center;vertical-align: middle" >Noter</button></a>
                                </td>
                                </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
    <div class="flash-message">
        @include('user.notes.tripsNote')
    </div>
    <script type="text/javascript">

        function showHideCode(){
            $("#showdiv").toggle();
        }
    </script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
@endsection

