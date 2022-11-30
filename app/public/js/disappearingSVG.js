(function () {
    const inputs = document.querySelectorAll("input");
    const passwordSVG = document.querySelector(".password");
    const usernameSVG = document.querySelector(".username");
    console.log("ok")
    const hasText = (input) => {
        if (input.value !== "") {
            if (input.type === 'password') {
                passwordSVG.classList.add('hasText');
            } else {
                usernameSVG.classList.add('hasText')
            }
        } else {
            if (input.type === 'password') {
                passwordSVG.classList.remove('hasText');
            } else {
                usernameSVG.classList.remove('hasText')
            }
        }
    }
    inputs.forEach(input => {
        hasText(input);
        input.addEventListener('keydown', () => {
            hasText(input);
        })
    })
})
()