import checkIsErrorResponse from "../utils/checkIsErrorResponse";
import spreadResponse from "../utils/spreadResponse";


window.addEventListener('load', () => {
    window.dVariants = window.LaravelDataTables['productvariants-table'];
    window.dUnique = window.LaravelDataTables['productuniqueproperty-table'];

    window.dUnique.on('init', () => addEventClickRowTableUniqueProperties());

    window.dVariants.on('error', (error) => {
        window.location.reload();
    });

    window.dUnique.on('error', (error) => {
        window.location.reload();
    });

});

const addNewUniqueProductPropertyBtn = document.querySelector('#createUniqueProperty');
const updateUniqueProductPropertyBtn  = document.querySelector('#updateUniqueProperty');

if (addNewUniqueProductPropertyBtn) {
    addNewUniqueProductPropertyBtn.addEventListener('click', createNewUniquePropductProperty);
}

if (updateUniqueProductPropertyBtn) {
    updateUniqueProductPropertyBtn.addEventListener('click', updateUniquePropertyById);
}

function createNewUniquePropductProperty({target}) {
    if (target.classList.contains('disabled')) {
        return;
    }

    const unique_name = document.querySelector('.modal[data-modal="create-unique-property"] input[id="name"]').value;
    const unique_value = document.querySelector('.modal[data-modal="create-unique-property"] input[id="value"]').value;
    const productId = document.querySelector('#formUpdateProduct').dataset.product;

    target.classList.add('disabled');

    fetch(
        `/admin/catalog/products/${productId}/unique-properties`,
        {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': window._token,
            },
            body: JSON.stringify({ unique_name, unique_value })
        }
    )
    .then(spreadResponse)
    .then((response) => {
        if (checkIsErrorResponse(response)) {
            window.toast.push({
                title: 'Успех!',
                content: 'Уникальное свовойство было добавлено!',
                style: 'success',
                dismissAfter: '2s'
            });
            window.dUnique.ajax.reload();
            document.querySelector('.modal[data-modal="create-unique-property"] .close-modal').click();
        }
    }).finally(() => target.classList.remove('disabled'));
}

function addEventClickRowTableUniqueProperties() {
    document.querySelector('#productuniqueproperty-table_wrapper')
        .addEventListener('click', handleClickTableUniqueProperties);
}

function handleClickTableUniqueProperties({target}) {
    if (target.classList.contains('edit')) {
        openModalUpdateUniqueProperty(target.dataset.id);
    }

    if (target.classList.contains('delete')) {
        deleteUniquePropertyById(target.dataset.id);
    }
}


function deleteUniquePropertyById(id) {
    const table =  document.querySelector('#productuniqueproperty-table_wrapper');
    const productId = document.querySelector('#formUpdateProduct').dataset.product;

    if (table.classList.contains('load')) {
        return;
    }

    table.classList.add('load');

    fetch(
        `/admin/catalog/products/${productId}/unique-properties/${id}/`,
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
                content: 'Уникальное свовойство было удалено!',
                style: 'success',
                dismissAfter: '2s'
            });
            window.dUnique.ajax.reload();
        }
    })
    .finally(() => table.classList.remove('load'));
}


function openModalUpdateUniqueProperty(id) {
    // data
    const property = window.dUnique.ajax.json().data.find((item) => item.id == id);

    document.querySelector('.modal[data-modal="update-unique-property"] input[id="property-name"]').value = property.unique_name;
    document.querySelector('.modal[data-modal="update-unique-property"] input[id="property-value"]').value = property.unique_value;

    document.querySelector('#updateUniqueProperty').setAttribute('data-id', id);

    document.querySelector('.modal-btn[data-modal="update-unique-property"]').click();
}



function updateUniquePropertyById() {
    const productId = document.querySelector('#formUpdateProduct').dataset.product;
    const propertyId = updateUniqueProductPropertyBtn.dataset.id;
    const unique_name = document.querySelector('.modal[data-modal="update-unique-property"] input[id="property-name"]').value;
    const unique_value = document.querySelector('.modal[data-modal="update-unique-property"] input[id="property-value"]').value;

    if (updateUniqueProductPropertyBtn.classList.contains('disabled')) {
        return;
    }

    updateUniqueProductPropertyBtn.classList.add('disabled');

    fetch(
        `/admin/catalog/products/${productId}/unique-properties/${propertyId}/`,
        {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': window._token,
            },
            body: JSON.stringify({ unique_name, unique_value })
        }
    )
    .then(spreadResponse)
    .then((response) => {
        if (checkIsErrorResponse(response)) {
            window.toast.push({
                title: 'Успех!',
                content: 'Уникальное свовойство было обновлено!',
                style: 'success',
                dismissAfter: '2s'
            });
            window.dUnique.ajax.reload();
            document.querySelector('.modal[data-modal="update-unique-property"] .close-modal').click();
        }
    }).finally(() => updateUniqueProductPropertyBtn.classList.remove('disabled'));
}
