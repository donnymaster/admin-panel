@extends('admin-panel.layouts.main')

@section('title', 'Обмен данными')

@section('content')
    <div class="columns-1 flex mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
        <div class="flex items-center">
            <span class="mr-2">Обмен данными</span>
            <svg class="cursor-pointer refresh-table" xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none">
                <path
                    d="M10.33 7.51001C10.83 7.36001 11.38 7.26001 12 7.26001C14.76 7.26001 17 9.50001 17 12.26C17 15.02 14.76 17.26 12 17.26C9.24 17.26 7 15.02 7 12.26C7 11.23 7.31 10.28 7.84 9.48001"
                    stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M9.62012 7.64999L11.2801 5.73999" stroke="white" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M9.62012 7.6499L11.5601 9.0699" stroke="white" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </div>
        <div class="flex ml-auto border-none">
            <div class="check-status-files border-none btn bg-green small-btn mr-3">
                Проверить файлы
            </div>
            <div class="run-import border-none btn bg-green small-btn mr-3">
                Запустить
            </div>
            <div class="delete-files-import border-none btn bg-red small-btn">
                Удалить файлы
            </div>
        </div>
        <div class="modal-btn hidden status-btn" data-modal="status-files"></div>
    </div>

    {{ $dataTable->table() }}


    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endsection

@section('sidebar')
    <div class="sidebar"></div>
@endsection

@section('scripts')
    @vite(['resources/js/pages/dataExchangePage.js'])
@endsection


@push('modals')
    <div class="modal-container hidden">
        <div class="modal-overlay hidden"></div>
        <div class="modal hidden" data-modal="status-files">
            <div class="modal-header mb-5 text-2xl">
                <div class="title text-1xl">Статус файлов</div>
                <div class="close-modal">
                    ✖
                </div>
            </div>
            <div class="modal-content scrollbar">
                <div class="description-files"></div>
            </div>
        </div>
    </div>
@endpush
