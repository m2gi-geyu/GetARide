

<!DOCTYPE html>
<html lang="en">

<!--View of the page used to ask for a link to change a forgoten password-->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retrieve Password</title>
</head>
<body>
    <form action="{{ url('/change-password') }}" method="post">
        {{  csrf_field() }}

        <!--Error Message-->
        @if(session('error'))
            <div>{{ session('error') }}</div>
        @endif

        <input type="email" name="email" id="email">

        <!--Error Message when the mail isn't linked to an account-->
        @if($errors->get('email'))
            <div>{{ __('passwords.user') }}</div>
        @else
            <div><p>An email has been sent</p></div>
        @endif

        <button type="submit"> Retrieve my password</button>

    </form>
</body>
</html>