<link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        link of activation :{{$user->email}},before{{$user->activity_expire}}activer your compte。
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
