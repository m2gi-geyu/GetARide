@extends('layouts.sidebar')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="{{ asset('/css/user_edit.css') }}" rel="stylesheet" type="text/css" >
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <div class="container-fluid">
        @foreach ($notifications as $rawNotification)
            <div class="row" id = "row_{{$rawNotification->id}}">
                <div class="col-8">

                @switch($rawNotification->type)
                    @case( Config::get('db.notificationType.trip_canceled') )
                        @include('user/notifications/tripCanceled',['notifications'=>$rawNotification])
                    @break

                    @case( Config::get('db.notificationType.trip_request') )
                        @include('user/notifications/tripRequest')
                    @break

                    @case( Config::get('db.notificationType.trip_request_canceled') )
                        @include('user/notifications/tripRequestCanceled')
                    @break

                    @case( Config::get('db.notificationType.trip_request_accepted') )
                        @include('user/notifications/tripRequestAccepted')
                    @break

                    @case( Config::get('db.notificationType.trip_request_refused') )
                        @include('user/notifications/tripRequestRefused')
                    @break

                    @case( Config::get('db.notificationType.new_private_trip') )
                        @include('user/notifications/newPrivateTrip',['notifications'=>$rawNotification])
                    @break

                    @default
                        <p>You should not see that</p>
                    @endswitch
                    
                </div> 
                <div class="col">
                    <div class="col">
                        <span class="label-modif">
                            @php
                                echo date_format($rawNotification->created_at,"Y/m/d");
                            @endphp
                        </span>
                    </div>
                    <div class="col">
                        <span class="label-modif">
                            @php
                                echo date_format($rawNotification->created_at,"H:i");
                            @endphp
                        </span>
                    </div>                
                </div>
                <div class="col">
                    @if($rawNotification->read_at == NULL)
                    <form action = "{{ route('notification.read') }}" id="form-read-js">
                        <input type="hidden" id="read-id-js" value = "{{$rawNotification->id}}" >
                        <button type="submit" class="btn-form" >Read</button>
                    </form>
                    @endif
                </div>
                <div class="col">
                    <form action = "{{ route('notification.delete') }}" id="form-delete-js">
                        <input type="hidden" id="delete-id-js" value = "{{$rawNotification->id}}" >
                        <button type="submit" class="btn-form" >Delete</button>
                    </form>
                </div>
            </div>
                
        @endforeach
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
@endsection