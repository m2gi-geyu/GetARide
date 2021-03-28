@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Activity Result') }}</div>

                    <div class="card-body">
                        @if($res === false)
                            invalider<a href="{{route('register')}}">register>></a>
                        @else
                            valider<a href="{{route('login')}}">login>></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
