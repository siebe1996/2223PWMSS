(function () {
    const body = document.querySelector('body');
    const homeOverlayButton = document.querySelector('.closeHomeOverlay');

    homeOverlayButton.addEventListener('click',() => {
        body.classList.remove('newRide')
    })
})()