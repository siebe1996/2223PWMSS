(function () {
    const toggle = document.querySelector(".btn.formToggle");
    const first = document.querySelector("section.firstFormSection");
    const second = document.querySelector("section.secondFormSection");


    const toggleFormSection = ()=> {
        first.classList.toggle('hidden');
        second.classList.toggle('hidden');
        if (toggle.innerHTML === 'Next') {

            toggle.innerHTML = 'Back';
        } else {
            toggle.innerHTML = 'Next';
        }
        toggle.classList.toggle('back');
    }
    console.log(toggle)

    toggle.addEventListener('click', () => {
        toggleFormSection();
    })
})()