document.querySelector('.visible-article')
    .addEventListener('click', (event) => {
        const btn = event.target;
        const input = btn.querySelector('input');

        if (btn.classList.contains('visible')) {
            input.value = 0;
        } else {
            input.value = 1;
        }

        btn.classList.toggle('visible');
        btn.classList.toggle('not-visible');

    });
