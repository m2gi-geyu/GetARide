<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wisth-device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible"  content="ie=edge">
    <link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/welcome.css')}}">
</head>
<body>
        <div class="mb-4 text-sm text-gray-600" style="color:red">
            <h3>Merci pour votre inscription! Avant de se connecter, pouvez-vous vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer par e-mail? Si vous n'avez pas reçu l'e-mail, nous vous en enverrons un autre avec plaisir.</h3>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600" style="text-align: center;vertical-align: middle">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between" style="text-align: center;vertical-align: middle">
            <form method="POST" action="{{ route('verification.send',[$id]) }}">
                <div>
                    <button type="submit" class="btn-form" style="text-align: center;vertical-align: middle">Resend Verification Email</button>
                </div>
            </form>

            <form method="GET" action="{{ route('logout') }}" >
                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900" style="text-align: center;vertical-align: middle">
                    {{ __('Log out') }}
                </button>
            </form>
        </div>
</body>
</html>
