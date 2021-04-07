@extends('layouts.sidebar')
<link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
<link href="{{ asset('/css/welcome.css') }}" rel="stylesheet" type="text/css" >
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
@section('content')
    <div class="panel-body container">
        <header class="header" >
            <h2 id="colored_header" align="center">Créez votre groupe d'amis !</h2>
        </header>
        <div class="form-group container" align="center">
            <form action="{{ route('group/create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <fieldset >
                    <div class="form-group" >
                        <h2 style="font-family:'Agency FB';font-size: 3em " for="group_name" >Nom du groupe</h2>
                        <input style="width:60%" type="text" class="form-control input-modif" name="group_name"  placeholder="EKIPAFOND"  required value="{{old('group_name')}}">
                        <span class="text-danger">@error('group_name'){{$message}}@enderror</span>
                    </div>
                </fieldset>

                <div class="form-group">
                    <button style="font-family:'Agency FB';font-size: 1.0em" type="submit" class="btn-perso" >Créer le groupe</button>
                </div>
            </form>
        </div>
    </div>
@endsection
