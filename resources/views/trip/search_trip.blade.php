@extends('layouts.sidebar')

<link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
<link href="{{ asset('/css/welcome.css') }}" rel="stylesheet" type="text/css" >
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
@section('content')
    <div class="panel-body container">
    <header class="header" >
        <h2 id="colored_header" align="center">Recherche de trajet</h2>
    </header>
    <div class="form-group container" align="center">
        <input style="width: 50%; margin-bottom: 5px" type="text" name="start_town" id="start_town" class="form-control" placeholder="Ville de départ" onkeyup="fetch_trips()"/>
        <input style="width: 50%; margin-bottom: 5px" type="text" name="end_town" id="end_town" class="form-control" placeholder="Ville d'arrivée" onkeyup="fetch_trips()"/>
        <input style="width: 50%" type="date" name="date" id="date" class="form-control" onchange="fetch_trips()"/><br>
        <h4 align="center">Résultats trouvés : <span id="total_records"></span></h4>
    </div>
    <div class="table-responsive container" id="table_trip_find_div">
        <table class="table table-striped table-bordered" id="table_trip_find">
            <thead style="font-family: 'Agency FB'; font-size: 1.2em;"; >
            <tr>
                <th style="color: #d6d8db">Driver</th>
                <th style="color: #d6d8db">Number of seats</th>
                <th style="color: #d6d8db">Starting town</th>
                <th style="color: #d6d8db">Ending town</th>
                <th style="color: #d6d8db">Date of the trip</th>
                <th style="color: #d6d8db">Price</th>
                <th style="color: #d6d8db">Description</th>
                <th style="color: #d6d8db">Etapes</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div style="text-align: center;"><a href="../dashboard"><button class="btn-perso" type="button" style="font-family:'Agency FB'; font-size: 1.6em";>Revenir à l'accueil</button></a></div>
</div>




<script>

    $(document).ready(function(){
        fetch_trips();
    });

    function fetch_trips()
    {
        let query = [];
        query[0] = $('#start_town').val();
        query[1] = $('#end_town').val();
        query[2] = $('#date').val();
        $.ajax({
            url:"{{ route('trip/search') }}",
            method:'GET',
            data:{query:query},
            dataType:'json',
            success:function(data)
            {
                $('tbody').html(data.table_data);
                $('#total_records').text(data.total_data);
            }
        })

    }
</script>

@endsection
