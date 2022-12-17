(function () {
    const toggleNext = document.querySelector(".btn.formToggle.next");
    const toggleBack = document.querySelector(".btn.formToggle.back");
    const first = document.querySelector("section.firstFormSection");
    const second = document.querySelector("section.secondFormSection");
    const third = document.querySelector("section.thirdFormSection");

    let forms = {current: 0, next: 0};

    const toggleNextFormSection = () => {
        forms.next++;
        switch (forms.next) {
            case 2: {
                toggleFormSection2(second, third);
                break;
            }
            case 1: {
                toggleFormSection2(first, second);
                break;
            }
        }
        forms.current++;
    }
    const togglePreviousFormSection = () => {
        forms.next--;
        switch (forms.next) {
            case 0: {
                toggleFormSection2(second, first);
                break;
            }
            case 1: {
                toggleFormSection2(third, second);
                break;
            }
        }
        forms.current--;
    }

    const toggleFormSection2 = (a,b)=> {
        // a.classList.toggle('transforming');
        // b.classList.toggle('transforming');
        // toggleNext.classList.toggle('transforming');
        // toggleBack.classList.toggle('transforming');
        // setTimeout(()=> {
        //     a.classList.toggle('transforming');
        //     b.classList.toggle('transforming');
        //     toggleNext.classList.toggle('transforming');
        //     toggleBack.classList.toggle('transforming');
        // }, 200);
        a.classList.toggle('hidden');
        b.classList.toggle('hidden');
        if (forms.next === 2) {
            toggleNext.classList.add('hidden');
        } else if (forms.next === 0) {
            toggleBack.classList.add('hidden');
        } else {
            toggleNext.classList.remove('hidden');
            toggleBack.classList.remove('hidden');
        }
    }

    toggleNext.addEventListener('click', () => {
        toggleNextFormSection();
    })
    toggleBack.addEventListener('click', () => {
        togglePreviousFormSection(forms.current);
    })
})()