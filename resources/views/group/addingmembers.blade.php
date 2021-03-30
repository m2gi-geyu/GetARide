@extends('layouts.sidebar')
<link href="{{ asset('/css/user_edit.css') }}" rel="stylesheet" type="text/css" >
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
@section('content')<div class="panel-body">
    <h1 class="card-title"> Ajoutez des membres à votre nouveau groupe!</h1>
    <div class="form-group">
        <input type="text" name="search" id="search" class="form-control" placeholder="Rechercher un utilisateur" />
    </div>
    <div class="table-responsive">
        <h3 align="center">Résultats trouvés : <span id="total_records"></span></h3>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Pseudo</th>
                <th>Ajouter au groupe</th>
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

        fetch_users();

        function fetch_users(query = '')
        {
            $.ajax({
                url:"{{ route('group.search') }}",
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

        $(document).on('keyup', '#search', function(){
            var query = $(this).val();
            fetch_users(query);
        });
    });
</script>
@endsection
