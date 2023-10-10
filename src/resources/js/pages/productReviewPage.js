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

            if (target.classList.contains('edit')) {
                showEditModal(target);
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
    modal.querySelector('.description').innerHTML = review.client_review;

    document.querySelector('.modal-btn[data-modal="show-review"]').click();
}

function showEditModal(el) {
    const review = window.LaravelDataTables['productreviews-table'].ajax.json().data.find(element => element.id == el.dataset.id);

    document.querySelector('.modal[data-modal="update-review"] .title').textContent = review.name_variant;
    document.querySelector('.modal[data-modal="update-review"] input[id="review-position"]').value = review.position;

    document.querySelector('.modal-btn[data-modal="update-review"]').click();
    document.querySelector('#updateProductReview').setAttribute('data-id', review.id);
}

document.querySelector('#updateProductReview')
    .addEventListener('click', ({target}) => {
        const id = target.dataset.id;
        const position = document.querySelector('.modal[data-modal="update-review"] input[id="review-position"]').value;

        if (target.classList.contains('disabled')) {
            return;
        }

        target.classList.add('disabled');

        fetch(
            `/admin/catalog/product-reviews/${id}`,
            {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window._token,
                },
                body: JSON.stringify({ position })
            }
        )
        .then(spreadResponse)
        .then((response) => {
            if (checkIsErrorResponse(response)) {
                window.toast.push({
                    title: 'Успех!',
                    content: 'Комментарий был обновлен!',
                    style: 'success',
                    dismissAfter: '2s'
                });

                document.querySelector('.modal[data-modal="update-review"] .close-modal').click();
            }
        }).finally(() => target.classList.remove('disabled'));
    });
