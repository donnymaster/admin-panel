import checkIsErrorResponse from "../utils/checkIsErrorResponse";
import spreadResponse from "../utils/spreadResponse";


const btnToProcessing = document.querySelector('#updateOrdersToInprocessing');
const btnToProcessed = document.querySelector('#updateOrdersToProcessed');
const checkboxAll = document.querySelector('label[for="select-all-orders"]');

checkboxAll.addEventListener('click', () => {
        const inputs = document.querySelectorAll('input[id*="select-order-"]');
        inputs.forEach((input) => input.checked = !input.checked);
    });


window.addEventListener('load', () => {
    window.datatables = window.LaravelDataTables['orders-table'];

    window.datatables.on('error', (error) => {
        window.location.reload();
    });
    window.datatables.on('xhr.dt', () => {
        updateCountOdersByStatuses();
    });
});

btnToProcessing.addEventListener('click', () => {
        const inputs = [...document.querySelectorAll('input[id*="select-order-"]')];
        const type = 'in_processing';

        const orders_id = inputs.map((input) => {
            if (input.checked) {
                return input.dataset.id;
            }
            return false;
        }).filter(Boolean);

        if (!orders_id.length) {
            window.toast.push({
                title: 'Ошибка!',
                content: 'Выберете заказы!',
                style: 'error',
                dismissAfter: '1s'
            });
            return;
        }

        if (btnToProcessed.classList.contains('disabled')) {
            return;
        }

        btnToProcessed.classList.add('disabled');
        btnToProcessing.classList.add('disabled');
        document.querySelector('#orders-table_wrapper').classList.add('load');

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
                window.toast.push({
                    title: 'Успех!',
                    content: 'Заказы были обновлены!',
                    style: 'success',
                    dismissAfter: '1s'
                });
                window.datatables.ajax.reload();
                checkboxAll.closest('.checkbox').querySelector('input').checked = false;
            }
        }).finally(() => {
            btnToProcessed.classList.remove('disabled');
            btnToProcessing.classList.remove('disabled');
            document.querySelector('#orders-table_wrapper').classList.remove('load');
        });

    });



btnToProcessed.addEventListener('click', () => {
        const inputs = [...document.querySelectorAll('input[id*="select-order-"]')];
        const type = 'processed';

        const orders_id = inputs.map((input) => {
            if (input.checked) {
                return input.dataset.id;
            }
            return false;
        }).filter(Boolean);

        if (!orders_id.length) {
            window.toast.push({
                title: 'Ошибка!',
                content: 'Выберете заказы!',
                style: 'error',
                dismissAfter: '1s'
            });
            return;
        }

        if (btnToProcessed.classList.contains('disabled')) {
            return;
        }

        btnToProcessed.classList.add('disabled');
        btnToProcessing.classList.add('disabled');
        document.querySelector('#orders-table_wrapper').classList.add('load');

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
                window.toast.push({
                    title: 'Успех!',
                    content: 'Заказы были обновлены!',
                    style: 'success',
                    dismissAfter: '1s'
                });

                window.datatables.ajax.reload();
                checkboxAll.closest('.checkbox').querySelector('input').checked = false;
            }
        }).finally(() => {
            btnToProcessed.classList.remove('disabled');
            btnToProcessing.classList.remove('disabled');
            document.querySelector('#orders-table_wrapper').classList.remove('load');
        });
    });


function updateCountOdersByStatuses() {
    const data = window.datatables.ajax.json().countStatuses;
    console.log(data);
    document.querySelector('#countNew').textContent = `Новый (${data.new})`;
    document.querySelector('#countInProcessing').textContent = `В обработке (${data.in_processing})`;
    document.querySelector('#countProcessed').textContent = `Обработанные (${data.processed})`;

}
