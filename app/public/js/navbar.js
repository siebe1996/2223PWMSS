(function () {
    const overlayToggle = document.querySelectorAll(".navbarToggle");
    const newRideToggle = document.querySelectorAll(".newRideToggle");
    const main = document.querySelector("main");
    const body = document.querySelector('body');
    const nav = document.querySelector('nav');

    const toggleNavbar = ()=> {
        if(body.classList.contains('overlayOpen')) {
            nav.classList.remove('openingNavbar');
            nav.classList.toggle('closingNavbar')
        } else {
            nav.classList.remove('closingNavbar');
            nav.classList.toggle('openingNavbar')
        }
        body.classList.toggle('overlayOpen');
        body.classList.remove('newRide');

        document.querySelector('.btn.newRideToggle').classList.toggle('disabled-link');
    }

    main.addEventListener('click', () => {
        if (body.classList.contains('overlayOpen')) toggleNavbar();
    })
    overlayToggle.forEach(e => e.addEventListener('click', () => {
        toggleNavbar();
    }));
    newRideToggle.forEach(e => e.addEventListener('click', () => {
        document.querySelector('body').classList.toggle('newRide')
    }));
})()