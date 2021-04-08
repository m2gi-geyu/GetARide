@extends('layouts.sidebar')
<link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
<link href="{{ asset('/css/welcome.css') }}" rel="stylesheet" type="text/css" >
@section('content')
    <div class="panel-body container">
        <header class="header">
            <h3 align="center">Mes trajets en attente</h3>
        </header>
        <div class="table-responsive container" id="liste_trajet_div">
            <table class="table table-striped table-bordered" id="liste_trajet">
                <thead style="text-align: center;vertical-align: middle">
                    <tr>
                        <th style="color: #d6d8db;">Conducteur</th>
                        <th style="color: #d6d8db">Trajet</th>
                        <th style="color: #d6d8db">Horaire</th>
                        <th style="color: #d6d8db">Prix (€)</th>
                        <th style="color: #d6d8db">Etat</th>
                        <th style="color: #d6d8db">Autres</th>
                    </tr>
                </thead>
                    <tbody style="text-align: center;vertical-align: middle" >
                        @foreach ($trips as $trip)
                            <tr style="text-align: center;vertical-align: middle">
                               <td style="color: #d6d8db;text-align: center;vertical-align: middle">{{$trip->driver_name}}</td>
                                <td style="color: #d6d8db;text-align: center;vertical-align: middle">{{$trip->starting_town}}->{{$trip->ending_town}}</td>
                                <td style="color: #d6d8db;text-align: center;vertical-align: middle">{{$trip->date_trip}}</td>
                                <td style="color: #d6d8db;text-align: center;vertical-align: middle">{{$trip->price}}</td>
                                <td style="color: #d6d8db;text-align: center;vertical-align: middle">
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

                                     <td  class="before_last_cell" style="color: #d6d8db;text-align: left;vertical-align: middle">
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
                                                    <a href="{{route("trip/cancel",[$trip->id])}}"><button type="button" class="btn-perso-small"style= "color: red;text-align: center;vertical-align: middle" >Annuler</button></a>
                                                @else
                                                    <a href="{{route("trip/cancel",[$trip->id])}}"><button type="button" class="btn-perso-small" style= "color: red;text-align: center;vertical-align: middle" disabled="true">Annuler</button></a>
                                                @endif
                                            @endif
                                        @endif
                                    @endforeach
                                </td>
                                </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript">

        function showHideCode(){
            $("#showdiv").toggle();
        }
    </script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
@endsection

