import spreadResponse from "../utils/spreadResponse";
import checkIsErrorResponse from "../utils/checkIsErrorResponse";
import ConvertWordsToTranscription from "../components/ConvertWordsToTranscription";

new ConvertWordsToTranscription();

const btnCreate = document.querySelector('#createVariableSetting');

btnCreate.addEventListener('click', () => {
    const inputNameValue = document.querySelector('input[id="name"]').value;
    const inputSlugValue = document.querySelector('input[id="slug"]').value;
    const inputValue = document.querySelector('input[id="value"]').value;

    const changeStateBtn = (btn) => {
        btn.classList.toggle('disabled');
    }

    changeStateBtn(btnCreate);

    fetch(
        `/admin/settings`,
        {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': window._token,
            },
            body: JSON.stringify({
                setting_name: inputNameValue,
                setting_key: inputSlugValue,
                setting_value: inputValue,
            })
        }
    )
        .then(spreadResponse)
        .then((response) => {
            if (checkIsErrorResponse(response)) {
                window.datatables.ajax.reload();
                document.querySelector('.modal[data-modal="create-setting"] .close-modal').click();
                window.toast.push({
                    title: 'Успех!',
                    content: 'Переменная была добавлена!',
                    style: 'success',
                    dismissAfter: '2s'
                });
            }
        })
        .finally(() => changeStateBtn(btnCreate));
});

window.addEventListener('load', () => {
    window.datatables = LaravelDataTables.dataTableBuilder;

    window.datatables.on('init', () => addEventClickRowTable());
    window.datatables.on('error', (error) => {
        window.location.reload();
    });
});

const changeVisibilityModal = (modalData, state = '') => {
    document.querySelector('body').style = state === 'show' ? 'overflow: hidden' : 'overflow: auto';

    document.querySelector(`.modal-overlay`).classList.toggle('hidden');
    document.querySelector(`.modal-container`).classList.toggle('hidden');
    document.querySelector(`.modal-container`).classList.toggle('flex');

    document.querySelector(`.modal[data-modal="${modalData}`).classList.toggle('hidden');
}

const updateModal = (setting) => {
    document.querySelector('input[id="var-name-update"]').value = setting.setting_name;
    document.querySelector('input[id="var-slug-update"]').value = setting.setting_key;
    document.querySelector('input[id="var-value-update"]').value = setting.full_slug;
}

function addEventClickRowTable() {
    document.querySelector('#dataTableBuilder_wrapper').addEventListener('click', (event) => {
        const settingId = event.target.getAttribute('data-id');
        if (event.target.hasAttribute('data-update')) {
            const setting = window.datatables.ajax.json().data.find((row) => row.id == settingId);

            updateModal(setting);
            changeVisibilityModal('update-setting', 'show');
            document.querySelector('#updateVariableSetting').setAttribute('data-id', settingId);
        }

        if (event.target.hasAttribute('data-delete')) {
            deleteVariableSetting(settingId);
        }
    });
}

function deleteVariableSetting(id) {
    const state = confirm('Вы действительно хотите удалить переменную?');

    if (!state) {
        return;
    }

    fetch(
        `/admin/settings/${id}`,
        {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': window._token,
            }
        }
    )
    .then(spreadResponse)
    .then((response) => {
        if(checkIsErrorResponse(response)) {
            window.datatables.ajax.reload();
            window.toast.push({
                title: 'Успех!',
                content: 'Переменная была удалена!',
                style: 'success',
                dismissAfter: '2s'
            });
        }
    });
}

document.querySelector('#updateVariableSetting')
    .addEventListener('click', ({target}) => {
        if (target.classList.contains('disabled')) {
            return;
        }
        const setting_name = document.querySelector('input[id="var-name-update"]').value;
        const setting_key = document.querySelector('input[id="var-slug-update"]').value;
        const setting_value = document.querySelector('input[id="var-value-update"]').value;

        const settngId = target.dataset.id;

        target.classList.add('disabled');

        fetch(
            `/admin/settings/${settngId}`,
            {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window._token,
                },
                body: JSON.stringify({
                    setting_name,
                    setting_key,
                    setting_value,
                })
            }
        )
        .then(spreadResponse)
        .then((response) => {
            if(checkIsErrorResponse(response)) {
                window.datatables.ajax.reload();
                window.toast.push({
                    title: 'Успех!',
                    content: 'Переменная была обновлена!',
                    style: 'success',
                    dismissAfter: '2s'
                });
                document.querySelector('.modal[data-modal="update-setting"] .close-modal').click();
            }
        })
        .finally(() => target.classList.remove('disabled'));
    });

