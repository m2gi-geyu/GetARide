@extends('layouts.sidebar')
<link href="{{ asset('/css/user_edit.css') }}" rel="stylesheet" type="text/css" >
<link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
@section('content')
    <div class="container ">

        <div class="row">
            <div class="col-md-3"></div>

            <div class="col-md-3" style="text-align: center;">
                <div class="form-group" >
                    <form  class="col-md-8" action="{{ route('group/create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <fieldset >
                            <div class="form-group" >
                                <h2 style="font-family:'Agency FB';font-size: 3em " for="group_name" >Nom du groupe</h2>
                                <input type="text" class="form-control input-modif" name="group_name"  placeholder="EKIPAFOND"  required value="{{old('group_name')}}">
                                <span class="text-danger">@error('group_name'){{$message}}@enderror</span>
                            </div>
                        </fieldset>
                    </form>
                </div>
                
                <button style="font-family:'Agency FB';font-size: 1.6em" type="submit" class="btn-form delete_button" >Créer le groupe</button>

            </div>

            <div class="col-md-3"></div>
            <div class="col-md-3"></div>

        </div>
    </div>

    
@endsection
