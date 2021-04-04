<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wisth-device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible"  content="ie=edge">
    <title>Create Ride</title>
    <link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/welcome.css')}}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
@extends('layouts.sidebar')
<body>
@section('content')
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
        <div id="row_body" class="row" align="center">
            <div id="col1" class="col-md-6">
                <div id="depart" class="row champ">
                    <h2>Depart</h2>
                    <div  class="form-group">
                        <label for="departure">Ville</label>
                        <input type="text" class="form-control" name="departure" placeholder="Enter departure city" value="{{old('departure')}}">
                        <span class="text-danger">@error('departure'){{$message}}@enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" name="date" value="{{old('date')}}">
                        <span class="text-danger">@error('date'){{$message}}@enderror</span>
                    </div>
                </div>
                <div id="arrivee" class="row champ">
                    <h2>Arrivée</h2>
                    <div class="form-group">
                        <label for="final">Ville</label>
                        <input type="text" class="form-control" name="final" placeholder="Enter final city" value="{{old('final')}}">
                        <span class="text-danger">@error('final'){{$message}}@enderror</span>
                    </div>
                </div>
                <div id="etapes" class="row champ">
                    <h2>Villes étapes</h2>
                    <div class="table-responsive" id="table_etapes">
                        <span id="error"></span>
                        <button type="button" name="add" class="btn btn-success btn-sm add"><span class="glyphicon glyphicon-plus"></span></button>
                        <table class="table " id="item_table">
                        </table>
                    </div>
                </div>
            </div>
            <div id="col2" class="col-md-6">
                <div id="trip" class="row champ">
                    <h2>Trip</h2>
                    <div class="form-group">
                        <label for="nb_passengers">Nombre de places</label>
                        <input type="number" class="form-control" name="nb_passengers" min="1" max="6" value="{{old('nb_passengers')}}">
                        <span class="text-danger">@error('nb_passengers'){{$message}}@enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="price">Prix (€)</label>
                        <input type="number" class="form-control"  name="price" min="0" max="10000" step="0.1" value="{{old('price')}}">
                        <span class="text-danger">@error('price'){{$message}}@enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="info">Contraintes / Commentaires</label>
                        <textarea name="info"></textarea>
                    </div>
                </div>
                <div id="confidentialite" class="row champ">
                    <h2>Confidentialité</h2>
                    <div class="form-group">
                        <label for="public">Public</label>
                        <input type="radio" id="public" name="privacy" onclick="myFunction()" value="public">
                        <input type="radio" id="private" name="privacy" onclick="myFunction()" value="private" >
                        <label for="private">Privé</label>
                        <span class="text-danger">@error('privacy'){{$message}}@enderror</span>
                        <div name="groups_choice" id="groups_choice" class="form-group">
                            @foreach($data as $item)
                                <input type="checkbox" id="group" name="group" value={{$item->name}} >
                                <label for={{$item->name}}>{{$item->name}}</label><br />
                            @endforeach
                            <span class="text-danger">@error('group'){{$message}}@enderror</span>
                        </div>
                    </div>
                </div>
                <div id="bouttons" class="row">
                    <div id="back_button_div" class="col-md-6"><button type="button" class="btn-perso">Retour</button></div>
                    <div id="create_button_div" class="col-md-6"><button type="button" class="btn-perso">Proposer ce trajet</button></div>
                </div>
            </div>
        </div>
    </form>
<script type="text/javascript" >
    var pub= document.querySelectorAll("input[type=radio][name=privacy][id=public]");
    var priv= document.querySelectorAll("input[type=radio][name=privacy][id=private]");
    ///////////////////////////////////////
    /// Hauteur de la textarea automatique
    $('textarea').each(function(){
        this.setAttribute('style','height:'+(this.scrollHeight)+'px;overflow-y:hidden;');
    }).on('input',function(){
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    })
    ///////////////////////////////////////
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
            x[i].hidden = bool;
        }
        if(bool)
            $("div[name='groups_choice']").hide();
        else
            $("div[name='groups_choice']").show();
    }

    $(document).ready(function(){

        $(document).on('click', '.add', function(){
            var html = '';
            html += '<tr>';
            html += '<td><input type="text" name="stage[]" class="form-control stage" /></td>';
            html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-trash"></span></button></td></tr>';
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
@endsection
