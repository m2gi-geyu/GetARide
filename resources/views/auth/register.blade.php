<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wisth-device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible"  content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h3>GET A RIDE</h3>
            <br>
            <form action="{{ route('auth/create') }}" method="post">
                @csrf
                <fieldset>
                <div class="results">
                     @if(Session::get('success'))
                         <div class="alert alert-success">
                             {{Session::get('success')}}
                         </div>
                     @endif
                     @if(Session::get('fail'))
                         <div class="alert alert-danger">
                             {{Session::get('fail')}}
                         </div>
                     @endif
                </div>
                <div class="form-group">
                    <label for="username">Pseudo</label>
                    <input type="text" class="form-control" name="username" placeholder="Enter username" value="{{old('username')}}">
                    <span class="text-danger">@error('username'){{$message}}@enderror</span>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter email" value="{{old('email')}}">
                    <span class="text-danger">@error('email'){{$message}}@enderror</span>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" name="password" placeholder="Enter password" >
                    <span class="text-danger">@error('password'){{$message}}@enderror</span>
                </div>
                <div class="form-group">
                    <label for="phone">Numéro de téléphone</label>
                    <input type="tel" class="form-control" name="phone" placeholder="Enter phone number" value="{{old('phone')}}">
                    <span class="text-danger">@error('phone'){{$message}}@enderror</span>
                </div>
                <div class="form-group">
                    <p>Possède véhicule
                    <input type="radio" id="oui" name="vehicle" value="oui">
                    <label for="oui">Oui</label>
                    <input type="radio" id="non" name="vehicle" value="non">
                    <label for="non">Non</label>
                    <span class="text-danger">@error('vehicle'){{$message}}@enderror</span>
                    </p>
                </div>
                </fieldset>
                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary">S'inscrire</button>
                </div>
                <br>
                <p>Vous avez-déjà un compte ? <a href="login">Connectez-vous!</a></p>
            </form>
        </div>
    </div>
</div>
</body>
</html>
