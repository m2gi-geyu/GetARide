<link href="{{ asset('/css/rating.css') }}" rel="stylesheet" type="text/css" >
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@php
/*nombre de gens notables attention 0 = non noté
*/$name_suffix = isset($count) ? $count : 1;
/* note page user */
$rated = isset($rating) ? $rating : -1;
@endphp
<div id="half-stars-example">
    <div class="rating-group">
        <input class="rating__input {{ isset($enabled) ? 'enabled' : '' }} rating__input--none {{ isset($enabled) ? 'enabled' : '' }}" name="rating{{ $name_suffix }}" id="rating-none{{ $name_suffix }}" value="0" type="radio" checked>
        <label aria-label="No rating" class="rating__label {{ isset($enabled) ? 'enabled' : '' }}" for="rating-none{{ $name_suffix }}"><i class="rating__icon rating__icon--none fa fa-ban"></i></label>

        <label aria-label="0 stars" class="rating__label" for="rating{{ $name_suffix }}-0">&nbsp;</label>
        <label aria-label="0.5 stars" class="rating__label rating__label--half" for="rating{{ $name_suffix }}-05"><i class="rating__icon rating__icon--star fa fa-star-half {{ ($rated != -1 && $rated >= 0.5) ? 'orange' : '' }}"></i></label>
        <input class="rating__input {{ isset($enabled) ? 'enabled' : '' }} {{ isset($enabled) ? 'enabled' : '' }}" name="rating{{ $name_suffix }}" id="rating{{ $name_suffix }}-05" value="0.5" type="radio">
        <label aria-label="1 star" class="rating__label" for="rating{{ $name_suffix }}-10"><i class="rating__icon rating__icon--star fa fa-star {{ ($rated != -1 && $rated >= 1) ? 'orange' : '' }}"></i></label>
        <input class="rating__input {{ isset($enabled) ? 'enabled' : '' }}" name="rating{{ $name_suffix }}" id="rating{{ $name_suffix }}-10" value="1" type="radio">
        <label aria-label="1.5 stars" class="rating__label rating__label--half" for="rating{{ $name_suffix }}-15"><i class="rating__icon rating__icon--star fa fa-star-half {{ ($rated != -1 && $rated >= 1.5) ? 'orange' : '' }}"></i></label>
        <input class="rating__input {{ isset($enabled) ? 'enabled' : '' }}" name="rating{{ $name_suffix }}" id="rating{{ $name_suffix }}-15" value="1.5" type="radio">
        <label aria-label="2 stars" class="rating__label" for="rating{{ $name_suffix }}-20"><i class="rating__icon rating__icon--star fa fa-star {{ ($rated != -1 && $rated >= 2) ? 'orange' : '' }}"></i></label>
        <input class="rating__input {{ isset($enabled) ? 'enabled' : '' }}" name="rating{{ $name_suffix }}" id="rating{{ $name_suffix }}-20" value="2" type="radio">
        <label aria-label="2.5 stars" class="rating__label rating__label--half" for="rating{{ $name_suffix }}-25"><i class="rating__icon rating__icon--star fa fa-star-half {{ ($rated != -1 && $rated >= 2.5) ? 'orange' : '' }}"></i></label>
        <input class="rating__input {{ isset($enabled) ? 'enabled' : '' }}" name="rating{{ $name_suffix }}" id="rating{{ $name_suffix }}-25" value="2.5" type="radio">
        <label aria-label="3 stars" class="rating__label" for="rating{{ $name_suffix }}-30"><i class="rating__icon rating__icon--star fa fa-star {{ ($rated != -1 && $rated >= 3) ? 'orange' : '' }}"></i></label>
        <input class="rating__input {{ isset($enabled) ? 'enabled' : '' }}" name="rating{{ $name_suffix }}" id="rating{{ $name_suffix }}-30" value="3" type="radio">
        <label aria-label="3.5 stars" class="rating__label rating__label--half" for="rating{{ $name_suffix }}-35"><i class="rating__icon rating__icon--star fa fa-star-half {{ ($rated != -1 && $rated >= 3.5) ? 'orange' : '' }}"></i></label>
        <input class="rating__input {{ isset($enabled) ? 'enabled' : '' }}" name="rating{{ $name_suffix }}" id="rating{{ $name_suffix }}-35" value="3.5" type="radio">
        <label aria-label="4 stars" class="rating__label" for="rating{{ $name_suffix }}-40"><i class="rating__icon rating__icon--star fa fa-star {{ ($rated != -1 && $rated >= 4) ? 'orange' : '' }}"></i></label>
        <input class="rating__input {{ isset($enabled) ? 'enabled' : '' }}" name="rating{{ $name_suffix }}" id="rating{{ $name_suffix }}-40" value="4" type="radio">
        <label aria-label="4.5 stars" class="rating__label rating__label--half" for="rating{{ $name_suffix }}-45"><i class="rating__icon rating__icon--star fa fa-star-half {{ ($rated != -1 && $rated >= 4.5) ? 'orange' : '' }}" ></i></label>
        <input class="rating__input {{ isset($enabled) ? 'enabled' : '' }}" name="rating{{ $name_suffix }}" id="rating{{ $name_suffix }}-45" value="4.5" type="radio">
        <label aria-label="5 stars" class="rating__label" for="rating{{ $name_suffix }}-50"><i class="rating__icon rating__icon--star fa fa-star {{ ($rated != -1 && $rated >= 5) ? 'orange' : '' }}"></i></label>
        <input class="rating__input {{ isset($enabled) ? 'enabled' : '' }}" name="rating{{ $name_suffix }}" id="rating{{ $name_suffix }}-50" value="5" type="radio">
    </div>
</div>
