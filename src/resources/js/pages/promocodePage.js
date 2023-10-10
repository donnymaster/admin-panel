import checkIsErrorResponse from "../utils/checkIsErrorResponse";
import spreadResponse from "../utils/spreadResponse";

const codeGenerateContainers = document.querySelectorAll('.container-generate-code');
const promocodeVariantsContainers = document.querySelectorAll('.promocode-variants');
const btnCreatePromocode = document.querySelector('#createPromocodeBtn');
const changeStatePromocode = document.querySelector('.modal-header .status');
const updatePromocodeBtn = document.querySelector('.modal-btn[data-modal="update-promocode"]');

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

        fetch(
            `/admin/catalog/promocodes/${id}`,
            {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window._token,
                },
                body: JSON.stringify({ name, quantity, code, percentages })
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
    modal.querySelector('#new-status').value = promocode.status;
    modal.querySelector('.status div').remove();
    modal.querySelector('.status').insertAdjacentHTML("beforeend", promocode.status);
    modal.querySelector('#new-name').value = promocode.raw_name;
    modal.querySelector('#new-quantity').value = promocode.quantity;
    modal.querySelector('#new-code').value = promocode.raw_code;
    modal.querySelector('#new-percentages').value = promocode.percentages;

    document.querySelector('.modal-btn[data-modal="update-promocode"]').click();

    document.querySelector('#updatePromocodeBtn').setAttribute('data-id', id);
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
    const productId = modal.querySelector('input[id="code"').value;
    console.log({ name, quantity, code, percentages, status });

    fetch(
        '/admin/catalog/promocodes',
        {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': window._token,
            },
            body: JSON.stringify({ name, quantity, code, percentages, status })
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


class SearchEngineInput {
    constructor(
        url,
        inputSearchSelector,
        inputNewName,
        parentlementSelector,
    ) {
        this.url = url;
        this.inputSearch = document.querySelector(inputSearchSelector);
        this.inputNewName = inputNewName;
        this.parent = document.querySelector(parentlementSelector);
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
    }

    search({target}) {

        fetch(
            ``,
        )
        .then(spreadResponse)
        .then((response) => {
            if (checkIsErrorResponse(response)) {

            }
        })
    }

    debounce(func, timeout = 300) {
        let timer;
        return (...args) => {
          clearTimeout(timer);
          timer = setTimeout(() => { func.apply(this, args); }, timeout);
        };
      }

}

new SearchEngineInput('/', '.modal[data-modal="create-promocode"] input[id="product"]', 'parent_id', '.input-search-parent');
