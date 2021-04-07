@extends('layouts.sidebar')
<link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
<link href="{{ asset('/css/welcome.css') }}" rel="stylesheet" type="text/css" >
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
@section('content')
    <div class="panel-body container">
        <header class="header" >
            <h2 id="colored_header" align="center">Ajoutez des membres à votre nouveau groupe!</h2>
        </header>
        <div class="form-group container" align="center">
            <input style="width:50%" type="text" name="search" id="search" class="form-control" placeholder="Rechercher un utilisateur" /><br>
            <h4 align="center">Résultats trouvés : <span id="total_records"></span></h4>
        </div>
        <div class="table-responsive container" id="table_group_add_user_div">
            <table class="table table-striped table-bordered" id="table_group_add_user">
                <thead>
                    <tr>
                        <th style="color: #d6d8db">Pseudo</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="container" align="center">
            <a href="../dashboard"><button class="btn-perso" type="button" >Revenir à l'accueil</button></a>
        </div>
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
                    $('tbody').html(data.table_data);
                    $('#total_records').text(data.total_data);
                    $('#table_group_add_user button').addClass('btn-perso-small');
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
