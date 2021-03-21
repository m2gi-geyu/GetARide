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
            <img src="{{ asset('/images/avatar.png') }}" alt="moi">
            <a class="personne" href="#"> Moi</a>
        </div>
        <div class="sideline"></div>
        <div class="sidebar_icon">
            <img src="{{ asset('/images/infos.png') }}" alt="informations">
            <a href="#"> Mes informations</a>
        </div>
        <div class="sidebar_icon">
            <img src="{{ asset('/images/trajet.png') }}" alt="trajets">
            <a href="#"> Mes trajets en attente</a>
        </div>
        <div class="sidebar_icon">
            <img src="{{ asset('/images/notification.png') }}" alt="notifications">
            <a href="#"> Mes notifications</a>
        </div>
        <div class="sidebar_icon">
            <img src="{{ asset('/images/groupes.png') }}" alt="groupes_amis">
            <a href="#"> Mes groupes d'amis</a>
        </div>
        <div class="sidebar_icon">
            <img src="{{ asset('/images/note.png') }}" alt="notes">
            <a href="#"> Mes notes attribuées</a>
        </div>
        <div class="sidebar_icon">
            <img src="{{ asset('/images/deconnexion.png') }}" alt="déconnexion">
            <a href="#"> Déconnexion</a>
        </div>
    </nav>
    <main class="py-4">
        <div class="content-container">
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
