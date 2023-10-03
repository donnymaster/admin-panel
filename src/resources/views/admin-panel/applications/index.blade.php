@extends('admin-panel.layouts.main')

@section('title', 'Заявки')

@section('content')
    <div class="flex mb-9 items-center text-2xl text-white justify-between">
        <div class="title">
            <span class="pr-1">Заявки</span>
            <span class="text-theme-green" id="applicationProcessedCount">{{ $processed }}</span>
            /
            <span class="text-red" id="applicationNotProcessedCount">{{ $notProcessed }}</span>
        </div>
    </div>

    {{ $dataTable->table() }}


    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endsection

@section('sidebar')
    <x-admin.sidebar.statistics item_show="applications" />
@endsection


@push('modals')
    <div class="modal-container hidden">
        <div class="modal-overlay hidden"></div>
        <div class="modal hidden" data-modal="update-user">
            <div class="modal-header mb-5 text-2xl">
                <div class="title"></div>
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
                            <a class="phone-number" href="tel:"></a>
                        </div>
                        <div class="date-add">
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
@endpush


@section('scripts')
    @vite(['resources/js/pages/applicationPage.js'])
@endsection
