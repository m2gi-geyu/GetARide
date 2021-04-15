<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible"  content="ie=edge">
    <title>Dashboard</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}"> -->
    <!-- <link rel="stylesheet" href="{{URL::asset('css/welcome.css')}}"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="{{URL::asset('css/dashboard.css')}}">
</head>
    <body>
        <div class="container">
            <div class="header_container">
                <div class="header">
                    <div class="header_logo">
                        <img src="{{URL::asset('images/logo.png')}}">
                    </div>
                    <div class="header_buttons">
                        <a class="headerButton" href="trip/search_trip" style="text-decoration:none;"><i class="fa fa-search" aria-hidden="true"></i> rechercher</a>
                        @if($LoggedUserInfo->vehicle==true)
                        <a class="headerButton" href="create_trip" style="text-decoration:none;"><i class="fa fa-plus-circle" aria-hidden="true"></i> créer un trajet</a>
                        @endif
                    </div>
                </div>
                <div class="headerTitle">
                    <h3>Tableau de bord</h3>
                </div>
            </div>
            <div class="page-wrapper">
                <div class="avatarBlock">
                    <div class="avarImg">
                        <img src="{{ Session::has('LoggedUserPic') ? asset('/storage/'.Session::get('LoggedUser').'/'.Session::get('LoggedUserPic')) : asset('/images/avatar.png') }}">
                    </div>
                    <div class="avarTitle">
                    Bienvenue <b>{{$LoggedUserInfo->name}}</b>!
                    </div>
                </div>
                <div class="accountBlock">
                    <div class="accountItem">
                        <div class="accountItem__arrow">
                        </div>
                        <div class="accountItem__label">
                            <a href="user/edit">Modifier compte</a>
                        </div>
                    </div>
                    <div class="accountItem">
                        <div class="accountItem__arrow">
                        </div>
                        <div class="accountItem__label">
                            <a href="notifications">Notifications</a>
                        </div>
                    </div>
                    <div class="accountItem">
                        <div class="accountItem__arrow">
                        </div>
                        <div class="accountItem__label">
                            <a href="help">Comment ça marche?</a>
                        </div>
                    </div>
                    <div class="accountItem">
                        <div class="accountItem__arrow">
                        </div>
                        <div class="accountItem__label">
                            <a href="{{ route("note.attributed") }}">Mes notes attribuées</a>
                        </div>
                    </div>
                    <div class="accountItem">
                        <div class="accountItem__arrow">
                        </div>
                        <div class="accountItem__label">
                            <a href="logout">Se déconnecter</a>
                        </div>
                    </div>
                </div>
                <div class="groupBlocks">
                    <div class="groupBlock">
                        <div class="groupBlock__Title">
                            TRAJET
                        </div>
                        <div class="groupBlock__Content">
                            @if($LoggedUserInfo->vehicle==true)
                            <div class="groupBlock__Content__Item">
                                <div class="groupBlock__Content__Item__arrow">
                                </div>
                                <div class="groupBlock__Content__Item__label">
                                    <a href="my_created_trips">Mes trajets crées</a>
                                </div>
                            </div>
                            @endif
                            <div class="groupBlock__Content__Item">
                                <div class="groupBlock__Content__Item__arrow">
                                </div>
                                <div class="groupBlock__Content__Item__label">
                                    <a href="trip/trip_in_waiting">Mes trajets en attente</a>
                                </div>
                            </div>
                            <div class="groupBlock__Content__Item">
                                <div class="groupBlock__Content__Item__arrow">
                                </div>
                                <div class="groupBlock__Content__Item__label">
                                    <a href="user/search">Rechercher un utilisateur</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="groupBlock">
                        <div class="groupBlock__Title">
                            GROUPE
                        </div>
                        <div class="groupBlock__Content">
                            @if($LoggedUserInfo->vehicle==true)
                            <div class="groupBlock__Content__Item">
                                <div class="groupBlock__Content__Item__arrow">
                                </div>
                                <div class="groupBlock__Content__Item__label">
                                    <a href="creategroup">Créer un groupe</a>
                                </div>
                            </div>
                            <div class="groupBlock__Content__Item">
                                <div class="groupBlock__Content__Item__arrow">
                                </div>
                                <div class="groupBlock__Content__Item__label">
                                    <a href="{{ route("mycreatedgroups") }}">Mes groupes crées</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>
