import checkIsErrorResponse from "../utils/checkIsErrorResponse";
import spreadResponse from "../utils/spreadResponse";
import SearchEngineInputProductVariant from "../components/SearchEngineInputProductVariant";
import printJS from 'print-js';

document.querySelector('.change-status-order')
    .addEventListener('click', ({ target }) => {
        if (!target.classList.contains('order-status')) return;

        const type = target.dataset.type;
        const orders_id = [target.closest('.change-status-order').dataset.id];

        fetch(
            '/admin/statistics/orders/change-status',
            {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window._token,
                },
                body: JSON.stringify({ orders_id, type })
            }
        )
            .then(spreadResponse)
            .then((response) => {
                if (checkIsErrorResponse(response)) {
                    window.location.reload();
                }
            });
    });

const searchVariant = new SearchEngineInputProductVariant(
    '/',
    document.querySelector('.parent-search'),
    'input[id="addVariant"]',
    'variant_id',
    '.input-search-parent',
);

document.querySelector('.print-order')
    .addEventListener('click', () => {
        printJS({
            printable: getData(),
            type: 'json',
            properties: ['name', 'email', 'phone'],
            header: getHeaderPrint(),
            properties: [
                { field: 'name', displayName: 'Товар' },
                { field: 'count', displayName: 'Количество' },
                { field: 'price', displayName: 'Цена' },
                { field: 'sum', displayName: 'Сумма' },
            ],
            style: '.mb-5 {margin-bottom: 1.25rem} .text-center {text-align:center}'
        });

        function getData() {
            const table = document.querySelector('.table-container');
            const data = [];

            table.querySelectorAll('tbody tr')
                .forEach((row) => {
                    data.push({
                        name: row.querySelector('.variant-name').textContent,
                        count: row.querySelector('input.input-order').value,
                        price: row.querySelector('.variant-price').textContent,
                        sum: row.querySelector('.variant-total-price').textContent,
                    });
                });

            return data;
        }
    });

function getHeaderPrint() {
    const client = document.querySelector('input[id="client_name"]').value;
    const phone_number = document.querySelector('input[id="phone_number"]').value;
    const delivery_address = document.querySelector('input[id="delivery_address"]').value;
    const type_delivery = document.querySelector('input[id="type_delivery"]').value;
    const user_annotation = document.querySelector('textarea[id="user_annotation"]').textContent;
    const admin_annotation = document.querySelector('textarea[id="admin_annotation"]').textContent;
    const total_order_price = document.querySelector('.total-order-price').textContent;
    const promocode = document.querySelector('.total-order-price-promocode');
    let promocodeVal = '-';
    let percentage = '-';

    if (promocode) {
        percentage = document.querySelector('.promocode-percentage').textContent;
        promocodeVal = promocode.textContent;
    }

    return `
        <div class="mb-5">
            <div>Клиент: ${client}</div>
            <div>Номер телефона: ${phone_number}</div>
            <div>Адрес доставки: ${delivery_address}</div>
            <div>Вариант доставки: ${type_delivery}</div>
            <div class="mb-5">
                <div>Общая стоимость: ${total_order_price} руб.</div>
                <div>Промокод(${percentage}%): ${promocodeVal} руб.</div>
            </div>
            <div class="mb-5">
                <div>Пометки пользователя</div>
                ${user_annotation}
            </div>
            <div>
                <div>Пометки администратора</div>
                ${admin_annotation}
            </div>
        </div>
    `;
}

class HandlerOrder {
    constructor() {
        this.tableContainer = document.querySelector('.table-container');
        this.handlers = [];
        this.totalPriceElement = document.querySelector('.total-order-price');
        this.totalPriceWithPromocodeElement = document.querySelector('.total-order-price-promocode');
        this.promocodePercentage = document.querySelector('.promocode-percentage');
        this.btnDeletePromocode = document.querySelector('#deletePromocode');

        this.init();
    }

    init() {
        this.tableContainer.addEventListener('click', ({ target }) => {
            if (target.classList.contains('remove-icon')) {
                this.removeVariant(target);
            }
        });

        this.addInputHandlers();

        if (this.btnDeletePromocode) {
            this.btnDeletePromocode.addEventListener('click', this.deletePromocode.bind(this));
        }

        searchVariant.addEventSelectVariant(this.addNewVariant.bind(this), 'load');
    }

    changeCountVariant({ target }) {

        const max = parseInt(target.getAttribute('max'));
        const min = parseInt(target.getAttribute('min'));
        let value = parseInt(target.value);
        const dValue = parseInt(target.defaultValue);

        if (isNaN(value) || target.value > max) {
            target.value = dValue;
            value = dValue;
        }

        const countTotalVariant = value - dValue;

        const row = target.closest('tr');
        const variantId = row.dataset.id;
        const orderId = document.querySelector('#mainForm').dataset.id;

        if (this.tableContainer.classList.contains('load')) return;

        this.tableContainer.classList.add('load');

        fetch(
            `/admin/statistics/orders/${orderId}/update-count`,
            {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window._token,
                },
                body: JSON.stringify({ variant_id: variantId, count: value })
            }
        )
            .then(spreadResponse)
            .then((response) => {
                if (!checkIsErrorResponse(response)) return;

                const variantPrice = parseInt(row.querySelector('.variant-price span').textContent);
                row.querySelector('.variant-total-price span').textContent = value * variantPrice;

                const totalVariant = parseInt(row.querySelector('.total-variant').dataset.count);
                row.querySelector('.total-variant span').textContent = totalVariant - countTotalVariant;

                this.updateTotalPrice();

                window.toast.push({
                    title: 'Успех!',
                    content: 'Заказ был обновлен!',
                    style: 'success',
                    dismissAfter: '2s'
                });

            }).finally(() => this.tableContainer.classList.remove('load'));
    }

    clearHandlers() {
        this.handlers.forEach(h => h.el.removeEventListener(h.type, h.handler));
    }

    addInputHandlers() {
        const inputsCountVariants = this.tableContainer.querySelectorAll('input.input-order');

        const handler = this.debounce(this.changeCountVariant, 500);

        inputsCountVariants.forEach((input) => {
            this.handlers.push({
                el: input,
                handler: handler,
                type: 'change',
                id: input.dataset.id
            });

            input.addEventListener('change', handler);
        });
    }

    updateTotalPrice() {
        const total = [...this.tableContainer.querySelectorAll('.variant-total-price span')]
            .reduce((prev, curr) => {
                if (prev == 0) {
                    return 0 + parseInt(curr.textContent);
                }
                return prev + parseInt(curr.textContent);
            }, 0);

        this.totalPriceElement.textContent = total;

        if (!this.totalPriceWithPromocodeElement) return;

        const percentage = parseInt(this.promocodePercentage.textContent);

        const totalWithPercentage = total - (total * (percentage / 100));

        this.totalPriceWithPromocodeElement.textContent = totalWithPercentage;
    }

    deletePromocode() {
        this.promocodePercentage.textContent = '-';
    }

    removeVariant(el) {
        // send request
        if (this.tableContainer.classList.contains('load')) return;

        this.tableContainer.classList.add('load');

        const orderId = document.querySelector('#mainForm').dataset.id;
        const variantId = el.dataset.id;
        const id = el.dataset.id;

        fetch(
            `/admin/statistics/orders/${orderId}/remove-variant/${variantId}`,
            {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': window._token,
                },
            }
        )
            .then(spreadResponse)
            .then((response) => {
                if (!checkIsErrorResponse(response)) return;

                const h = this.handlers.find(h => h.id == id);
                h.el.removeEventListener(h.type, h.handler);
                el.closest('tr').remove();
                this.updateTotalPrice();

                window.toast.push({
                    title: 'Успех!',
                    content: 'Продукт был удален!',
                    style: 'success',
                    dismissAfter: '2s'
                });

            }).finally(() => this.tableContainer.classList.remove('load'));
    }

    addNewVariant(variant) {
        if (this.tableContainer.classList.contains('load')) return;

        this.tableContainer.classList.add('load');

        const orderId = document.querySelector('#mainForm').dataset.id;
        const row = this.tableContainer.querySelector(`tbody tr[data-id="${variant.id}"]`);

        if (row) {
            const input = row.querySelector('input.input-order');
            input.value = parseInt(input.value) + 1;
            input.dispatchEvent(new Event('change'));
        }

        // send request update and get data
        fetch(
            `/admin/statistics/orders/${orderId}/add-variant`,
            {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window._token,
                },
                body: JSON.stringify({ variant_id: variant.id })
            }
        )
            .then(spreadResponse)
            .then((response) => {
                if (!checkIsErrorResponse(response)) return;

                if (response.data.type == 'create') {
                    this.createNewVariant(response.data.variant);

                    window.toast.push({
                        title: 'Успех!',
                        content: 'Продукт был добавлен!',
                        style: 'success',
                        dismissAfter: '2s'
                    });
                }

                document.querySelectorAll('.input-search-parent input').forEach(input => input.value = '');

            }).finally(() => this.tableContainer.classList.remove('load'));
    }

    createNewVariant(variant) {
        const stringElement = `
        <tr data-id="${variant.id}">
            <td>
                <img src="/storage/${variant.images[0].path}" alt="${variant.title}">
            </td>
            <td>
                <div class="inline-flex flex-col items-center">
                    <div class="text-start variant-name">${variant.title}</div>
                    <div data-count="${variant.count}" class="text-sm self-start font-light total-variant">
                        <span>${variant.count}</span> шт.
                    </div>
                </div>
            </td>
            <td>
                <input data-id="${variant.id}" type="number" min="1" max="${variant.count}" class="input input-order" value="1">
            </td>
            <td class="variant-price">
                <span>${variant.price}</span> руб.
            </td>
            <td class="variant-total-price">
                <span>${variant.price}</span> руб.
            </td>
            <td class="print-hidden">
                <div data-id="${variant.id}" class="remove-icon"></div>
            </td>
        </tr>
        `;

        this.tableContainer.querySelector('tbody').insertAdjacentHTML('beforeend', stringElement);
        this.clearHandlers();
        this.addInputHandlers();
        this.updateTotalPrice();
    }

    debounce(func, timeout = 300) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => { func.apply(this, args); }, timeout);
        };
    }
}

window.h = new HandlerOrder();

window.onbeforeunload = function () {
    fetch(
        '/routes'
    );
};
