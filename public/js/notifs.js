$( document ).ready(function() {
    $(".special_col").hide();
});

function defilerNotif(e) {
    document.querySelector('#row_'+e.value).setAttribute("style", "background-color: #2A9D8F;");
    document.querySelector('#row_'+e.value).style.border = "1px solid #F4A261";
    $('#special_col_'+e.value).show();
    document.querySelector('#defiler_'+e.value).setAttribute('onclick', 'enfilerNotif(this)');
}


function enfilerNotif(e) {
    document.querySelector('#row_'+e.value).setAttribute("style", "background-color: #EDDCD2;");
    document.querySelector('#row_'+e.value).style.border = "1px solid #B7B7A4";
    $('#special_col_'+e.value).hide();
    document.querySelector('#defiler_'+e.value).setAttribute('onclick', 'defilerNotif(this)');
}
