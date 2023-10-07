import checkIsErrorResponse from "../utils/checkIsErrorResponse";
import spreadResponse from "../utils/spreadResponse";

const btnDeleteApplication = document.querySelector('#deleteApplication');
const changeStatusApplication = document.querySelector('#changeStatusApplication');
let datatables = null;

const handleModal = (type) => {
    document.querySelector('body').style = type === 'open' ? 'overflow: hidden' : 'overflow: auto';

    document.querySelector('.modal-overlay').classList.toggle('hidden');
    document.querySelector('.modal-container').classList.toggle('hidden');
    document.querySelector('.modal-container').classList.toggle('flex');

    document.querySelector('.modal').classList.toggle('hidden');
}

window.addEventListener("load", function() {
    datatables = LaravelDataTables.dataTableBuilder;

    datatables.on('init', () => {
        const table = document.querySelector('#dataTableBuilder_wrapper');

        table.addEventListener('click', (event) => {
            const data = datatables.rows().data();
            const row = event.target.closest('tbody tr');

            if (!row) {
                return;
            }

            const id = row.getAttribute('id');
            // get data
            const rowData = data.filter((row) => row.id == id)['0'];

            const modal = document.querySelector('.modal');

            modal.querySelector('.modal-header .title').textContent =
                `Заявка от: ${rowData.full_name_client}`;
            modal.querySelector('.modal-content .phone-number').textContent = rowData
                .phone_client;
            modal.querySelector('.modal-content .phone-number').setAttribute('a',
                `tel:${rowData.phone_client}`);

            modal.querySelector('.modal-content .date-add').textContent = rowData
                .created_at;

            const message = rowData.additional_information ? rowData
                .additional_information : 'Отсутсвует';

            modal.querySelector('.modal-content .message').textContent = message;

            document.querySelector('input[name="id-application"]').setAttribute('value',
                id);

            document.querySelector('input[name="status-application"]').setAttribute('value',
                rowData.processed);

            handleModal('open');

        });
    });

    document.querySelector('.modal-header .close-modal').addEventListener('click', () => {
        handleModal('');
    });

    document.querySelector('.modal-overlay').addEventListener('click', () => {
        handleModal('');
    });
});

changeStatusApplication.addEventListener('click', () => {
    if (changeStatusApplication.classList.contains('disabled')) {
        return;
    }

    const idApplication = document.querySelector('input[name="id-application"]').value;
    changeStatusApplication.classList.add('disabled');

    const status = document.querySelector('input[name="status-application"]').value;

    fetch(
            `/admin/statistics/applications/${idApplication}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window._token,
                },
                body: JSON.stringify({
                    processed: status == 'Не обработан' ? true : false
                })
            }
        )
        .then(spreadResponse)
        .then((response) => {
            if (checkIsErrorResponse(response)) {
                updateCountApplication();
                changeStatusApplication.classList.remove('disabled');
                datatables.ajax.reload();
                handleModal('');
                window.toast.push({
                    title: 'Успех!',
                    content: 'Заявка была обновлена!',
                    style: 'success',
                    dismissAfter: '2s'
                });
            }
        });
});

btnDeleteApplication.addEventListener('click', () => {

    if (btnDeleteApplication.classList.contains('disabled')) {
        return;
    }
    const idApplication = document.querySelector('input[name="id-application"]').value;

    btnDeleteApplication.classList.add('disabled');
    // senf request

    fetch(
            `/admin/statistics/applications/${idApplication}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': window._token
                }
            }
        )
        .then(spreadResponse)
        .then((response) => {
            if (checkIsErrorResponse(response)) {
                updateCountApplication();
                btnDeleteApplication.classList.remove('disabled');
                datatables.ajax.reload();
                handleModal('');
                window.toast.push({
                    title: 'Успех!',
                    content: 'Заявка была удалена!',
                    style: 'success',
                });
            }
        });
});

const updateCountApplication = () => {
    const applicationProcessedCount = document.querySelector('#applicationProcessedCount');
    const applicationNotProcessedCount = document.querySelector('#applicationNotProcessedCount');
    const applicationNotProcessedCountSideBar = document.querySelector('#applicationNotProcessedCountSideBar');

    fetch(
            '/admin/statistics/applications/info'
        )
        .then(spreadResponse)
        .then((response) => {
            if (checkIsErrorResponse(response)) {
                applicationProcessedCount.textContent = response.data.processed;
                applicationNotProcessedCount.textContent = response.data.notProcessed;
                applicationNotProcessedCountSideBar.textContent = response.data.notProcessed;
            }
        });
}
