(function () {
    const toggle = document.querySelector(".btn.formToggle");
    const first = document.querySelector("section.firstFormSection");
    const second = document.querySelector("section.secondFormSection");


    const toggleFormSection = ()=> {
        first.classList.toggle('transforming');
        second.classList.toggle('transforming');
        toggle.classList.toggle('transforming');
        setTimeout(()=> {
            first.classList.toggle('transforming');
            second.classList.toggle('transforming');
            toggle.classList.toggle('transforming');
        }, 200);
        first.classList.toggle('hidden');
        second.classList.toggle('hidden');
        if (toggle.innerHTML === 'Next') {

            toggle.innerHTML = 'Back';
        } else {
            toggle.innerHTML = 'Next';
        }
        toggle.classList.toggle('back');
    }

    toggle.addEventListener('click', () => {
        toggleFormSection();
    })
})()