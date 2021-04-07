@extends('layouts.sidebar')
<link href="{{ asset('/css/user_edit.css') }}" rel="stylesheet" type="text/css" >
@section('content')
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <div class="form-trip row">
            <div class="liste_trajet" >
				<h3>GET A RIDE</h3>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="color: #d6d8db">conducteur</th>
                            <th style="color: #d6d8db">trajet</th>
                            <th style="color: #d6d8db">horaire</th>
                            <th style="color: #d6d8db">prix (€)</th>
                            <th style="color: #d6d8db">état</th>
                            <th style="color: #d6d8db">option</th>
                            <th style="color: #d6d8db"></th>
                        </tr>
                    </thead>
                        <tbody>
                            @foreach ($trips as $trip)
                                <tr>
                                   <td style="color: #d6d8db">{{$trip->driver_name}}</td>
                                    <td style="color: #d6d8db">{{$trip->starting_town}}->{{$trip->ending_town}}</td>
                                    <td style="color: #d6d8db">{{$trip->date_trip}}</td>
                                    <td style="color: #d6d8db">{{$trip->price}}</td>
                                    @foreach($link_trips as $link_trip)
                                        @if($trip->id==$link_trip->id_trip)
                                            @if($link_trip->validated==false)
                                                   <td style="color: #d6d8db">En attend</td>
                                            @else
                                                    <td style="color: #d6d8db">Confirmé</td>
                                            @endif
                                        @endif
                                    @endforeach
                                    <td>
                                        @foreach($link_trips as $link_trip)
                                            @if($trip->id==$link_trip->id_trip)
                                                @if($link_trip->validated==false)
                                                    <a href="{{route("trip/cancel",[$trip->id])}}"><button style="color: #d6d8db" type="button" class="btn btn-perso btn-lg">Annuler</button></a>
                                                @endif
                                            @endif
                                        @endforeach
                                    </td>
                                    <td >
                                        <a href="#" onclick="showHideCode()" style="color: #d6d8db">...</a>
                                    </td>
                                    </tr>
                                     <tr>
                                         <td>
                                        <div id = "showdiv" style="display:none;color: #d6d8db">
                                            @foreach($link_trips as $link_trip)
                                                @if($trip->id==$link_trip->id_trip)
                                                    lieu precision:  {{$trip->precision}}
                                                    descritpion:{{$trip->description}}
                                                        @if($link_trip->validated==true)
                                                        opération:<a href="{{route("trip/quit",[$trip->id])}}"><button type="button" class="btn btn-perso btn-lg" style="color: #d6d8db">se retirer</button></a>
                                                        @endif
                                                    @endif
                                            @endforeach
                                        </div>
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
@endsection
