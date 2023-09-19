@extends('admin-panel.layouts.main')

@section('title', 'Заявки')

@section('content')
    <div class="flex mb-9 items-center text-2xl text-white justify-between">
        <div class="title">
            <span class="pr-1">Заявки</span> <span class="text-theme-green">{{$processed}}</span> / <span class="text-red">{{$notProcessed}}</span>
        </div>
    </div>

    {{ $dataTable->table() }}


    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        window.addEventListener("load", function() {
            LaravelDataTables.dataTableBuilder.on('init', () => {
                const table = document.querySelector('#dataTableBuilder_wrapper');
                const data = LaravelDataTables.dataTableBuilder.rows().data();

                console.log(data);
                table.addEventListener('click', (event) => {
                    const row = event.target.closest('tbody tr');

                    if (!row) {
                        return;
                    }

                    const id = row.getAttribute('id');
                    // get data
                    const rowData = data.filter((row) => row.id == id)['0'];
                    console.log(rowData);
                    // open modal

                });
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
        <div class="modal-header">
            <div class="title">Title modal update</div>
            <div class="close-modal">
                ✖
            </div>
        </div>
        <div class="modal-content scrollbar">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. At eius maxime perferendis facilis tempora consectetur tenetur quisquam corporis, saepe consequuntur, repudiandae incidunt nobis voluptates, pariatur reprehenderit sunt. Natus, tempora recusandae.
        </div>
        <div class="modal-footer">
            footer
        </div>
    </div>
</div>
@endpush
