import checkIsErrorResponse from "../utils/checkIsErrorResponse";
import spreadResponse from "../utils/spreadResponse";

window.addEventListener('load', () => {
    window.datatables = window.LaravelDataTables['products-table'];

    window.datatables.on('init', () => addEventClickRowTable());
    window.datatables.on('error', (error) => {
        window.location.reload();
    });
});

function addEventClickRowTable() {
    document.querySelector('#products-table_wrapper')
        .addEventListener('click', ({target}) => {
            if (target.classList.contains('not-visible') || target.classList.contains('visible')) {
                changeVisibleProduct(!!target.classList.contains('not-visible'), target.dataset.id);
            }

            if (target.classList.contains('delete')) {
                deleteProduct(target.dataset.id);
            }
        });
}

function changeVisibleProduct(visible, id) {
    const table = document.querySelector('#products-table_wrapper');

    if (table.classList.contains('load')) {
        return;
    }

    table.classList.add('load');

    fetch(
        `/admin/catalog/products/${id}`,
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
                content: 'Продукт был обновлен!',
                style: 'success',
                dismissAfter: '2s'
            });
            window.datatables.ajax.reload();
        }
    })
    .finally(() => table.classList.remove('load'));
}


function deleteProduct(id) {
    const table = document.querySelector('#products-table_wrapper');

    if (table.classList.contains('load')) {
        return;
    }

    table.classList.add('load');

    fetch(
        `/admin/catalog/products/${id}`,
        {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': window._token,
            },
        }
    )
    .then(spreadResponse)
    .then((response) => {
        if (checkIsErrorResponse(response)) {
            window.toast.push({
                title: 'Успех!',
                content: 'Продукт был удален!',
                style: 'success',
                dismissAfter: '2s'
            });
            window.datatables.ajax.reload();
        }
    })
    .finally(() => table.classList.remove('load'));

}
