
window.addEventListener('load', () => {
    window.datatables = LaravelDataTables.dataTableBuilder;

    window.datatables.on('init', () => addEventClickRowTable());
    window.datatables.on('error', (error) => {
        window.location.reload();
    });

});


function addEventClickRowTable() {
    const updateReviewBtn = document.querySelector('#updateReview');
    const deleteReviewBtn = document.querySelector('#deleteReview');

    const updateModal = (review) => {
        const position = document.querySelector('input[id="position"]');
        const status = document.querySelector('select[id="status"]');

        document.querySelector('.modal-header .title').textContent = `Отзыв от: ${review.client_name}`;
        document.querySelector('.modal-content .message').textContent = review.comment;
        document.querySelector('input[name="id-review"]').value = review.id;

        status.value = review.is_show == 'Скрыт' ? '0' : '1';
        position.setAttribute('placeholder', review.position);
        position.value = review.position;
    }

    const changeVisibilityModal = (state = '') => {
        document.querySelector('body').style = state === 'show' ? 'overflow: hidden' : 'overflow: auto';

        document.querySelector('.modal-overlay').classList.toggle('hidden');
        document.querySelector('.modal-container').classList.toggle('hidden');
        document.querySelector('.modal-container').classList.toggle('flex');

        document.querySelector('.modal').classList.toggle('hidden');
    }

    const handler = (event) => {
        const data = window.datatables.rows().data();

        const row = event.target.closest('tbody tr');

        if (!row) {
            return;
        }

        const id = row.getAttribute('id');
        const rowData = data.filter((row) => row.id == id)['0'];

        updateModal(rowData);
        changeVisibilityModal('show');
    }

    const changeStateBtn = (btn) => {
        btn.classList.toggle('disabled');
    }

    const getValidatedData = () => {
        const position = parseInt(document.querySelector('input[id="position"]').value);
        const status =  parseInt(document.querySelector('select[id="status"]').value);

        const maxPosition = window.datatables.ajax.json().recordsTotal;

        if (position < 1 || position > maxPosition) {
            alert(`Позиция должна быть не меньше 1 и не больше ${maxPosition}`);
            return false;
        }

        return {
            position,
            is_show: status,
        };
    }

    const updateReview = () => {
        if (updateReviewBtn.classList.contains('disabled')) {
            return;
        }

        const id = document.querySelector('input[name="id-review"]').value;
        const csrfToken = document.querySelector('input[name="_token"]').value;

        const data = getValidatedData();

        if (!data) {
            return;
        }

        changeStateBtn(updateReviewBtn);

        fetch(
            `/admin/statistics/reviews/${id}`,
            {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(data)
            }
        )
        .then((response) => {
            if (response.status == 419 || response.status == 401) {
                window.location.reload();
                return;
            }

            changeStateBtn(updateReviewBtn);
            changeVisibilityModal();
            window.datatables.ajax.reload();
        });
    }

    const delteReview = () => {
        if (deleteReviewBtn.classList.contains('disabled')) {
            return;
        }

        const id = document.querySelector('input[name="id-review"]').value;
        const csrfToken = document.querySelector('input[name="_token"]').value;

        changeStateBtn(deleteReviewBtn);

        fetch(
            `/admin/statistics/reviews/${id}`,
            {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
            }
        )
        .then((response) => {
            if (response.status == 419 || response.status == 401) {
                window.location.reload();
                return;
            }

            changeStateBtn(deleteReviewBtn);
            changeVisibilityModal();
            window.datatables.ajax.reload();
        });
    }

    const table = document.querySelector('#dataTableBuilder_wrapper');
    table.addEventListener('click', handler);

    document.querySelector('.modal-container .modal-overlay').addEventListener('click', changeVisibilityModal);
    document.querySelector('.modal-container .close-modal').addEventListener('click',changeVisibilityModal);

    document.querySelector('#updateReview').addEventListener('click', updateReview);
    document.querySelector('#deleteReview').addEventListener('click', delteReview);
}
