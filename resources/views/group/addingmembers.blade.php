@extends('layouts.sidebar')
<link href="{{ asset('/css/user_edit.css') }}" rel="stylesheet" type="text/css" >
<link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
@section('content')<div class="panel-body">
    <h1 class="card-title" style="color: #d6d8db;font-family: 'Agency FB'"> Ajoutez des membres à votre nouveau groupe!</h1>
    <div class="form-group">
        <input type="text" name="search" id="search" class="form-control" placeholder="Rechercher un utilisateur" />
    </div>
    <div class="table-responsive">
        <h3 align="center" style="color: #d6d8db;font-family: 'Agency FB'; margin:5% 0;">Résultats trouvés : <span id="total_records"></span></h3>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th style="color: #d6d8db">Pseudo</th>
                <th style="color: #d6d8db">Ajouter au groupe</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div style="text-align: center;"><a href="../dashboard"><button class="btn-dark btn" type="button" style="font-family:'Agency FB'; font-size: 1.6em";>Revenir à l'accueil</button></a></div>
</div>




<script>
    $(document).ready(function(){

        fetch_users();

        function fetch_users(query = '')
        {
            $.ajax({
                url:"{{ route('group/search') }}",
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('tbody').html(data.table_data).css({"font-family": "Agency FB", "font-size": "1.2em", "color":"#43de86", "hover":"yellow", "text-align":"center"});
                    $('#total_records').text(data.total_data);
                }
            })
        }

        $(document).on('keyup', '#search', function(){
            var query = $(this).val();
            fetch_users(query);
        });
    });
</script>
@endsection
