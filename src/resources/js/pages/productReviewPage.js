import checkIsErrorResponse from "../utils/checkIsErrorResponse";
import spreadResponse from "../utils/spreadResponse";

window.addEventListener('load', () => {
    window.datatables = window.LaravelDataTables['productreviews-table'];

    window.datatables.on('init', () => addEventClickRowTable());
    window.datatables.on('error', (error) => {
        window.location.reload();
    });

});

function addEventClickRowTable() {
    document.querySelector('.dataTables_wrapper')
        .addEventListener('click', ({target}) => {
            if (target.classList.contains('visible') || target.classList.contains('not-visible')) {
                changeVisibleReview(target);
            }

            if (target.classList.contains('delete')) {
                deleteReview(target);
            }

            if (target.classList.contains('show')) {
                showReview(target);
            }
        });
}

function changeVisibleReview(el) {
    const id = el.dataset.id;
    let status = parseInt(el.dataset.status);
    const table = el.closest('.dataTables_wrapper');

    if (table.classList.contains('load')) {
        return;
    }

    table.classList.add('load');

    fetch(
        `/admin/catalog/product-reviews/${id}`,
        {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': window._token,
            },
            body: JSON.stringify({ 'visible': !status })
        }
    )
    .then(spreadResponse)
    .then((response) => {
        if (checkIsErrorResponse(response)) {
            window.datatables.ajax.reload();

            window.toast.push({
                title: 'Успех!',
                content: 'Комментарий был обновлен!',
                style: 'success',
                dismissAfter: '2s'
            });
        }
    })
    .finally(() =>  table.classList.remove('load'));

}


function deleteReview(el) {
    const id = el.dataset.id;
    const table = el.closest('.dataTables_wrapper');

    if (table.classList.contains('load')) {
        return;
    }

    table.classList.add('load');

    fetch(
        `/admin/catalog/product-reviews/${id}`,
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
            window.datatables.ajax.reload();

            window.toast.push({
                title: 'Успех!',
                content: 'Комментарий был удален!',
                style: 'success',
                dismissAfter: '2s'
            });
        }
    })
    .finally(() =>  table.classList.remove('load'));

}

function showReview(el) {
    const id = el.dataset.id;
    const data = window.datatables.ajax.json().data;
    const modal = document.querySelector('.modal[data-modal="show-review"]');
    const review = data.find((item) => item.id == id);

    modal.querySelector('.title').textContent = review.product_variant.product.name;
    modal.querySelector('.client').textContent = `Клиент: ${review.client_name}`;
    modal.querySelector('.rating').textContent = `Количество балов: ${review.rating}`;
    modal.querySelector('.status').innerHTML = review.visible;
    modal.querySelector('.description').innerHTML = review.clent_review;

    document.querySelector('.modal-btn[data-modal="show-review"]').click();
}
