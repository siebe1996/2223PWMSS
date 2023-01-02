(function() {
   let expandToggles = document.querySelectorAll('.expandToggle');
   let toggleClass = (target) => {
       if (!target.classList.contains('available'))
           toggleClass(target.parentElement);
       else {
           target.classList.toggle('hidden');
       }
   }
    expandToggles.forEach((toggle) => {
        toggle.addEventListener('click', (event)=>{
            toggleClass(event.target);
        });
    });
})()