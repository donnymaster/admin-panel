const btnCreate = document.querySelector('#createVariableSetting');

btnCreate.addEventListener('click', () => {
    const inputNameValue = document.querySelector('input[id="name"]').value;
    const inputSlugValue = document.querySelector('input[id="slug"]').value;
    const inputValue = document.querySelector('input[id="value"]').value;
    const csrfToken = document.querySelector('input[name="_token"]').value;

    // validate data

    console.log({
        inputNameValue,
        inputSlugValue,
        inputValue,
    });

    const changeStateBtn = (btn) => {
        btn.classList.toggle('disabled');
    }

    if (!inputNameValue || !inputSlugValue || !inputValue) {
        alert('Все поля должны быть заполнены!');
        return;
    }

    changeStateBtn(btnCreate);

    fetch(
        `/admin/settings`,
        {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                setting_name: inputNameValue,
                setting_key: inputSlugValue,
                setting_value: inputValue,
            })
        }
    )
        .then((response) => response.json())
        .then((response) => {
            if (response.status == 419 || response.status == 401) {
                window.location.reload();
                return;
            }

            if ('errors' in response) {
                alert(response.message);
            }

            window.datatables.ajax.reload();
            changeStateBtn(btnCreate);
        });
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
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            }
        }
    ).then((response) => {
        if (response.status == 419 || response.status == 401) {
            window.location.reload();
            return;
        }

        window.datatables.ajax.reload();
    });
}

class ConvertWordsToTranscription {
    constructor() {
        this.ATTRIBUTE_NAME = 'data-child';
        this.inputParents = document.querySelectorAll('.convert-parent');

        if (!this.inputParents.length) {
            return;
        }

        this.run();
    }

    run() {
        this.inputParents.forEach((parentInput) => {
            const child = document.querySelector(`.${parentInput.getAttribute(this.ATTRIBUTE_NAME)}`);

            parentInput.addEventListener('input', (event) => {
                child.value = this.translit(event.target.value);
            });
        });
    }

    translit(words) {
        var answer = '';
        var converter = {
            'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd',
            'е': 'e', 'ё': 'e', 'ж': 'zh', 'з': 'z', 'и': 'i',
            'й': 'y', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
            'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't',
            'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'ch',
            'ш': 'sh', 'щ': 'sch', 'ь': '', 'ы': 'y', 'ъ': '',
            'э': 'e', 'ю': 'yu', 'я': 'ya',

            'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D',
            'Е': 'E', 'Ё': 'E', 'Ж': 'Zh', 'З': 'Z', 'И': 'I',
            'Й': 'Y', 'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N',
            'О': 'O', 'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T',
            'У': 'U', 'Ф': 'F', 'Х': 'H', 'Ц': 'C', 'Ч': 'Ch',
            'Ш': 'Sh', 'Щ': 'Sch', 'Ь': '', 'Ы': 'Y', 'Ъ': '',
            'Э': 'E', 'Ю': 'Yu', 'Я': 'Ya'
        };

        for (var i = 0; i < words.length; ++i) {
            if (converter[words[i]] == undefined) {
                answer += words[i];
            } else {
                answer += converter[words[i]];
            }
        }

        return answer;
    }
}

new ConvertWordsToTranscription();
