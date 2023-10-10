@extends('admin-panel.layouts.main')

@section('title', 'Промокоды')

@section('content')
    <div class="flex mb-9 items-center text-2xl text-white justify-between">
        <span class="pr-5">Промокоды</span>
        <div class="btn bg-green mr-2 modal-btn" data-modal="create-promocode">
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
        <div style="display:none" class="btn bg-green mr-2 modal-btn" data-modal="update-promocode">
            Обновить
        </div>
    </div>

    {{ $dataTable->table() }}

    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endsection

@section('sidebar')
    <x-admin.sidebar.categories item_show="code" />
@endsection


@push('modals')
    <div class="modal-container hidden">
        <div class="modal-overlay hidden"></div>
        <div class="modal hidden" data-modal="create-promocode">
            <div class="modal-header mb-5 text-2xl">
                <div class="flex">
                    <div class="title mr-2">Новый промокод</div>
                    <div class="status">
                        <div class="visible"></div>
                        <input id="status" value="1" hidden type="text">
                    </div>
                </div>
                <div class="close-modal">
                    ✖
                </div>
            </div>
            <div class="modal-content scrollbar">
                <div class="input-group  mb-2">
                    <label for="name" class="label black">
                        Название
                    </label>
                    <input id="name" type="text" class="input border border-theme-blue border-solid convert-parent"
                        data-child="slug-convert">
                </div>
                <div class="input-group  mb-2">
                    <div class="flex items-center mb-1">
                        <label for="quantity" class="label mr-3 black">
                            Количество
                        </label>
                        <div class="flex promocode-variants mb-1">
                            <div data-value="10" class="promocode-variant">10</div>
                            <div data-value="20" class="promocode-variant">20</div>
                            <div data-value="50" class="promocode-variant">50</div>
                            <div data-value="100" class="promocode-variant">100</div>
                            <div data-value="200" class="promocode-variant">200</div>
                            <div data-value="500" class="promocode-variant">500</div>
                            <div data-value="750" class="promocode-variant">750</div>
                            <div data-value="1000" class="promocode-variant">1000</div>
                            <div data-value="5000" class="promocode-variant">5000</div>
                            <div data-value="10000" class="promocode-variant">10000</div>
                        </div>
                    </div>
                    <input id="quantity" type="text" class="input border border-theme-blue border-solid">
                </div>
                <div class="input-group mb-2">
                    <label for="code" class="label black pb-1">
                        Код
                    </label>
                    <div class="container-generate-code">
                        <div class="generate-code-icon"></div>
                        <input id="code" type="text" class="input border border-theme-blue border-solid">
                    </div>
                </div>
                <div class="input-group mb-2">
                    <label for="percentages" class="label black pb-1">
                        Процент
                    </label>
                    <input id="percentages" type="text" class="input border border-theme-blue border-solid">
                </div>
                <div class="input-group mb-2 input-search-parent relative">
                    <label for="product" class="label black pb-1">
                        Продукт
                    </label>
                    <input id="product" type="text" class="input border border-theme-blue border-solid">
                </div>
            </div>
            <div class="modal-footer flex justify-end">
                <div class="btn bg-green mr-2" id="createPromocodeBtn">
                    <span class="loader dark"></span>
                    Добавить
                </div>
            </div>
        </div>

        <div class="modal hidden" data-modal="update-promocode">
            <div class="modal-header mb-5 text-2xl">
                <div class="flex">
                    <div class="title mr-2">Новый промокод</div>
                    <div class="status">
                        <div class="visible"></div>
                        <input id="new-status" value="1" hidden type="text">
                    </div>
                </div>
                <div class="close-modal">
                    ✖
                </div>
            </div>
            <div class="modal-content scrollbar">
                <div class="input-group  mb-2">
                    <label for="new-name" class="label black">
                        Название
                    </label>
                    <input id="new-name" type="text" class="input border border-theme-blue border-solid convert-parent"
                        data-child="slug-convert">
                </div>
                <div class="input-group  mb-2">
                    <div class="flex items-center mb-1">
                        <label for="new-quantity" class="label mr-3 black">
                            Количество
                        </label>
                        <div class="flex promocode-variants mb-1">
                            <div data-value="10" class="promocode-variant">10</div>
                            <div data-value="20" class="promocode-variant">20</div>
                            <div data-value="50" class="promocode-variant">50</div>
                            <div data-value="100" class="promocode-variant">100</div>
                            <div data-value="200" class="promocode-variant">200</div>
                            <div data-value="500" class="promocode-variant">500</div>
                            <div data-value="750" class="promocode-variant">750</div>
                            <div data-value="1000" class="promocode-variant">1000</div>
                            <div data-value="5000" class="promocode-variant">5000</div>
                            <div data-value="10000" class="promocode-variant">10000</div>
                        </div>
                    </div>
                    <input id="new-quantity" type="text" class="input border border-theme-blue border-solid">
                </div>
                <div class="input-group mb-2">
                    <label for="new-code" class="label black pb-1">
                        Код
                    </label>
                    <div class="container-generate-code">
                        <div class="generate-code-icon"></div>
                        <input id="new-code" type="text" class="input border border-theme-blue border-solid">
                    </div>
                </div>
                <div class="input-group mb-2">
                    <label for="new-percentages" class="label black pb-1">
                        Процент
                    </label>
                    <input id="new-percentages" type="text" class="input border border-theme-blue border-solid">
                </div>
                <div class="input-group mb-2">
                    <label for="new-product" class="label black pb-1">
                        Продукт
                    </label>
                    <input id="new-product" type="text" class="input border border-theme-blue border-solid">
                </div>
            </div>
            <div class="modal-footer flex justify-end">
                <div class="btn bg-green mr-2" id="updatePromocodeBtn">
                    <span class="loader dark"></span>
                    Обновить
                </div>
            </div>
        </div>
    </div>
    @vite(['resources/js/pages/promocodePage.js'])
@endpush
