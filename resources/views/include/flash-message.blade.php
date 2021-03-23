<link href="{{ asset('/css/flash_message.css') }}" rel="stylesheet" type="text/css" >

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('info'))
    <div class="alert alert-info alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger custom-alert">
        <ul style="list-style-type:none;">
            <li>Erreur</li>
            @foreach ($errors->all() as $error)
                <li class="li-error">{{ $error }}</li>
            @endforeach
        </ul>
        <input class="error_confirmation" type="button" onclick="$('div.custom-alert').remove()" value="D'accord">
    </div>
@endif
