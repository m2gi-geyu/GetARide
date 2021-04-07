@extends('layouts.sidebar')
<link href="{{ asset('/css/user_edit.css') }}" rel="stylesheet" type="text/css" >
@section('content')
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <div class="form-trip row">
            <div class="liste_trajet"  >
                <h3>GET A RIDE</h3>
                <table class="table table-striped table-bordered" >
                    <thead style="text-align: center;vertical-align: middle">
                        <tr>
                            <th style="color: #d6d8db;">conducteur</th>
                            <th style="color: #d6d8db">trajet</th>
                            <th style="color: #d6d8db">horaire</th>
                            <th style="color: #d6d8db">prix (€)</th>
                            <th style="color: #d6d8db">état</th>
                            <th style="color: #d6d8db">option</th>
                            <th style="color: #d6d8db">autre</th>
                        </tr>
                    </thead>
                        <tbody style="text-align: center;vertical-align: middle">
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
                                    <td >
                                        @foreach($link_trips as $link_trip)
                                        <br>
                                            @if($trip->id==$link_trip->id_trip)
                                                @if($link_trip->validated==false)
                                                    @if($trip->reste>86400)
                                                        <a href="{{route("trip/cancel",[$trip->id])}}"><button type="button" class="btn btn-perso btn-lg"style= "color: red;text-align: center;vertical-align: middle" >Annuler</button></a>
                                                    @else
                                                        <a href="{{route("trip/cancel",[$trip->id])}}"><button type="button" class="btn btn-perso btn-lg" style= "color: red;text-align: center;vertical-align: middle" disabled="true">Annuler</button></a>
                                                    @endif
                                                @endif
                                            @endif
                                        @endforeach
                                    </td>
                                    <!--<td >
                                        <a href="#" onclick="showHideCode()" style="color: #d6d8db">...</a>
                                    </td>-->


                                         <td style="color: #d6d8db;text-align: center;vertical-align: middle">
                                            <!--<div id = "showdiv" style="display:none;color: #d6d8db">-->
                                                @foreach($link_trips as $link_trip)
                                                    @if($trip->id==$link_trip->id_trip)
                                                        lieu precision:  {{$trip->precision}}<br>
                                                        descritpion:{{$trip->description}}<br>
                                                        opération:
                                                        <br>
                                                        @if($link_trip->validated==true )
                                                            @if($trip->reste<0)
                                                                <button type="button" class="btn btn-perso btn-lg" style="color: blue" disabled="true">Noter</button>
                                                            @else
                                                                <button type="button" class="btn btn-perso btn-lg" style="color: blue" disabled="true">Noter</button>
                                                            @endif
                                                            <br>
                                                            @if($trip->reste>86400)
                                                                <a href="{{route("trip/quit",[$trip->id])}}"><button type="button" class="btn btn-perso btn-lg" style="color: red" >Se retirer</button></a>
                                                            @else
                                                                <a href="{{route("trip/quit",[$trip->id])}}"><button type="button" class="btn btn-perso btn-lg" style="color: red" disabled="true">Se retirer</button></a>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endforeach
                                            <!--</div>-->

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
@endsection
