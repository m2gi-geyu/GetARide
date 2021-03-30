<meta name="csrf-token" content="{{ csrf_token() }}">

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<div class="container-fluid">
    @foreach ($notifications as $rawNotification)
        <div class="row" id = "row_{{$rawNotification->id}}">
            <div class="col-8">

            @switch($rawNotification->notification_type)
                @case(1)
                    @include('user/notifications/tripCanceled')
                @break

                @case(2)
                    @include('user/notifications/tripRequest')
                @break

                @case(3)
                    @include('user/notifications/tripRequestCanceled')
                @break

                @case(4)
                    @include('user/notifications/tripRequestCanceled')
                @break

                @case(5)
                    @include('user/notifications/tripRequestRefused')
                @break

                @case(6)
                    @include('user/notifications/newPrivateTrip')
                @break

                @default
                    <p>You should not see that</p>
                @endswitch
                
            </div> 
            <div class="col">
                    <button type="button" class="btn btn-outline-dark">Read</button>
                    <form action = "{{ route('notification.delete') }}" id="form-delete-js">
                        <input type="hidden" id="delete-id-js" value = "{{$rawNotification->id}}" >
                        <button type="submit" class="btn btn-outline-dark" >Delete</button>
                    </form>
            </div>
        </div>
            
    @endforeach
</div>

<script src="{{ asset('js/app.js') }}"></script>
