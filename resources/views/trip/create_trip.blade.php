<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wisth-device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible"  content="ie=edge">
    <title>Create Ride</title>
    <link rel="stylesheet" href="{{asset('styles/bootstrap/dist/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/accueil.css')}}">
</head>
<body>
<div class="container">
    <div class="row">

        <div class="col-md-4"></div>
        <div class="col-md-4 ">
            <h3>GET A RIDE</h3>
            <form action="{{ route('trip/create') }}" method="post">
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
                <h4>Departure</h4>
                    <div  class="form-group">
                        <label for="departure">Departure city</label>
                        <input type="text" class="form-control" name="departure" placeholder="Enter departure city" value="{{old('departure')}}">
                        <span class="text-danger">@error('departure'){{$message}}@enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" name="date" value="{{old('date')}}">
                        <span class="text-danger">@error('date'){{$message}}@enderror</span>

                    </div>
                    <div class="form-group">
                        <label for="time">Time</label>
                        <input type="time" class="form-control" name="time" value="{{old('time')}}">
                        <span class="text-danger">@error('time'){{$message}}@enderror</span>

                    </div>

                <h4>Arrival</h4>
                    <div class="form-group">
                        <label for="final">Final city</label>
                        <input type="text" class="form-control" name="final" placeholder="Enter final city" value="{{old('final')}}">
                        <span class="text-danger">@error('final'){{$message}}@enderror</span>
                    </div>

                <h4>Intermediate city</h4>
                    <div class="form-group">
                        <button  class="btn btn-block btn-primary">+</button>
                    </div>

                <h4>Trip</h4>
                    <div class="form-group">
                        <label for="nb_passengers">Passenger number</label>
                        <input type="number" name="nb_passengers" min="1" max="6" value="{{old('nb_passengers')}}">
                        <span class="text-danger">@error('nb_passengers'){{$message}}@enderror</span>

                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price" min="0" max="10000" step="0.1" value="{{old('price')}}">
                        <span class="text-danger">@error('price'){{$message}}@enderror</span>

                    </div>
                    <div class="form-group">
                        <label for="info">Complementary Informations</label>
                        <textarea name="info" rows="5" cols="40"></textarea>
                    </div>

                <h4>Privacy</h4>
                    <div class="form-group">
                        <input type="radio" id="public" name="privacy" onclick="myFunction()" value="public">
                        <label for="public">Public</label>
                        <input type="radio" id="private" name="privacy" onclick="myFunction()" value="private" >
                        <label for="private">Private</label>
                        <span class="text-danger">@error('privacy'){{$message}}@enderror</span>


                        <div class="form-group">
                            @foreach($data as $item)
                                <input type="radio" id="group" name="group" value={{$item->name}} >
                                <label for={{$item->name}}>{{$item->name}}</label><br />
                            @endforeach
                                <span class="text-danger">@error('group'){{$message}}@enderror</span>

                        </div>
                    </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary">Proposer un trajet</button>
                </div>
            </form>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
<script type="text/javascript" >
    var public = document.querySelectorAll("input[type=radio][name=privacy][id=public]");
    var private = document.querySelectorAll("input[type=radio][name=privacy][id=private]");


    for (var i = 0, iLen = public.length; i < iLen; i++) {
        public[i].onclick = function() {
            showResult('group',true);
        }
    }

    for (var i = 0, iLen = private.length; i < iLen; i++) {
        private[i].onclick = function() {
            showResult('group',false);
        }
    }

    function showResult(name,bool) {
        var x = document.getElementsByName(name);
        for (var i = 0; i < x.length; i++) {
            x[i].disabled = bool;
        }
    }



</script>
</body>
</html>

