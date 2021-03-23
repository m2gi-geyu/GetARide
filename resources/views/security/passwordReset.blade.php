<!DOCTYPE html>
<html lang="en">

<!--View of the page used to change his forgotten password-->

<!--TODO 22/03/2021 ADD VALIDATION ERROR SIGNALISATION-->


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retrieve Password</title>
    <link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">

</head>
<body>
    <div class="container">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 col-md-offset-4">
                    <h3>Reset password</h3>
                    <form action="{{ url('/reset-password') }}" method="post">
                        {{  csrf_field() }}


                        <span class="text-danger">@error('token'){{$message}}@enderror</span>
                        <label>Email</label>
                        <input type="email" name="email" id="email" class=" form-control text-center" placeholder="yourEmail@xyz.com">
                        
                        <span class="text-danger">@error('email'){{$message}}@enderror</span>

                       
                        <br>
                        <label>New Password</label>
                        <input type="password" name="password" id="email" class="form-control text-center" placeholder="Enter your password">
                        <span class="text-danger">@error('password'){{$message}}@enderror</span>
                        <br>
                        <label>Retype your new Password</label>
                        <input type="password" name="password_confirmation" id="email" class="form-control text-center" placeholder="Confirm your password">
                        <br>
                        <input name="token" type="hidden" value="{{ $token }}">
                        <div class="text-center">
                            <button type="submit" class="btn btn-block btn-primary m-2"> Reset</button>
                        </div>
                        

                    </form>
                </div>
                <div class="col-md-4"></div>
            </div>
    </div>
</body>
</html>