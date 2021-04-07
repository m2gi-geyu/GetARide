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
            <h3>GET A RIDE</h3>
            <form action="{{ route('auth/create') }}" method="post" enctype='multipart/form-data'>
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
                <fieldset>
                <div class="form-group">
                <p>
                    <label for="username">Pseudo</label>
                    <input type="text" class="form-control-register" name="username"  placeholder="Enter username" value="{{old('username')}}">
                    <span class="text-danger">@error('username'){{$message}}@enderror</span>
                    </p>
                </div>
                <div class="form-group">
                    <label for="surname">Nom</label>
                    <input type="text" class="form-control-register" name="surname" placeholder="Enter surname"  value="{{old('surname')}}">
                    <span class="text-danger">@error('surname'){{$message}}@enderror</span>
                </div>
                <div class="form-group">
                    <label for="name">Prénom</label>
                    <input type="text" class="form-control-register" name="name" placeholder="Enter name"  value="{{old('name')}}">
                    <span class="text-danger">@error('name'){{$message}}@enderror</span>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control-register" name="email" placeholder="Enter email" value="{{old('email')}}">
                    <span class="text-danger">@error('email'){{$message}}@enderror</span>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control-register" name="password" placeholder="Enter password" >
                    <span class="text-danger">@error('password'){{$message}}@enderror</span>
                </div>
                <div class="form-group">
                    <label for="phone">Numéro de téléphone</label>
                    <input type="tel" class="form-control-register" name="phone" placeholder="Enter phone number" value="{{old('phone')}}">
                    <span class="text-danger">@error('phone'){{$message}}@enderror</span>
                </div>
                <div class="form-group">
                    <p>Civilité :
                    <input type="radio" id="masculin" name="gender" value="M" @if(old('gender')) checked @endif>
                    <label for="oui">M</label>
                    <input type="radio" id="feminin" name="gender" value="F" @if(old('gender')) checked @endif>
                    <label for="non">F</label>
                    <input type="radio" id="autre" name="gender" value="A" @if(old('gender')) checked @endif>
                    <label for="non">Autre</label>
                    <span class="text-danger">@error('gender'){{$message}}@enderror</span>
                    </p>
                </div>
                <div class="form-group">
                    <p>Possède véhicule :
                    <input type="radio" id="oui" name="vehicle" value="oui"  @if(old('vehicle')) checked @endif>
                    <label for="oui">Oui</label>
                    <input type="radio" id="non" name="vehicle" value="non" checked @if(old('vehicle')) checked @endif>
                    <label for="non">Non</label>
                    <span class="text-danger">@error('vehicle'){{$message}}@enderror</span>
                    </p>
                </div>
                <div class="form-group">
                    <p>Notifications par mail :
                    <input type="radio" id="oui" name="mail_notifications" value="oui" checked @if(old('mail_notifications')) checked @endif>
                    <label for="oui">Oui</label>
                    <input type="radio" id="non" name="mail_notifications" value="non" @if(old('mail_notifications')) checked @endif>
                    <label for="non">Non</label>
                    <span class="text-danger">@error('mail_notifications'){{$message}}@enderror</span>
                    </p>
                </div>
                <div class="form-group">
                    <label for="about">A propos de vous (optionnel)</label>
                    <textarea class="form-control" id="about" name="about" rows="3" >{{old('about')}}</textarea>
                    <span class="text-danger">@error('about'){{$message}}@enderror</span>
                </div>
                    <div class="form-group">
                        <p>Photo de profil/Avatar (optionnelle)</p>
                        <input  type="file" name="profile_pic" id="profile_pic" value="{{old('profile_pic')}}">
                        <span class="text-danger">@error('profile_pic'){{$message}}@enderror</span>
                    </div>
                </fieldset>
                <br>
                <div class="form-login">
                    <button type="submit" class="btn btn-block btn-primary">S'inscrire</button>
                </div>
                <br>
                <p class="hyperlien">Vous avez-déjà un compte ? <a href="login">Connectez-vous!</a></p>
            </form>
</div>
</body>
</html>
