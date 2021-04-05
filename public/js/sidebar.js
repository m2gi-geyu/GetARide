function closeNav() {
    document.querySelectorAll(`.sidebar_icon:nth-child(1) ~ *`).forEach(el => {
        el.style.display = "none";
    });
    document.querySelector('.personne').removeAttribute('onclick');
    document.querySelector('.sidenav').setAttribute("style", "border-bottom: 0.5vw solid #E76F51;");
    $('.sidenav').animate({
        'height': '5vw',
    }, {
        duration: 500,
        complete: function () {
            document.querySelector('.personne').setAttribute('onclick', 'openNav()');
        }
    })
}


function openNav() {
    document.querySelector('.sidenav').style.borderBottom = "none";
    document.querySelector('.personne').removeAttribute('onclick');
    $('.sidenav').animate({
        'height': '100%',
    }, {
        duration: 500,
        complete: function () {
            document.querySelectorAll(`.sidebar_icon:nth-child(1) ~ *`).forEach(el => {
                el.style.display = "flex";
            });
            document.querySelector('.personne').setAttribute('onclick', 'closeNav()');
        }
    })
}
