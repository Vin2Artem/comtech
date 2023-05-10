const form = document.querySelector('#mainForm');
const err = document.querySelector('#errBlock');

form.addEventListener('submit', async (event) => {
    event.preventDefault();
    err.innerHTML = '';
    if (typeof validateForm === "function") {
        const valid = validateForm(form);
        if (valid !== true) {
            err.innerHTML = valid;
            return;
        }
    }
    const formData = new FormData(form);
    const response = await fetch(form.action, {
        method: 'POST',
        body: formData
    });
    console.log(response);
    if (response.redirected) {
        window.location.href = response.url;
    } else if (response.ok) {
        err.innerHTML = (await response.text()).replace(/\r?\n|\r/g, "<br>");
    } else {
        err.innerHTML = 'Ошибка сервера. Повторите ещё раз через некоторое время или свяжитесь с нами';
    }
});

