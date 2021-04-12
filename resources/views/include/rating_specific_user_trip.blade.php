<link href="{{ asset('/css/rating.css') }}" rel="stylesheet" type="text/css" >
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@php

@endphp
<div id="half-stars-example">
    <div class="rating-group">
        <input class="rating__input rating__input--none enabled" name="rating{{ $user }}_{{ $trip }}" id="rating-none{{ $user }}_{{ $trip }}" value="0" type="radio" checked>
        <label aria-label="No rating" class="rating__label enabled" for="rating-none{{ $user }}_{{ $trip }}"><i class="rating__icon rating__icon--none fa fa-ban"></i></label>

        <label aria-label="0 stars" class="rating__label enabled" for="rating{{ $user }}_{{ $trip }}-0">&nbsp;</label>
        <label aria-label="0.5 stars" class="rating__label enabled rating__label--half" for="rating{{ $user }}_{{ $trip }}-05"><i class="rating__icon rating__icon--star enabled fa fa-star-half"></i></label>
        <input class="rating__input enabled" name="rating{{ $user }}_{{ $trip }}" id="rating{{ $user }}_{{ $trip }}-05" value="0.5" type="radio">
        <label aria-label="1 star" class="rating__label enabled" for="rating{{ $user }}_{{ $trip }}-10"><i class="rating__icon rating__icon--star enabled fa fa-star"></i></label>
        <input class="rating__input enabled" name="rating{{ $user }}_{{ $trip }}" id="rating{{ $user }}_{{ $trip }}-10" value="1" type="radio">
        <label aria-label="1.5 stars" class="rating__label enabled rating__label--half" for="rating{{ $user }}_{{ $trip }}-15"><i class="rating__icon rating__icon--star enabled fa fa-star-half"></i></label>
        <input class="rating__input enabled" name="rating{{ $user }}_{{ $trip }}" id="rating{{ $user }}_{{ $trip }}-15" value="1.5" type="radio">
        <label aria-label="2 stars" class="rating__label enabled" for="rating{{ $user }}_{{ $trip }}-20"><i class="rating__icon rating__icon--star enabled fa fa-star"></i></label>
        <input class="rating__input enabled" name="rating{{ $user }}_{{ $trip }}" id="rating{{ $user }}_{{ $trip }}-20" value="2" type="radio">
        <label aria-label="2.5 stars" class="rating__label enabled rating__label--half" for="rating{{ $user }}_{{ $trip }}-25"><i class="rating__icon rating__icon--star enabled fa fa-star-half"></i></label>
        <input class="rating__input enabled" name="rating{{ $user }}_{{ $trip }}" id="rating{{ $user }}_{{ $trip }}-25" value="2.5" type="radio">
        <label aria-label="3 stars" class="rating__label enabled" for="rating{{ $user }}_{{ $trip }}-30"><i class="rating__icon rating__icon--star enabled fa fa-star"></i></label>
        <input class="rating__input enabled" name="rating{{ $user }}_{{ $trip }}" id="rating{{ $user }}_{{ $trip }}-30" value="3" type="radio">
        <label aria-label="3.5 stars" class="rating__label enabled rating__label--half" for="rating{{ $user }}_{{ $trip }}-35"><i class="rating__icon rating__icon--star enabled fa fa-star-half"></i></label>
        <input class="rating__input enabled" name="rating{{ $user }}_{{ $trip }}" id="rating{{ $user }}_{{ $trip }}-35" value="3.5" type="radio">
        <label aria-label="4 stars" class="rating__label enabled" for="rating{{ $user }}_{{ $trip }}-40"><i class="rating__icon rating__icon--star enabled fa fa-star"></i></label>
        <input class="rating__input enabled" name="rating{{ $user }}_{{ $trip }}" id="rating{{ $user }}_{{ $trip }}-40" value="4" type="radio">
        <label aria-label="4.5 stars" class="rating__label enabled rating__label--half" for="rating{{ $user }}_{{ $trip }}-45"><i class="rating__icon rating__icon--star enabled fa fa-star-half" ></i></label>
        <input class="rating__input enabled" name="rating{{ $user }}_{{ $trip }}" id="rating{{ $user }}_{{ $trip }}-45" value="4.5" type="radio">
        <label aria-label="5 stars" class="rating__label enabled" for="rating{{ $user }}_{{ $trip }}-50"><i class="rating__icon rating__icon--star enabled fa fa-star"></i></label>
        <input class="rating__input enabled" name="rating{{ $user }}_{{ $trip }}" id="rating{{ $user }}_{{ $trip }}-50" value="5" type="radio">
    </div>
</div>
