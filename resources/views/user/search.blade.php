@extends('layouts.sidebar')
<link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
<link href="{{ asset('/css/welcome.css') }}" rel="stylesheet" type="text/css" >
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
@section('content')
<div class="panel-body container">
    <header class="header" >
        <h2 id="colored_header" align="center">Recherche d'utilisateur</h2>
    </header>
    <div class="form-group container" align="center">
        <input style="width:50%" type="text" name="search" id="search" class="form-control" placeholder="Rechercher un utilisateur" />
        <br>
        <h4 align="center">Résultats trouvés : <span id="total_records"></span></h4>
    </div>
    <div class="table-responsive table-striped container"  id="table_users_find_div">
        <table class="table table-striped table-bordered" id="table_users_find">
            <thead>
            <tr>
                <th>Pseudo</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="container" align="center">
        <a href="../dashboard" ><button class="btn-perso" type="button">Revenir à l'accueil</button></a>
    </div>
</div>
<script>
    $(document).ready(function(){
        fetch_users();

        function fetch_users(query = '')
        {
            $.ajax({
                url:"{{ route('user/searchSubmit') }}",
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('tbody').html(data.table_data);
                    $('#total_records').text(data.total_data);
                    $('.modal-body:empty').text('Cet utilisateur est déjà membre de tous vos groupes privés');
                    main();
                }
            })

            
        }

        $(document).on('keyup', '#search', function(){
            var query = $(this).val();
            fetch_users(query);
        });

        
    });
</script>
<script type="text/javascript" src="{{asset('js/add_member.js')}}"></script>
@endsection
