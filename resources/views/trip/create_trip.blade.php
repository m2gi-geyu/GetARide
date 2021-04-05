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
                    <div class="form-group">
                        <label for="departure">Ville</label>
                        <input class="form-control" type="text" autocomplete="off" list="departure" name="departure" id="departure" placeholder="Enter departure city" value="{{old('departure')}}">
                        <datalist  id="departure">
                        </datalist>
                        <span class="text-danger">@error('departure'){{$message}}@enderror</span>
                        <div class="row">
                            <div class="col-xs-2" style="width:50%">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" id="date" name="date" value="{{old('date')}}">
                                <span class="text-danger">@error('date'){{$message}}@enderror</span>
                            </div>
                            <div class="col-xs-6" style="width:50%">
                                <label for="time">Heure</label>
                                <input type="time" class="form-control" id="time" name="time" value="{{old('time')}}">
                                <span class="text-danger">@error('time'){{$message}}@enderror</span>
                            </div>
                        </div>
                        <label for="rdv">Précision RDV</label>
                        <textarea name="rdv"></textarea>
                    </div>
                </div>
                <div id="arrivee" class="row champ">
                    <h2>Arrivée</h2>
                    <div class="form-group">
                        <label for="final">Ville</label>
                        <input class="form-control" type="text" autocomplete="off" list="final" name="final" id="final" placeholder="Enter final city" value="{{old('final')}}">
                        <datalist  id="final">
                        </datalist>
                        <span class="text-danger">@error('final'){{$message}}@enderror</span>
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
            </div>
            <div id="col2" class="col-md-6">
                <div id="trip" class="row champ">
                    <h2>Trip</h2>
                    <div class="form-group">
                        <label for="nb_passengers">Nombre de places</label>
                        <input type="number" class="form-control" name="nb_passengers" min="1" max="6" value="{{old('nb_passengers')}}">
                        <span class="text-danger">@error('nb_passengers'){{$message}}@enderror</span>
                        <label for="price">Prix (€)</label>
                        <input type="number" class="form-control"  name="price" min="1" max="10000" step="1" value="{{old('price')}}">
                        <span class="text-danger">@error('price'){{$message}}@enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="info">Contraintes / Commentaires</label>
                        <textarea name="info"></textarea>
                    </div>
                </div>
                <div id="etapes" class="row champ" align="center">
                    <h2>Villes étapes</h2>
                    <div class="table-responsive" id="table_etapes">
                        <span id="error"></span>
                        <table class="table " id="item_table">
                            <tr>
                            @if(old('stage'))
                                @foreach(old('stage') as $stage)
                                    <tr>
                                        <td><input type="text" autocomplete="off" name="stage[]" list="stage" id="stage" class="form-control stage" value={{$stage}} /></td>
                                        <datalist  id="stage">
                                        </datalist>
                                        <td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td></tr>

                                    @endforeach
                                    @endif
                                    </tr>
                        </table>
                    </div>
                    <div align="center" id="add_div">
                        <button type="button" name="add" class="btn-rond add">+</button>
                    </div>
                </div>
                <div id="bouttons" class="row">
                    <div id="back_button_div" class="col-md-6"><a href="../dashboard"><button type="button" class="btn-perso">Retour</button></a></div>
                    <div id="create_button_div" class="col-md-6"><button type="submit" class="btn-perso">Proposer ce trajet</button></div>
                </div>
            </div>
        </div>
    </form>
<script type="text/javascript" >
    var today = new Date().toISOString().split('T')[0];
    document.getElementsByName("date")[0].setAttribute('min', today)

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
            html += '<tr>'
            /*html += '<td><input autocomplete="off" name="stage[]" list="stage" id="ville" class="form-control stage"  /></td>'
            html += '<datalist  id="stage">'
            html += '</datalist>'
            html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td></tr>'
*/

            $('#item_table').append(html);
        });

        $(document).on('click', '.remove', function(){
            $(this).closest('tr').remove();
        });

        /*$(document).on('input', function (){
            var vil =$('#departure').val();
            console.log()
            console.log(vil);
            fetch("https://geo.api.gouv.fr/communes?nom="+vil+"&fields=departement&boost=population&limit=5")
                .then((response) =>response.json())
                .then((data) => traitement(data));

            function traitement(data){
                $('#departure option').remove();
                console.log(data);
                var html ='';

                data.forEach(ville => {
                    html += '<option value=\"'+ville.nom+'\"/>';
                });
                $('#departure').append(html);

            }
        });

        $(document).on('input', function (){
            var vil =$('#ville').val();
            console.log()
            console.log(vil);
            fetch("https://geo.api.gouv.fr/communes?nom="+vil+"&fields=departement&boost=population&limit=5")
                .then((response) =>response.json())
                .then((data) => traitement(data));

            function traitement(data){
                $('#stage option').remove();
                console.log(data);
                var html ='';

                data.forEach(ville => {
                    html += '<option value=\"'+ville.nom+'\"/>';
                });
                $('#stage').append(html);

            }
        });

        $(document).on('input', function (){
            var vil =$('#ville').val();
            console.log()
            console.log(vil);
            fetch("https://geo.api.gouv.fr/communes?nom="+vil+"&fields=departement&boost=population&limit=5")
                .then((response) =>response.json())
                .then((data) => traitement(data));

            function traitement(data){
                $('#final option').remove();
                console.log(data);
                var html ='';

                data.forEach(ville => {
                    html += '<option value=\"'+ville.nom+'\"/>';
                });
                $('#final').append(html);

            }
        });*/
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
