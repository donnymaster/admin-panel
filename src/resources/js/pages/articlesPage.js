import checkIsErrorResponse from "../utils/checkIsErrorResponse";
import spreadResponse from "../utils/spreadResponse";

window.addEventListener('load', () => {
    window.datatables = window.LaravelDataTables['blogarticle-table'];

    window.datatables.on('init', () => addEventClickRowTable());
});

function addEventClickRowTable() {
    document.querySelector('.dataTables_wrapper')
        .addEventListener('click', ({target}) => {
            if (target.classList.contains('not-visible') || target.classList.contains('visible')) {
                changeVisibleArticle(!!target.classList.contains('not-visible'), target.dataset.id);
            }

            if (target.classList.contains('delete')) {
                deleteArticle(target.dataset.id);
            }

            if (target.classList.contains('edit')) {
                window.open(`/admin/articles/${target.dataset.id}`, '_top');
            }
        });
}

function changeVisibleArticle(visible, id) {
    const table = document.querySelector('#blogarticle-table_wrapper');

    if (table.classList.contains('load')) {
        return;
    }

    table.classList.add('load');

    fetch(
        `/admin/articles/${id}`,
        {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': window._token,
            },
            body: JSON.stringify({ visible })
        }
    )
    .then(spreadResponse)
    .then((response) => {
        if (checkIsErrorResponse(response)) {
            window.toast.push({
                title: 'Успех!',
                content: 'Статья была обновлена!',
                style: 'success',
                dismissAfter: '1s'
            });
            window.datatables.ajax.reload();
        }
    })
    .finally(() => table.classList.remove('load'));
}

function deleteArticle(id) {
    const table = document.querySelector('#blogarticle-table_wrapper');

    if (table.classList.contains('load')) {
        return;
    }

    table.classList.add('load');

    fetch(
        `/admin/articles/${id}`,
        {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': window._token,
            },
        }
    )
    .then(spreadResponse)
    .then((response) => {
        if (checkIsErrorResponse(response)) {
            window.toast.push({
                title: 'Успех!',
                content: 'Статья была удалена!',
                style: 'success',
                dismissAfter: '1s'
            });
            window.datatables.ajax.reload();
        }
    })
    .finally(() => table.classList.remove('load'));
}
