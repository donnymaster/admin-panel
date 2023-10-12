import checkIsErrorResponse from "../utils/checkIsErrorResponse";
import spreadResponse from "../utils/spreadResponse";

const codeGenerateContainers = document.querySelectorAll('.container-generate-code');
const promocodeVariantsContainers = document.querySelectorAll('.promocode-variants');
const btnCreatePromocode = document.querySelector('#createPromocodeBtn');
const changeStatePromocode = document.querySelector('.modal-header .status');
const updatePromocodeBtn = document.querySelector('.modal-btn[data-modal="update-promocode"]');
const createPromocodeBtn = document.querySelector('.modal-btn[data-modal="create-promocode"]');


class SearchEngineInput {
    constructor(
        url,
        parent,
        inputSearchSelector,
        inputNewName,
        parentlementSelector,
    ) {
        this.url = url;
        this.inputSearch = parent.querySelector(inputSearchSelector);
        this.inputNewName = inputNewName;
        this.parent = parent.querySelector(parentlementSelector);
        this.limit = 10;
        this.init();
    }

    init() {
        this.inputSearch.addEventListener('input', this.debounce(this.search.bind(this), 500));
        this.parent.insertAdjacentHTML('beforeend', `
            <input hidden name="${this.inputNewName}"/>
        `);

        this.parent.insertAdjacentHTML("afterbegin", `
            <div class="input-search-results"></div>
        `);

        this.resultContainer = this.parent.querySelector('.input-search-results');

        document.querySelector('body')
            .addEventListener('click', ({ target }) => {
                if (!!target.closest('.input-search-parent')) {
                    return;
                }

                this.resultContainer.style = 'display:none';
            });

        this.resultContainer.addEventListener('click', this.handlerClickToResultContainer.bind(this));
    }

    search({ target }) {

        fetch(
            `/admin/catalog/product-variants?limit=${this.limit}&search=${target.value}`,
        )
            .then(spreadResponse)
            .then((response) => {
                if (checkIsErrorResponse(response)) {
                    this.renderProducts(response.data);
                    this.resultContainer.style = 'display:flex';
                }
            });

        if (target.value === '') {
            this.parent.querySelector(`input[name="${this.inputNewName}"]`).value = '';
        }
    }

    handlerClickToResultContainer({ target }) {
        if (!target.classList.contains('search-element')) {
            return;
        }

        this.parent.querySelector(`input[name="${this.inputNewName}"]`).value = target.dataset.id;
        this.inputSearch.value = target.textContent;
        this.resultContainer.style = 'display:none';
    }

    renderProducts(products = []) {
        while (this.resultContainer.firstChild) {
            this.resultContainer.removeChild(this.resultContainer.lastChild);
        }

        if (products.length === 0) {
            this.resultContainer.insertAdjacentHTML('afterbegin', `
                <div class="empty-data">Ничего не найдено!</div>
            `);
        }

        products.forEach((product) => {
            const productElement = document.createElement('div');
            productElement.classList.add('search-element');
            productElement.setAttribute('data-id', product.id);
            productElement.textContent = product.title;

            this.resultContainer.append(productElement);
        });
    }

    debounce(func, timeout = 300) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => { func.apply(this, args); }, timeout);
        };
    }

    setValueSearchInput(value = '') {
        this.inputSearch.value = value;
    }

    setValueInputHidden(value = '') {
        this.parent.querySelector(`input[name="${this.inputNewName}"]`).value = value;
    }

}

const searchEngineInputUpdatePromocode = new SearchEngineInput(
    '/',
    document.querySelector('.modal[data-modal="update-promocode"]'),
    'input[id="new-product"]',
    'product_id',
    '.input-search-parent'
);


window.addEventListener('load', () => {
    window.datatables = window.LaravelDataTables['promocodes-table'];

    window.datatables.on('init', () => addEventClickRowTable());
    window.datatables.on('error', (error) => {
        window.location.reload();
    });
});

function addEventClickRowTable() {
    document.querySelector('#promocodes-table_wrapper')
        .addEventListener('click', ({ target }) => {
            if (target.classList.contains('edit')) {
                openModalUpdatePromocode(target);
            }

            if (target.classList.contains('delete')) {
                deletePromocode(target);
            }

            if (target.classList.contains('visible') || target.classList.contains('not-visible')) {
                changeStatusPromocode(target);
            }

            if (target.classList.contains('copy-code')) {
                copyContent(target.getAttribute('title'));
            }

        });
}

if (codeGenerateContainers.length > 0) {
    codeGenerateContainers.forEach(el => initCodeGenerate(el));
}

if (promocodeVariantsContainers.length > 0) {
    promocodeVariantsContainers.forEach(el => initPromocodeVariants(el));
}

if (btnCreatePromocode) {
    initCreatePromocode();
}

if (changeStatePromocode) {
    initChangeStatus();
}

if (updatePromocodeBtn) {
    initUpdatePromocode();
}

if (createPromocodeBtn) {
    clearFormCreatePromocode();
}

function clearFormCreatePromocode() {
    createPromocodeBtn.addEventListener('click', () => {
        const modal = document.querySelector('.modal[data-modal="create-promocode"]');

        modal.querySelectorAll('input:not([id="status"])').forEach((input) => {
            input.value = '';
        });
    })
}

function initUpdatePromocode() {
    document.querySelector('#updatePromocodeBtn').addEventListener('click', ({ target }) => {
        if (updatePromocodeBtn.classList.contains('disabled')) {
            return;
        }
        updatePromocodeBtn.classList.add('disabled');

        const id = target.dataset.id;
        const modal = document.querySelector('.modal[data-modal="update-promocode"]');
        const name = modal.querySelector('#new-name').value;
        const quantity = modal.querySelector('#new-quantity').value;
        const code = modal.querySelector('#new-code').value;
        const percentages = modal.querySelector('#new-percentages').value;
        const product_variant_id = modal.querySelector('input[name="product_id"]').value;

        fetch(
            `/admin/catalog/promocodes/${id}`,
            {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window._token,
                },
                body: JSON.stringify({ name, quantity, code, percentages, product_variant_id })
            }
        )
            .then(spreadResponse)
            .then((response) => {
                if (checkIsErrorResponse(response)) {
                    window.datatables.ajax.reload();

                    window.toast.push({
                        title: 'Успех!',
                        content: 'Промокод был обновлен!',
                        style: 'success',
                        dismissAfter: '2s'
                    });
                    document.querySelector('.modal[data-modal="update-promocode"] .close-modal').click();
                }
            })
            .finally(() => updatePromocodeBtn.classList.remove('disabled'));
    })
}

function openModalUpdatePromocode(el) {
    const id = el.dataset.id;
    const modal = document.querySelector('.modal[data-modal="update-promocode"]');

    const promocode = window.datatables.ajax.json().data.find((item) => item.id == id);
    console.log(window.datatables.ajax.json().data);
    modal.querySelector('#new-status').value = promocode.status;
    modal.querySelector('.status div').remove();
    modal.querySelector('.status').insertAdjacentHTML("beforeend", promocode.status);
    modal.querySelector('#new-name').value = promocode.raw_name;
    modal.querySelector('#new-quantity').value = promocode.quantity;
    modal.querySelector('#new-code').value = promocode.raw_code;
    modal.querySelector('#new-percentages').value = promocode.percentages;

    document.querySelector('.modal-btn[data-modal="update-promocode"]').click();

    document.querySelector('#updatePromocodeBtn').setAttribute('data-id', id);

    modal.querySelector('input[id="new-product"]').value = '';
    modal.querySelector('input[name="product_id"]').value = '';


    if (promocode.product_variant) {
        searchEngineInputUpdatePromocode.setValueSearchInput(promocode.product_variant.title);
        searchEngineInputUpdatePromocode.setValueInputHidden(promocode.product_variant.id);
    }
}

function changeStatusPromocode(el) {
    const id = el.dataset.id;
    const status = parseInt(el.dataset.status);
    const table = el.closest('.dataTables_wrapper');

    if (table.classList.contains('load')) {
        return;
    }

    table.classList.add('load');

    fetch(
        `/admin/catalog/promocodes/${id}`,
        {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': window._token,
            },
            body: JSON.stringify({ 'status': !status })
        }
    )
        .then(spreadResponse)
        .then((response) => {
            if (checkIsErrorResponse(response)) {
                window.datatables.ajax.reload();

                window.toast.push({
                    title: 'Успех!',
                    content: 'Промокод был обновлен!',
                    style: 'success',
                    dismissAfter: '2s'
                });
            }
        })
        .finally(() => table.classList.remove('load'));

}


function initChangeStatus() {
    const input = changeStatePromocode.querySelector('input');

    changeStatePromocode.addEventListener('click', ({ target }) => {
        if (target.classList.contains('visible')) {
            target.classList.remove('visible');
            target.classList.add('not-visible');
            input.value = 0;
        } else if (target.classList.contains('not-visible')) {
            target.classList.remove('not-visible');
            target.classList.add('visible');
            input.value = 1;
        }
    });
}


function initCreatePromocode() {
    btnCreatePromocode.addEventListener('click', createPromocode);
}

function createPromocode({ target }) {

    if (target.classList.contains('disabled')) {
        return;
    }

    target.classList.add('disabled');

    const modal = document.querySelector('.modal[data-modal="create-promocode"]');
    const name = modal.querySelector('input[id="name"]').value;
    const quantity = modal.querySelector('input[id="quantity"').value;
    const code = modal.querySelector('input[id="code"').value;
    const percentages = modal.querySelector('input[id="percentages"').value;
    const status = modal.querySelector('input[id="status"').value;
    const product_variant_id = modal.querySelector('input[name="product_id"').value;

    const data = { name, quantity, code, percentages, status };

    if (product_variant_id) {
        data.product_variant_id = product_variant_id;
    }

    fetch(
        '/admin/catalog/promocodes',
        {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': window._token,
            },
            body: JSON.stringify(data)
        }
    )
        .then(spreadResponse)
        .then((response) => {
            if (checkIsErrorResponse(response)) {
                window.datatables.ajax.reload();

                window.toast.push({
                    title: 'Успех!',
                    content: 'Промокод успешно создан!',
                    style: 'success',
                    dismissAfter: '2s'
                });
            }
        })
        .finally(() => target.classList.remove('disabled'));
}

function initPromocodeVariants(parent) {
    const input = parent.closest('.input-group')
        .querySelector('input');

    parent.addEventListener('click', ({ target }) => {
        if (target.classList.contains('promocode-variant')) {
            input.value = target.dataset.value;
        }
    });
}

function initCodeGenerate(parent) {
    const input = parent.querySelector('input');
    const btn = parent.querySelector('.generate-code-icon');

    const handlerCodeGenerate = () => {
        input.value = generateRandomCode();
    }

    btn.addEventListener('click', handlerCodeGenerate);
}

function generateRandomCode() {
    let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    const shuffle = str => [...str].sort(() => Math.random() - .5).join('');

    return shuffle(characters);
}


function deletePromocode(el) {
    const id = el.dataset.id;
    const table = el.closest('.dataTables_wrapper');

    if (table.classList.contains('load')) {
        return;
    }

    table.classList.add('load');

    fetch(
        `/admin/catalog/promocodes/${id}`,
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
                    content: 'Промокод был удален!',
                    style: 'success',
                    dismissAfter: '2s'
                });
            }
        })
        .finally(() => table.classList.remove('load'));
}


async function copyContent(text) {
    try {
        await navigator.clipboard.writeText(text);
        window.toast.push({
            title: 'Успех!',
            content: 'Промокод был скопирован!',
            style: 'success',
            dismissAfter: '1s'
        });
    } catch (err) {
        window.toast.push({
            title: 'Ошибка!',
            content: 'Промокод не скопирован!',
            style: 'error',
            dismissAfter: '1s'
        });
    }
}


new SearchEngineInput(
    '/',
    document.querySelector('.modal[data-modal="create-promocode"]'),
    'input[id="product"]',
    'product_id',
    '.input-search-parent'
);
