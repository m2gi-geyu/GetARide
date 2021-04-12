<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wisth-device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible"  content="ie=edge">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/welcome.css')}}">
</head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 ">
                    <h3>GET A RIDE</h3>
                    <p>Bienvenue <b>{{$LoggedUserInfo->name}}</b>!</p>
					<fieldset>
					<label for="compte" class="col-md-4 col-form-label text-md-center dashboard">Gestion du Compte</label>
                    <div id="block7" class="col-md-6"><a href="user/edit"><button type="button" class="btn btn-perso btn-lg">Modifier compte</button></a></div>

                    <div id="block7" class="col-md-6"><a href="user/search"><button type="button" class="btn btn-perso btn-lg">Rechercher un utilisateur</button></a></div>
                    <div id="block7" class="col-md-6"><a href="notifications"><button type="button" class="btn btn-perso btn-lg">Notifications</button></a></div>
					</fieldset>
                    <br>
					<fieldset>
					<label for="trajets" class="col-md-4 col-form-label text-md-center dashboard">Gestion des Trajets</label>
                    @if($LoggedUserInfo->vehicle==true)
                        <div id="block7" class="col-md-6"><a href="create_trip"><button type="button" class="btn btn-perso btn-lg">Créer un trajet</button></a></div>
                        <div id="block7" class="col-md-6"><a href="my_created_trips"><button type="button" class="btn btn-perso btn-lg">Mes trajets crées</button></a></div>
                    @endif
                    <div id="block7" class="col-md-6"><a href="trip/search_trip"><button type="button" class="btn btn-perso btn-lg">Rechercher un trajet</button></a></div>
                    <div id="block7" class="col-md-6"><a href="trip/trip_in_waiting"><button type="button" class="btn btn-perso btn-lg">trip in waiting</button></a></div>
					</fieldset>
                    <br>
                    @if($LoggedUserInfo->vehicle==true)
						<fieldset>
							<label for="groupe" class="col-md-4 col-form-label text-md-center dashboard">Gestion des groupes privés</label>
							<div id="block7" class="col-md-6"><a href="creategroup"><button type="button" class="btn btn-perso btn-lg">Créer un groupe</button></a></div>
							<div id="block7" class="col-md-6"><a href="mycreatedgroups"><button type="button" class="btn btn-perso btn-lg">Mes groupes crées</button></a></div>
						</fieldset>
					<br>
                    @endif
                    <br>
                    <div id="block7" class="col-md-6"><a href="logout"><button type="button" class="btn btn-perso btn-lg">Se déconnecter</button></a></div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </body>
</html>
