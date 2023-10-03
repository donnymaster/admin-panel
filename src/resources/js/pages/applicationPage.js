
const btnDeleteApplication = document.querySelector('#deleteApplication');
const changeStatusApplication = document.querySelector('#changeStatusApplication');
const csrfToken = document.querySelector('input[name="_token"]').value;
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
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    processed: status == 'Не обработан' ? true : false
                })
            }
        )
        .then((response) => {
            if (response.status == 419 || response.status == 401) {
                window.location.reload();
                return;
            }
            // close modal
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
        })
        .catch((error) => console.log(error));
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
                    'X-CSRF-TOKEN': csrfToken
                }
            }
        )
        .then((response) => {
            if (response.status == 419 || response.status == 401) {
                window.location.reload();
                return;
            }
            // close modal
            updateCountApplication();
            btnDeleteApplication.classList.remove('disabled');
            datatables.ajax.reload();
            handleModal('');
            window.toast.push({
                title: 'Успех!',
                content: 'Заявка была удалена!',
                style: 'success',
                dismissAfter: '2s'
            });
        })
        .catch((error) => console.log(error));
});

const updateCountApplication = () => {
    const applicationProcessedCount = document.querySelector('#applicationProcessedCount');
    const applicationNotProcessedCount = document.querySelector('#applicationNotProcessedCount');
    const applicationNotProcessedCountSideBar = document.querySelector('#applicationNotProcessedCountSideBar');

    fetch(
            '/admin/statistics/applications/info'
        )
        .then((response) => {
            if (response.status == 419 || response.status == 401) {
                window.location.reload();
                return;
            }
            return response.json();
        })
        .then((response) => {
            applicationProcessedCount.textContent = response.processed;
            applicationNotProcessedCount.textContent = response.notProcessed;
            applicationNotProcessedCountSideBar.textContent = response.notProcessed;
        });
}
