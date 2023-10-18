import ConvertWordsToTranscription from "../components/ConvertWordsToTranscription";

new ConvertWordsToTranscription();

document.addEventListener("DOMContentLoaded", () => {
    document.querySelector('.visible-page')
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


    document.querySelector('.is-track')
        .addEventListener('click', (event) => {
            const btn = event.target;
            const input = btn.querySelector('input');

            if (btn.classList.contains('track-icon')) {
                input.value = 0;
            } else {
                input.value = 1;
            }

            btn.classList.toggle('track-icon');
            btn.classList.toggle('no-track-icon');

        });

});
