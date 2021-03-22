<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retrieve Password</title>
</head>
<body>
    <form action="{{ url('/reset-password') }}" method="post">
        {{  csrf_field() }}



        <label>Email</label>
        <input type="email" name="email" id="email">
        <br>
        <label>New Password</label>
        <input type="password" name="password" id="email">
        <br>
        <label>Retype your new Password</label>
        <input type="password" name="password_confirmation" id="email">
        <br>
        <input name="token" type="hidden" value="{{ $token }}">
        <button type="submit"> Reset</button>

    </form>
</body>
</html>