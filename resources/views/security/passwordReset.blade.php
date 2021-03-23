<!DOCTYPE html>
<html lang="en">

<!--View of the page used to change his forgotten password-->

<!--TODO 22/03/2021 ADD VALIDATION ERROR SIGNALISATION-->


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retrieve Password</title>
</head>
<body>
    <form action="{{ url('/reset-password') }}" method="post">
        {{  csrf_field() }}


        <span class="text-danger">@error('token'){{$message}}@enderror</span>
        <label>Email</label>
        <input type="email" name="email" id="email">
        
        <span class="text-danger">@error('email'){{$message}}@enderror</span>

       
        <br>
        <label>New Password</label>
        <input type="password" name="password" id="email">
        <span class="text-danger">@error('password'){{$message}}@enderror</span>
        <br>
        <label>Retype your new Password</label>
        <input type="password" name="password_confirmation" id="email">
        <br>
        <input name="token" type="hidden" value="{{ $token }}">
        <button type="submit"> Reset</button>

    </form>
</body>
</html>