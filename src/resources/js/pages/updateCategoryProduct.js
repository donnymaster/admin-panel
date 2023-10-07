import checkIsErrorResponse from "../utils/checkIsErrorResponse";
import spreadResponse from "../utils/spreadResponse";

document.querySelector('#addCaregoryPropertyBtn')
    .addEventListener('click', (event) => {
        const btn = event.target;
        const categoryId = document.querySelector('input[name="categoty_id"]').value;
        const csrfToken = document.querySelector('input[name="_token"]').value;
        const name = document.querySelector('input[id="property-name"]').value;
        const description = document.querySelector('input[id="property-description"]').value;

        if (btn.classList.contains('disabled')) {
            return;
        }

        btn.classList.add('disabled');

        fetch(
            `/admin/catalog/categories/${categoryId}/addProperty`,
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    name,
                    description,
                })
            }
        )
        .then(spreadResponse)
        .then((res) => {
            if (checkIsErrorResponse(res)) {
                window.LaravelDataTables.dataTableBuilder.ajax.reload();
                document.querySelector('.close-modal').click();

                window.toast.push({
                    title: 'Успех!',
                    content: 'Свойство было добавлено!',
                    style: 'success',
                    dismissAfter: '2s'
                });

                document.querySelector('input[id="property-name"]').value = '';
                document.querySelector('input[id="property-description"]').value = '';
            }
        })
        .finally(() => {
            btn.classList.remove('disabled');
        });
    });


window.addEventListener('load', () => {
    window.LaravelDataTables.dataTableBuilder.on('init', () => {
        const table = document.querySelector('#dataTableBuilder_wrapper');

        table
            .addEventListener('click', (event) => {
                const el = event.target;

                if (el.classList.contains('edit')) {
                    updateCategoryproperty(el.dataset);
                }

                if (!el.classList.contains('delete')) {
                    return;
                }

                const csrfToken = document.querySelector('input[name="_token"]').value;
                const categoryId = document.querySelector('input[name="categoty_id"]').value;
                const propertyId = el.dataset.id;

                // disable table
                table.classList.add('load');

                fetch(
                    `/admin/catalog/categories/${categoryId}/property/${propertyId}`,
                    {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                    }
                )
                .then(spreadResponse)
                .then((response) => {
                    if (checkIsErrorResponse(response)) {
                        window.toast.push({
                            title: 'Успех!',
                            content: 'Свойство было удалено!',
                            style: 'success',
                            dismissAfter: '2s'
                        });
                        window.LaravelDataTables.dataTableBuilder.ajax.reload();
                    }
                })
                .finally(() => {
                    table.classList.remove('load');
                });
            });
    });
});


function updateCategoryproperty(dataset) {
    const nameInput = document.querySelector('.modal[data-modal="update-category-property"] input[id="name-property"]');
    const descriptionInput = document.querySelector('.modal[data-modal="update-category-property"] input[id="description-property"]');
    document.querySelector('.modal[data-modal="update-category-property"] input[name="property_id"]').value = dataset.id;

    nameInput.value = dataset.name;
    descriptionInput.value = dataset.description;

    document.querySelector('.modal-btn[data-modal="update-category-property"]').click();
}

document.querySelector('#updateCaregoryPropertyBtn')
    .addEventListener('click', ({target}) => {
        if (target.classList.contains('disabled')) {
            return;
        }

        target.classList.add('disabled');

        const nameInput = document.querySelector('.modal[data-modal="update-category-property"] input[id="name-property"]');
        const descriptionInput = document.querySelector('.modal[data-modal="update-category-property"] input[id="description-property"]');
        const table = document.querySelector('#dataTableBuilder_wrapper');
        const csrfToken = document.querySelector('input[name="_token"]').value;
        const categoryId = document.querySelector('input[name="categoty_id"]').value;
        const propertyId = document.querySelector('.modal[data-modal="update-category-property"] input[name="property_id"]').value;

        table.classList.add('load');

        fetch(
            `/admin/catalog/categories/${categoryId}/property/${propertyId}`,
            {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    name: nameInput.value,
                    description: descriptionInput.value,
                })
            }
        )
        .then(spreadResponse)
        .then((response) => {
            if (checkIsErrorResponse(response)) {
                window.toast.push({
                    title: 'Успех!',
                    content: 'Свойство было обновлено!',
                    style: 'success',
                    dismissAfter: '2s'
                });
                window.LaravelDataTables.dataTableBuilder.ajax.reload();
                document.querySelector('.modal[data-modal="update-category-property"] .close-modal').click();
            }
        })
        .finally(() => {
            target.classList.remove('disabled');
            table.classList.remove('load');
        });
    });
