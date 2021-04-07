@extends('layouts.sidebar')
<link href="{{ asset('/css/user_edit.css') }}" rel="stylesheet" type="text/css" >
<link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
@section('content')<div class="panel-body">
    <h1 class="card-title" style="color: #d6d8db;font-family: 'Agency FB'">Search for a trip</h1>

    <div style="text-align: center;">
        <input style="margin: 2% 0" type="text" name="start_town" id="start_town" class="form-control" placeholder="Ville de départ" onkeyup="fetch_trips()"/>
        <input style="margin: 2% 0" type="text" name="end_town" id="end_town" class="form-control" placeholder="Ville d'arrivée" onkeyup="fetch_trips()"/>
        <input style="margin: 2% 0" type="date" name="date" id="date" class="form-control" onchange="fetch_trips()"/>
    </div>
    <div class="table-responsive">
        <h2 align="center" style="color: #d6d8db;font-family: 'Agency FB'; margin:5% 0;">Résultats trouvés : <span id="total_records"></span></h2>
        <table class="table table-striped table-bordered">
            <thead style="font-family: 'Agency FB'; font-size: 1.2em;"; >
            <tr>
                <th style="color: #d6d8db">Driver</th>
                <th style="color: #d6d8db">Number of seats</th>
                <th style="color: #d6d8db">Starting town</th>
                <th style="color: #d6d8db">Ending town</th>
                <th style="color: #d6d8db">Date of the trip</th>
                <th style="color: #d6d8db">Price</th>
                <th style="color: #d6d8db">Description</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div style="text-align: center;"><a href="../dashboard"><button class="btn-dark btn" type="button" style="font-family:'Agency FB'; font-size: 1.6em";>Revenir à l'accueil</button></a></div>
</div>



<div style="background-color: coral;">
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
                $('tbody').html(data.table_data).css({"font-family": "Agency FB", "font-size": "1.2em", "color":"#43de86", "hover":"yellow", "text-align":"center"});
                $('#total_records').text(data.total_data).css({"font-family": "Agency FB"});
            }
        })
       
    }
</script>

</div>
@endsection
