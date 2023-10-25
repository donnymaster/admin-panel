import checkIsErrorResponse from "../utils/checkIsErrorResponse";
import spreadResponse from "../utils/spreadResponse";


window.addEventListener('load', () => {
    window.datatables = window.LaravelDataTables['productcategoryproperty-table'];

    window.datatables.on('init', () => addEventClickRowTable());
});

function addEventClickRowTable() {
    document.querySelector('#productcategoryproperty-table_wrapper')
        .addEventListener('click', ({ target }) => {
            if (target.classList.contains('edit')) {
                openModalUpdateProperty(target);
            }

            if (target.classList.contains('delete')) {
                deleteProperty(target);
            }
        });
}

function openModalUpdateProperty(target) {
    const id = target.dataset.id;

    const row = window.datatables.ajax.json().data.find(item => item.id == id);

    const modal = document.querySelector('.modal[data-modal="update-property"]');

    modal.querySelector('input[name="name"]').value = row.name;
    modal.querySelector('input[name="description"]').value = row.description;
    modal.querySelector('input[name="mark"]').value = row.mark;

    document.querySelector('.modal-btn[data-modal="update-property"]').click();

    document.querySelector('#updatePropertyBtn').setAttribute('data-id', row.id);
}

function deleteProperty(target) {
    const id = target.dataset.id;
    const table = target.closest('.dataTables_wrapper');

    if (table.classList.contains('load')) {
        return;
    }

    table.classList.add('load');

    fetch(
        `/admin/catalog/properties/${id}`,
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
                window.datatables.ajax.reload();
                window.toast.push({
                    title: 'Успех!',
                    content: 'Свойство было удалено!',
                    style: 'success',
                    dismissAfter: '1s'
                });
            }
        })
        .finally(() => table.classList.remove('load'));
}

document.querySelector('#createPropertyBtn')
    .addEventListener('click', ({target}) => {
        if (target.classList.contains('disabled')) return;

        target.classList.add('disabled');
        const object = {};

        (new FormData(document.querySelector('.modal[data-modal="create-property"] form')))
            .forEach((value, key) => object[key] = value);

        fetch(
            '/admin/catalog/properties',
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window._token,
                },
                body: JSON.stringify(object)
            }
        )
        .then(spreadResponse)
        .then(response => {
            if (!checkIsErrorResponse(response)) return;

            window.datatables.ajax.reload();

            window.toast.push({
                title: 'Успех!',
                content: 'Свойство было добавлено!',
                style: 'success',
                dismissAfter: '1s'
            });
            document.querySelector('.modal[data-modal="create-property"] .close-modal').click();

        }).finally(() => target.classList.remove('disabled'));
    });

document.querySelector('#updatePropertyBtn')
    .addEventListener('click', ({target}) => {
        const id = target.dataset.id;

        if (target.classList.contains('disabled')) return;

        target.classList.add('disabled');
        const object = {};

        (new FormData(document.querySelector('.modal[data-modal="update-property"] form')))
            .forEach((value, key) => object[key] = value);

            fetch(
                `/admin/catalog/properties/${id}`,
                {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': window._token,
                    },
                    body: JSON.stringify(object)
                }
            )
                .then(spreadResponse)
                .then((response) => {
                    if (checkIsErrorResponse(response)) {
                        window.datatables.ajax.reload();

                        window.toast.push({
                            title: 'Успех!',
                            content: 'Свойство было обновлено!',
                            style: 'success',
                            dismissAfter: '1s'
                        });

                        document.querySelector('.modal[data-modal="update-property"] .close-modal').click();
                    }
                })
                .finally(() => target.classList.remove('disabled'));
    });
