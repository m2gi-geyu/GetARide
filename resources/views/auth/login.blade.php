<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="wisth-device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible"  content="ie=edge">
        <title>Login</title>
        <link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
    </head>
    <body>
        <div class="container">
            <div class="row">
               <div class="col-md-4 col-md-offset-4">
                   <h3>GET A RIDE</h3>
                   <form action="{{ route('auth/check') }}" method="post">
                       @csrf
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
                            <label for="email" class="login">Email/Pseudo</label>
                            <input type="text" class="form-control" name="email" placeholder="Enter email">
                            <span class="text-danger">@error('email'){{$message}}@enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="password" class="login">Mot de passe</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter password">
                            <span class="text-danger">@error('password'){{$message}}@enderror</span>
                        </div>
                        <br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-primary">Se connecter</button>
                           <a href="change-password"><button type="button" class="btn btn-perso btn-lg">Mot de passe oublié</button></a>
                       </div>
                        <br>
                        <p>Vous n'avez pas de compte ? <a href="register">Inscrivez-vous!</a></p>
                       <br>

                    </form>
               </div>
            </div>
        </div>
    </body>
</html>
