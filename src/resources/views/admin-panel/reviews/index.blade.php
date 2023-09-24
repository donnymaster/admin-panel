@extends('admin-panel.layouts.main')

@section('title', 'Отзывы')

@section('content')
    <div class="flex mb-9 items-center text-2xl text-white justify-between">
        <div class="title">
            <span class="pr-1">Отзывы</span>
        </div>
    </div>

    {{ $dataTable->table() }}


    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endsection

@section('sidebar')
    <x-admin.sidebar.statistics item_show="reviews" />
@endsection


@push('modals')
    <div class="modal-container hidden">
        <div class="modal-overlay hidden"></div>
        <div class="modal hidden" data-modal="update-user">
            <div class="modal-header mb-5 text-2xl">
                <div class="title">Отзыв от: Любовь Андреевна Александрова</div>
                <div class="close-modal">
                    ✖
                </div>
            </div>
            <div class="modal-content scrollbar">
                <div class="input-group mb-3">
                    <label for="position" class="label black pb-1">
                        Укажите позицию
                    </label>
                    <input id="position" type="text" class="input border border-theme-blue border-solid"
                        placeholder="">
                </div>
                <div class="flex flex-col mb-4">
                    <label for="pet-select pb-2">Статус</label>
                    <select class="select" name="status" id="status">
                        <option value="1">Отображен</option>
                        <option value="0">Скрыт</option>
                    </select>
                </div>
                <div class="flex flex-col">
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
                <div class="btn bg-green mr-2" id="updateReview">
                    <span class="loader dark"></span>
                    Обновить
                </div>
                <div class="btn bg-red mr-2" id="deleteReview">
                    <span class="loader dark"></span>
                    Удалить
                </div>
            </div>
            <input type="hidden" name="id-review">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </div>
    </div>
    @vite(['resources/js/pages/reviewPage.js'])
@endpush
