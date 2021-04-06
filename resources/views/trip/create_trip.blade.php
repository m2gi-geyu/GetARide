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
                        <input class="form-control" type="text" autocomplete="off" list="departurelist" name="departure" id="departure" placeholder="Enter departure city" value="{{old('departure')}}">
                        <datalist  id="departurelist">
                        </datalist>
                        <span class="text-danger">@error('departure'){{$message}}@enderror</span>
                        <div class="row">
                            <div class="col-xs-6" style="width:50%">
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
                        <span class="text-danger">@error('rdv'){{$message}}@enderror</span>

                    </div>
                </div>
                <div id="arrivee" class="row champ">
                    <h2>Arrivée</h2>
                    <div class="form-group">
                        <label for="final">Ville</label>
                        <input class="form-control" type="text" autocomplete="off" list="finallist" name="final" id="final" placeholder="Enter final city" value="{{old('final')}}">
                        <datalist  id="finallist">
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
                <div id="etapes" class="row champ" align="center" style="padding-bottom: 10px ">
                    <h2>Villes étapes</h2>
                    <div class="col-xs-9" style="width:80%" align="center">
                        <div class="table-responsive" id="table_etapes">
                            <span id="error"></span>
                            <table class="table" id="item_table" >
                                <tr>
                                @if(old('stage'))
                                    @foreach(old('stage') as $stage)
                                        <tr>
                                            <td><input type="text" autocomplete="off" name="stage[]" list="stagelist" id="stage" class="form-control stage" value={{$stage}} ></td>
                                            <datalist  id="stagelist">
                                            </datalist>
                                            <td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td></tr>

                                        @endforeach
                                        @endif
                                    <tr>
                                        <td><input type="text" autocomplete="off" name="stage[]" list="stagelist" id="stage" class="form-control stage" /></td>
                                        <datalist  id="stagelist">
                                        </datalist>
                                        <td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-trash"></span></button></td>
                                    </tr>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-xs-3" style="width:20%; vertical-align: middle" align="center" id="add_div">
                        <button style="vertical-align: middle" type="button" name="add" class="btn-rond add">+</button>
                    </div>

                </div>
                <div id="bouttons" class="row">
                    <div id="back_button_div" class="col-md-6"><a href="../dashboard"><button type="button" class="btn-perso">Retour</button></a></div>
                    <div id="create_button_div" class="col-md-6"><button type="submit" class="btn-perso">Proposer ce trajet</button></div>
                </div>
            </div>
        </div>
    </form>
    <script type="text/javascript" src="{{asset('js/creation_trajet.js')}}"></script>
    <script type="text/javascript">
        ///////////////////////////////////////
        /// Hauteur de la textarea automatique
        $('textarea').each(function (){
            this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
        }).on('input', function (){
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        })
        ///////////////////////////////////////
    </script>
</body>
</html>
@endsection
