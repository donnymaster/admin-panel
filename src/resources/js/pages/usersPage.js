import spreadResponse from "../utils/spreadResponse";
import checkIsErrorResponse from "../utils/checkIsErrorResponse";

let tables = null;

window.addEventListener('load', () => {
    tables = window.LaravelDataTables['users-table'];

    tables.on('init', () => {
        document.querySelector('.dataTables_wrapper ')
            .addEventListener('click', handlerClickTable);
    });
});

function handlerClickTable({target}) {
    if (target.classList.contains('delete')) {
        deleteUser(target.dataset.id);
    }

    if (target.classList.contains('edit')) {
        updateUser(target.dataset);
    }
}

function deleteUser(id) {
    const table = document.querySelector('.dataTables_wrapper');

    table.classList.add('load');

    fetch(
        `/admin/users/${id}`,
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
                content: 'Пользователь был удален!',
                style: 'success',
                dismissAfter: '2s'
            });
            tables.ajax.reload();
        }
    })
    .finally(() => {
        table.classList.remove('load');
    });

}

function updateUser(user) {
    document.querySelector('.modal-btn[data-modal="update-user"]').click();

    document.querySelector('.modal input[name="name"]').value = user.name;
    document.querySelector('.modal input[name="email"]').value = user.email;
    document.querySelector('.modal input[name="user_id"]').value = user.id;

    document.querySelector('.modal select[name="role_id"]').value = user.role;
}


document.querySelector('#updateUser')
    .addEventListener('click', () => {
        // get data
        const name = document.querySelector('.modal input[name="name"]').value;
        const email = document.querySelector('.modal input[name="email"]').value;
        const role_id = document.querySelector('.modal select[name="role_id"]').value;
        const password = document.querySelector('.modal input[name="password"]').value;
        const userId = document.querySelector('.modal input[name="user_id"]').value;

        const data = {name, email, role_id};

        if (password) {
            data.password = password;
        }

        fetch(
            `/admin/users/${userId}`,
            {
                method: 'PATCH',
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
                window.toast.push({
                    title: 'Успех!',
                    content: 'Пользователь был обновлен!',
                    style: 'success',
                    dismissAfter: '2s'
                });
                tables.ajax.reload();
                document.querySelector('.modal[data-modal="update-user"] .close-modal').click();
            }
        });

    });
