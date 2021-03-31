@extends('layouts.sidebar')
<link href="{{ asset('/css/user_edit.css') }}" rel="stylesheet" type="text/css" >
@section('content')
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <div class="form-trip row">
            <div class="liste_trajet" >
                <ol>
                    <li>conducteur trajet horaire prix état option menu</li>
                @foreach ($trips as $trip)
                    <div class="col_trip" id = "col_trip_{{$trip->id}}">
                       <li>{{$trip->id_driver}}   {{$trip->starting_town}}->{{$trip->ending_town}}   {{$trip->datetrip}}   {{$trip->price}}
                        @foreach($link_trips as $link_trip)
                            @if($trip->id==$link_trip->id_trip)
                                @if($link_trip->validated==false)
                                       <p>confirmé</p>
                                @else
                                        <p>attend</p>
                                @endif
                            @endif
                        @endforeach
                        <a href="{{route("trip/cancel")}}"><button type="button" class="btn btn-perso btn-lg">Annuler</button></a>
                        <div id = "showdiv" style="display:none;">{{$trip->description}}
                            @foreach($link_trips as $link_trip)
                                @if($trip->id==$link_trip->id_trip)
                                        @if($link_trip->validated==true)
                                            <a href="{{route("trip/quit")}}"><button type="button" class="btn btn-perso btn-lg">se retirer</button></a>
                                        @endif
                                    @endif
                            @endforeach
                        </div>
                        <a href="#" onclick="showHideCode()">...</a>
                        </li>
                    </div>
                @endforeach
            </ol>
            </div>

            <script type="text/javascript">

                function showHideCode(){
                    $("#showdiv").toggle();
                }
            </script>
@endsection
