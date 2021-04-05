@extends('layouts.sidebar')
<link href="{{ asset('/css/user_edit.css') }}" rel="stylesheet" type="text/css" >
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
@section('content')<div class="panel-body">
    <h1 class="card-title">Search for a trip</h1>
    <div>
        <input type="text" name="start_town" id="start_town" class="form-control" placeholder="Ville de départ" onkeyup="fetch_trips()"/>
        <input type="text" name="end_town" id="end_town" class="form-control" placeholder="Ville d'arrivée" onkeyup="fetch_trips()"/>
        <input type="date" name="date" id="date" class="form-control" onchange="fetch_trips()"/>
    </div>
    <div class="table-responsive">
        <h3 align="center">Résultats trouvés : <span id="total_records"></span></h3>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>ID trip</th>
                <th>Driver</th>
                <th>Number of seats</th>
                <th>Starting town</th>
                <th>Ending town</th>
                <th>Date of the trip</th>
                <th>Price</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div  ><a href="../dashboard"><button class="btn-dark btn" type="button">Revenir à l'accueil</button></a></div>
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
