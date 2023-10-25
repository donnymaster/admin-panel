@extends('admin-panel.layouts.main')

@section('title', 'Свойства')

@section('content')
    <div class="flex mb-9 items-center text-2xl text-white justify-between">
        <span class="pr-5">Свойства</span>
        <div class="btn bg-green mr-2 modal-btn" data-modal="create-property">
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
        <div style="display:none" class="btn bg-green mr-2 modal-btn" data-modal="update-property">
            Обновить
        </div>
    </div>

    {{ $dataTable->table() }}


    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endsection

@section('sidebar')
    <x-admin.sidebar.categories item_show="properties" />
@endsection

@push('modals')
    <div class="modal-container hidden">
        <div class="modal-overlay hidden"></div>
        <div class="modal hidden" data-modal="create-property">
            <div class="modal-header mb-5 text-2xl">
                <div class="flex">
                    <div class="title mr-2">Новое свойство</div>
                </div>
                <div class="close-modal">
                    ✖
                </div>
            </div>
            <div class="modal-content scrollbar">
                <form>
                    <div class="input-group  mb-2">
                        <label for="name" class="label black">
                            Название
                        </label>
                        <input id="name" name="name" type="text"
                            class="input border border-theme-blue border-solid">
                    </div>
                    <div class="input-group  mb-2">
                        <label for="description" class="label black">
                            Описание
                        </label>
                        <input id="description" name="description" type="text"
                            class="input border border-theme-blue border-solid">
                    </div>
                    <div class="input-group  mb-2">
                        <label for="mark" class="label black">
                            Пометка
                        </label>
                        <input id="mark" name="mark" type="text"
                            class="input border border-theme-blue border-solid">
                    </div>
                </form>
            </div>
            <div class="modal-footer flex justify-end">
                <div class="btn bg-green mr-2" id="createPropertyBtn">
                    <span class="loader dark"></span>
                    Добавить
                </div>
            </div>
        </div>

        <div class="modal hidden" data-modal="update-property">
            <div class="modal-header mb-5 text-2xl">
                <div class="flex">
                    <div class="title mr-2">Новое свойство</div>
                </div>
                <div class="close-modal">
                    ✖
                </div>
            </div>
            <div class="modal-content scrollbar">
                <form>
                    <div class="input-group  mb-2">
                        <label class="label black">
                            Название
                        </label>
                        <input name="name" type="text" class="input border border-theme-blue border-solid">
                    </div>
                    <div class="input-group  mb-2">
                        <label class="label black">
                            Описание
                        </label>
                        <input name="description" type="text" class="input border border-theme-blue border-solid">
                    </div>
                    <div class="input-group  mb-2">
                        <label class="label black">
                            Пометка
                        </label>
                        <input name="mark" type="text" class="input border border-theme-blue border-solid">
                    </div>
                </form>
            </div>
            <div class="modal-footer flex justify-end">
                <div class="btn bg-green mr-2" id="updatePropertyBtn">
                    <span class="loader dark"></span>
                    Обновить
                </div>
            </div>
        </div>
    </div>
    @vite(['resources/js/pages/propertiesPage.js'])
@endpush
