$(document).ready(function() {
    var inputs_enabled = $(".rating__input:not(.enabled)");
    for (var i = 0; i < inputs_enabled.length; i++) {
        inputs_enabled[i].disabled = true;
    }

    var stars = $(".rating__icon--star:not(.enabled)");
    for(var i = 0; i < stars.length; i++) {
        stars[i].style.color = "#ddd";
    }

    var orange_stars = $(".orange");
    for(var i = 0; i < orange_stars.length; i++) {
        orange_stars[i].style.color = "orange";
    }
});
