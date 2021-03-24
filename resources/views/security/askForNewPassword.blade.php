


<!DOCTYPE html>
<html lang="en">

<!--View of the page used to ask for a link to change a forgoten password-->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retrieve Password</title>
    <link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
</head>
<body>
<div class="container ">

    <div class="row">
        <div class="col-md-4"></div>

        <div class="col-md-4">
            <h3>User's password</h3>
            <form action="{{ url('/change-password') }}" method="post">
            {{  csrf_field() }}

            <!--Error Message-->
                <label for="email">Email</label>
                <input type="email" name="email" id="email"class="text-center col align-self-center" placeholder="Enter your email">
                <span class="text-danger">@error('email'){{$message}}@enderror</span>
                @if(session()->get('status'))
                <span class=".text-success">{{ __('passwords.sent') }}</span>
                @endif

                <div class="text-center">
                    <button type="submit" class="btn btn-block btn-primary"> Retrieve my password</button>
                </div>


            </form>
        </div>

        <div class="col-md-4"></div>

    </div>
</div>
</body>
</html>
