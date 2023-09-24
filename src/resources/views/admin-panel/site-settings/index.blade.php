@extends('admin-panel.layouts.main')

@section('title', 'Настройки сайта')

@section('content')
    <div class="flex mb-9 items-center text-2xl text-white justify-between">
        <span class="pr-5">Конфигурация сайта</span>
        <div class="btn bg-green mr-2 modal-btn" data-modal="create-setting">
            <span class="icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="vuesax/broken/additem">
                        <g id="additem">
                            <path id="Vector" d="M2 5.43C2 3.14 3.14 2 5.43 2H10C12.29 2 13.43 3.14 13.43 5.43"
                                stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path id="Vector_2" d="M8 16H5.43C3.14 16 2 14.86 2 12.57V9.98001" stroke="white"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path id="Vector_3"
                                d="M18.5701 22H14.0001C11.7101 22 10.5701 20.86 10.5701 18.57V11.43C10.5701 9.14 11.7101 8 14.0001 8H18.5701C20.8601 8 22.0001 9.14 22.0001 11.43V18.57C22.0001 20.86 20.8601 22 18.5701 22Z"
                                stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path id="Vector_4" d="M14.8701 15H18.1301" stroke="white" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path id="Vector_5" d="M16.5 16.63V13.37" stroke="white" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                    </g>
                </svg>
            </span>
            Добавить
        </div>
    </div>

    {{ $dataTable->table() }}


    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

@endsection

@section('sidebar')
    <div class="sidebar"></div>
@endsection


@push('modals')
    <div class="modal-container hidden" data-modal="update-setting">
        <div class="modal-overlay hidden"></div>
        <div class="modal hidden" data-modal="create-setting">
            <div class="modal-header mb-5 text-2xl">
                <div class="title">Новая переменная</div>
                <div class="close-modal">
                    ✖
                </div>
            </div>
                <div class="modal-content scrollbar">
                    <div class="input-group  mb-2">
                        <label for="name" class="label black">
                            Название
                        </label>
                        <input id="name" type="text" class="input border border-theme-blue border-solid convert-parent" data-child="slug-convert">
                    </div>
                    <div class="input-group  mb-2">
                        <label for="slug" class="label black pb-1">
                            Slug
                        </label>
                        <input id="slug" type="text" class="input border border-theme-blue border-solid slug-convert">
                    </div>
                    <div class="input-group  mb-2">
                        <label for="value" class="label black pb-1">
                            Значение
                        </label>
                        <input id="value" type="text" class="input border border-theme-blue border-solid">
                    </div>
                </div>
                <div class="modal-footer flex justify-end">
                        <div class="btn bg-green mr-2" id="createVariableSetting">
                            <span class="loader dark"></span>
                            Добавить
                        </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </div>

        <div class="modal hidden" data-modal="update-setting">
            <div class="modal-header mb-5 text-2xl">
                <div class="title">Обновление перменной: </div>
                <div class="close-modal">
                    ✖
                </div>
            </div>
                <div class="modal-content scrollbar">
                    <div class="input-group  mb-2">
                        <label for="var-name-update" class="label black">
                            Название
                        </label>
                        <input id="var-name-update" type="text" class="input border border-theme-blue border-solid">
                    </div>
                    <div class="input-group  mb-2">
                        <label for="var-slug-update" class="label black pb-1">
                            Slug
                        </label>
                        <input id="var-slug-update" type="text" class="input border border-theme-blue border-solid">
                    </div>
                    <div class="input-group  mb-2">
                        <label for="var-value-update" class="label black pb-1">
                            Значение
                        </label>
                        <input id="var-value-update" type="text" class="input border border-theme-blue border-solid">
                    </div>
                </div>
                <div class="modal-footer flex justify-end">
                        <div class="btn bg-green mr-2" id="updateVariableSetting">
                            <span class="loader dark"></span>
                            Обновить
                        </div>
                </div>
        </div>
    </div>
    @vite(['resources/js/pages/settingPage.js'])
@endpush
