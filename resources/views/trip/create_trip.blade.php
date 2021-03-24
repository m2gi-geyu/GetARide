<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wisth-device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible"  content="ie=edge">
    <title>Create Ride</title>
    <link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/welcome.css')}}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
<div class="container">
    <div class="row">

        <div class="col-md-4"></div>
        <div class="col-md-4 ">
            <h3>GET A RIDE</h3>
            <div class="form-group">
                <button type="submit" class="btn btn-block btn-primary"><a href="dashboard">Retour</a></button>
            </div>
            <form id="insert_form" action="{{ route('trip/create') }}" method="post">
                @csrf
                <div class="results">
                    @if(Session::get('success'))
                        <div class="alert alert-success">
                            {{Session::get('success')}}
                        </div>
                    @endif
                    @if(Session::get('fail'))
                        <div class="alert alert-danger">
                            {{Session::get('fail')}}
                        </div>
                    @endif
                    @if(Session::get('not_driver'))
                        <div class="alert alert-danger">
                            {{Session::get('not_driver')}}
                        </div>
                    @endif
                </div>
                <h4>Départ</h4>
                    <div  class="form-group">
                        <label for="departure">Ville de départ</label>
                        <input type="text" class="form-control" name="departure" placeholder="Enter departure city" value="{{old('departure')}}">
                        <span class="text-danger">@error('departure'){{$message}}@enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" name="date" value="{{old('date')}}">
                        <span class="text-danger">@error('date'){{$message}}@enderror</span>
                    </div>
                    <!--<div class="form-group">
                        <label for="time">Time</label>
                        <input type="time" class="form-control" name="time" value="{{old('time')}}">
                        <span class="text-danger">@error('time'){{$message}}@enderror</span>

                    </div>-->

                <h4>Arrivée</h4>
                    <div class="form-group">
                        <label for="final">Ville d'arrivée</label>
                        <input type="text" class="form-control" name="final" placeholder="Enter final city" value="{{old('final')}}">
                        <span class="text-danger">@error('final'){{$message}}@enderror</span>
                    </div>

                <h4>Ville Étapes</h4>
                    <div class="table-repsonsive">
                        <span id="error"></span>
                        <table class="table " id="item_table">
                            <tr>
                                <th>Étapes</th>
                                <th><button type="button" name="add" class="btn btn-success btn-sm add"><span class="glyphicon glyphicon-plus"></span></button></th>
                            </tr>
                        </table>
                    </div>

                <h4>Informations trajet</h4>
                    <div class="form-group">
                        <label for="nb_passengers">Nombre de passagers</label>
                        <input type="number" name="nb_passengers" min="1" max="6" value="{{old('nb_passengers')}}">
                        <span class="text-danger">@error('nb_passengers'){{$message}}@enderror</span>

                    </div>
                    <div class="form-group">
                        <label for="price">Prix</label>
                        <input type="number" name="price" min="0" max="10000" step="0.1" value="{{old('price')}}">
                        <span class="text-danger">@error('price'){{$message}}@enderror</span>

                    </div>
                    <div class="form-group">
                        <label for="info">Contraintes/Commentaires</label>
                        <textarea name="info" rows="5" cols="40"></textarea>
                    </div>

                <h4>Confidentialité</h4>
                    <div class="form-group">
                        <input type="radio" id="public" name="privacy" onclick="myFunction()" value="public">
                        <label for="public">Public</label>
                        <input type="radio" id="private" name="privacy" onclick="myFunction()" value="private" >
                        <label for="private">Privé</label>
                        <span class="text-danger">@error('privacy'){{$message}}@enderror</span>


                        <div class="form-group">
                            @foreach($data as $item)
                                <input type="radio" id="group" name="group" value={{$item->name}} >
                                <label for={{$item->name}}>{{$item->name}}</label><br />
                            @endforeach
                                <span class="text-danger">@error('group'){{$message}}@enderror</span>

                        </div>
                    </div>

                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-block btn-primary">Proposer un trajet</button>
                </div>
            </form>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
<script type="text/javascript" >
    var pub= document.querySelectorAll("input[type=radio][name=privacy][id=public]");
    var priv= document.querySelectorAll("input[type=radio][name=privacy][id=private]");


    for (var i = 0, iLen = pub.length; i < iLen; i++) {
        pub[i].onclick = function() {
            showResult('group',true);
        }
    }

    for (var i = 0, iLen = priv.length; i < iLen; i++) {
        priv[i].onclick = function() {
            showResult('group',false);
        }
    }

    function showResult(name,bool) {
        var x = document.getElementsByName(name);
        for (var i = 0; i < x.length; i++) {
            x[i].disabled = bool;
        }
    }

    $(document).ready(function(){

        $(document).on('click', '.add', function(){
            var html = '';
            html += '<tr>';
            html += '<td><input type="text" name="stage[]" class="form-control stage" /></td>';
            html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td></tr>';
            $('#item_table').append(html);
        });

        $(document).on('click', '.remove', function(){
            $(this).closest('tr').remove();
        });

        /*$('#insert_form').on('submit', function(event){
            event.preventDefault();
            var error = '';
            var count = 1;
            $('.stage').each(function(){

                if($(this).val() == '')
                {
                    error += "<p>Enter Stage at "+count+" Row</p>";
                    return false;
                }
                count = count + 1;
            });
            */

    });




</script>
</body>
</html>

