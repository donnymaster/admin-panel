@extends('admin-panel.layouts.main')

@section('title', 'Заявки')

@section('content')
    <div class="flex mb-9 items-center text-2xl text-white justify-between">
        <div class="title">
            <span class="pr-1">Заявки</span> <span class="text-theme-green">{{ $processed }}</span> / <span
                class="text-red">{{ $notProcessed }}</span>
        </div>
    </div>

    {{ $dataTable->table() }}


    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        const handleModal = (type) => {
            document.querySelector('body').style = type === 'open' ? 'overflow: hidden' : 'overflow: auto';

            document.querySelector('.modal-overlay').classList.toggle('hidden');
            document.querySelector('.modal-container').classList.toggle('hidden');
            document.querySelector('.modal-container').classList.toggle('flex');

            document.querySelector('.modal').classList.toggle('hidden');
        }

        window.addEventListener("load", function() {
            LaravelDataTables.dataTableBuilder.on('init', () => {
                const table = document.querySelector('#dataTableBuilder_wrapper');
                const data = LaravelDataTables.dataTableBuilder.rows().data();

                table.addEventListener('click', (event) => {
                    const row = event.target.closest('tbody tr');

                    if (!row) {
                        return;
                    }

                    const id = row.getAttribute('id');
                    // get data
                    const rowData = data.filter((row) => row.id == id)['0'];

                    const modal = document.querySelector('.modal');

                    modal.querySelector('.modal-header .title').textContent = `Заявка от: ${rowData.full_name_client}`;
                    modal.querySelector('.modal-content .phone-number').textContent = rowData.phone_client;
                    modal.querySelector('.modal-content .phone-number').setAttribute('a', `tel:${rowData.phone_client}`);

                    modal.querySelector('.modal-content .date-add').textContent = rowData.created_at;

                    const message = rowData.additional_information ? rowData.additional_information : 'Отсутсвует';

                    modal.querySelector('.modal-content .message').textContent = message;

                    document.querySelector('input[name="id-application"]').setAttribute('value', id);

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
    </script>
@endsection

@section('sidebar')
    <x-admin.sidebar.statistics item_show="applications" />
@endsection


@push('modals')
    <div class="modal-container hidden">
        <div class="modal-overlay hidden"></div>
        <div class="modal hidden" data-modal="update-user">
            <div class="modal-header mb-5 text-2xl">
                <div class="title">Заявка от: Большакова Вера Романовна</div>
                <div class="close-modal">
                    ✖
                </div>
            </div>
            <div class="modal-content scrollbar">
                <div class="flex flex-col">
                    <div class="flex justify-between">
                        <div class="flex mb-3">
                            <div class="number-title mr-2">
                                Номер телефона:
                            </div>
                            <a class="phone-number" href="tel:+(35222) 18-5718">(35222) 18-5718</a>
                        </div>
                        <div class="date-add">
                            Добавлен: 2023-09-20
                        </div>
                    </div>
                    <div class="message-title text-center mb-4">
                        Сообщение от пользователя
                    </div>
                    <div class="message">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat ipsam praesentium corporis incidunt,
                        illo in nulla distinctio recusandae suscipit cupiditate magni vero aliquam eum, qui quasi optio rem,
                        sapiente dolores.
                    </div>
                </div>
            </div>
            <div class="modal-footer flex justify-end">
                <div class="btn bg-green mr-2" id="changeStatusApplication">
                    <span class="loader dark"></span>
                    Изменить статус
                </div>
                <div class="btn bg-red mr-2" id="deleteApplication">
                    <span class="loader dark"></span>
                    Удалить
                </div>
            </div>
            <input type="hidden" name="status-application">
            <input type="hidden" name="id-application" value="1">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </div>
    </div>

    <script>
        const btnDeleteApplication = document.querySelector('#deleteApplication');
        const csrfToken = document.querySelector('input[name="_token"]').value;

        document.querySelector('#changeStatusApplication').addEventListener('click', () => {

        });

        btnDeleteApplication.addEventListener('click', () => {
            // confirm delete application
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
                .then(() => {
                    // close modal
                    btnDeleteApplication.classList.remove('disabled');
                })
                .catch((error) => console.log(error));
        });
    </script>
@endpush
