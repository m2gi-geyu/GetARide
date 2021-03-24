<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel='stylesheet' href='https://s3-us-west-2.amazonaws.com/s.cdpn.io/141552/style.css'>
    <link rel="stylesheet" href="{{URL::asset('css/welcome.css')}}">
</head>
<body>
<div id="initial-loader" class="padded">
    <span id="loader-text"></span>
</div>
<div id="main-body">
    <section id="page-structure" class="ajax">
        <div id="canvas">
        </div>
        <div id="block-container" class="container">
            <div id="row1" class="row" align="center">
                <div id="title" class="col-md-12">GET A RIDE</div>
            </div>
            <div id="row2" class="row mt-5" align="center">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#monCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#monCarousel" data-slide-to="1"></li>
                        <li data-target="#monCarousel" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{URL::asset('images/trajet.jpg')}}" class="img-responsive"/>
                            <div class="carousel-caption"><h3>Planifiez vos trajets</h3></div>
                        </div>
                        <div class="carousel-item">
                            <img src="{{URL::asset('images/argent.jpg')}}" class="img-responsive"/>
                            <div class="carousel-caption"><h3>Faites des économies</h3></div>
                        </div>
                        <div class="carousel-item">
                            <img src="{{URL::asset('images/groupe.jpg')}}" class="img-responsive"/>
                            <div class="carousel-caption"><h3>Regroupez vous entre amis</h3></div>
                        </div>
                    </div>
                    <a href="#myCarousel" class="left carousel-control" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a href="#myCarousel" class="right carousel-control" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <?php
                    if(!session()->has('LoggedUser')){
                        echo '<div id="block5" class="col-md-12">Rejoignez nous vite !</div>
                <div id="block6" class="col-md-6"><a href="register"><button type="button" class="btn btn-perso btn-lg" >Inscrivez vous</button></a></div>
                <div id="block7" class="col-md-6"><a href="login"><button type="button" class="btn btn-perso btn-lg">Connectez vous</button></a></div>';
                    }
                ?>

                <?php
                if(session()->has('LoggedUser')){
                    echo '<div id="block6" class="col-md-6"><a href="logout"><button type="button" class="btn btn-perso btn-lg" >Se déconnecter</button></a></div>';
                }
                ?>

            </div>
        </div>
    </section>
</div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/three.js/r70/three.min.js'></script>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/t-18/CopyShader.js'></script>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/141552/03_glitch.js'></script>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/t-18/EffectComposer.js'></script>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/t-18/RenderPass.js'></script>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/t-18/ShaderPass.js'></script>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/t-18/MaskPass.js'></script>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/141552/08_texturepass.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.2/velocity.min.js'></script>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/t-18/GlitchPass.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="{{URL::asset('/js/animation.js')}}"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
