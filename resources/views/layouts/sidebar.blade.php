<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/sidebar.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('/css/layout_sidebar.css') }}" rel="stylesheet" type="text/css" >

</head>
<body>
<div id="app">
    <header class="header">
        <h1>GET A RIDE</h1>
    </header>
    <nav class="sidenav">
        <div class="sidebar_icon">
            <img src="{{ Session::has('LoggedUserPic') ? asset('storage/'.Session::get('LoggedUser').'/'.Session::get('LoggedUserPic')) : asset('/images/avatar.png') }}" alt="moi" class="img_sidebar avatar_sidebar">
            <a class="personne" href="javascript:void(0)" onclick="closeNav()"> @if(Session::has('LoggedUser')) {{ Session::get('LoggedUser') }}@else Moi @endif</a>
        </div>

        <div class="sideline"></div>
        <div class="sidebar_icon">
            <img src="{{ asset('/images/home.png') }}" alt="accueil" class="img_sidebar">
            <a href="{{ url('/dashboard') }}"> Accueil</a>
        </div>

        <div class="sidebar_icon">
            <img src="{{ asset('/images/infos.png') }}" alt="informations" class="img_sidebar">
            <a href="{{ url('/user/edit') }}"> Mes informations</a>
        </div>
        <div class="sidebar_icon">
            <img src="{{ asset('/images/trajet.png') }}" alt="trajets" class="img_sidebar">
            <a href="{{route('trip/waiting')}}"> Mes trajets en attente</a>
        </div>
        <div class="sidebar_icon">
            <div class="notification_container">
                <img src="{{ asset('/images/notification.png') }}" alt="notifications" class="img_sidebar">
                <div class="align-content-center notif_sidebar">
                    @php
                        $username = session()->get('LoggedUser'); // pseudo de l'utilisateur connecté
                        $user = App\Models\User::where('username', '=', $username)->first();// model de l'utilisateur connecté
                        echo count($user->unreadNotifications);
                    @endphp
                </div>
            </div>
            <a href="{{ route('notification') }}"> Mes notifications</a>
        </div>
        <div class="sidebar_icon">
            <img src="{{ asset('/images/groupes.png') }}" alt="groupes_amis" class="img_sidebar">
            <a href="#"> Mes groupes d'amis</a>
        </div>
        <div class="sidebar_icon">
            <img src="{{ asset('/images/note.png') }}" alt="notes" class="img_sidebar">
            <a href="#"> Mes notes attribuées</a>
        </div>
        <div class="sidebar_icon">
            <img src="{{ asset('/images/deconnexion.png') }}" alt="déconnexion" class="img_sidebar">
            <a href="{{ url('/logout') }}"> Déconnexion</a>
        </div>
    </nav>
    <main class="py-4">
        <div class="content-container">
            @yield('content')
            <div class="flash-message">
                @include('include.flash-message')
            </div>
        </div>
    </main>
</div>
</body>
</html>
