import checkIsErrorResponse from "../utils/checkIsErrorResponse";
import spreadResponse from "../utils/spreadResponse";

document.querySelector('.check-status-files')
    .addEventListener('click', checkFiles);

function checkFiles({target}) {
    if (target.classList.contains('disabled')) return;

    target.classList.add('disabled');

    fetch(
        '/admin/data-exchange/files/health',
    )
    .then(spreadResponse)
    .then(response => {
        if (!checkIsErrorResponse(response)) return;
        rednerData(response.data);
        document.querySelector('.status-btn').click();
    }).finally(() => target.classList.remove('disabled'));
}

function rednerData(data) {
    const htmlString = `
        <div>
            <p>
                Файл 'offers': ${data.offers ? 'существует' : 'отсутствует'}!
            </p>
            <p>
                Файл 'import': ${data.import ? 'существует' : 'отсутствует'}!
            </p>
            <p>
                Папка 'files': ${data.files ? 'существует' : 'отсутствует'}!
            </p>
        </div>
    `;

    const container = document.querySelector('.description-files');

    while (container.firstChild) {
        container.removeChild(container.lastChild);
    }

    container.insertAdjacentHTML('beforeend', htmlString);
}

document.querySelector('.run-import')
    .addEventListener('click', ({target}) => {
        if (target.classList.contains('disabled')) return;

        target.classList.add('disabled');

        fetch(
            '/admin/data-exchange/run',
        )
        .then(spreadResponse)
        .then(response => {
            if (!checkIsErrorResponse(response)) return;
            window.toast.push({
                title: 'Успех!',
                content: 'Задача добавлена в очередь!',
                style: 'success',
                dismissAfter: '2s'
            });
            window.datatables.ajax.reload();
        }).finally(() => target.classList.remove('disabled'));
    });

window.addEventListener('load', () => {
    window.datatables = window.LaravelDataTables['dataexchange-table'];
});

document.querySelector('.refresh-table')
    .addEventListener('click', () => {
        window.datatables.ajax.reload();
    });

document.querySelector('.delete-files-import')
    .addEventListener('click', ({target}) => {
        if (target.classList.contains('disabled')) return;

        target.classList.add('disabled');

        fetch(
            '/admin/data-exchange/files/delete',
            {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': window._token,
                },
            }
        )
        .then(spreadResponse)
        .then(response => {
            if (!checkIsErrorResponse(response)) return;
            window.toast.push({
                title: 'Успех!',
                content: 'Файлы были удалены!',
                style: 'success',
                dismissAfter: '2s'
            });
        }).finally(() => target.classList.remove('disabled'));
    });
