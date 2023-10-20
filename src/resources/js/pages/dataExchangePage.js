
document.querySelector('.check-status-files')
    .addEventListener('click', checkFiles);

function checkFiles({target}) {
    if (target.classList.contains('disabled')) return;

    target.classList.add('disabled');
}
