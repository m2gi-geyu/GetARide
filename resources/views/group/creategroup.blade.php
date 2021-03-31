@extends('layouts.sidebar')
<link href="{{ asset('/css/user_edit.css') }}" rel="stylesheet" type="text/css" >
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
@section('content')
    <form class="col-md-8" action="{{ route('group/create') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <fieldset>
            <div class="form-group">
                <label class="col-md-3 col-form-label label-modif" for="group_name">Nom du groupe</label>
                <input type="text" class="form-control input-modif" name="group_name"  placeholder="EKIPAFOND"  required value="{{old('group_name')}}">
                <span class="text-danger">@error('group_name'){{$message}}@enderror</span>
            </div>
        </fieldset>
        <br>
        <div class="form-group">
            <button type="submit" class="btn-form delete_button">Créer le groupe</button>
        </div>
    </form>


@endsection
