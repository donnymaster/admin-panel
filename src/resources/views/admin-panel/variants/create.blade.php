@extends('admin-panel.layouts.main')

@section('title', 'Новый вариант')

@section('content')
    <div data-product="{{$product->id}}" id="information" class="variant-product flex flex-col">
        <div class="columns-2 mb-4">
            <div class="input-group">
                <label for="product-variant-name-${countVariant}" class="label">
                    Название
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="product-variant-name-${countVariant}" name="product-variant-name-${countVariant}" type="text"
                    class="input">
            </div>
            <div class="input-group">
                <label for="product-variant-page-title-${countVariant}" class="label">
                    Заголовок страницы
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="product-variant-page-title-${countVariant}" name="product-variant-page-title-${countVariant}"
                    type="text" class="input">
            </div>
        </div>
        <div class="columns-2 mb-4">
            <div class="input-group">
                <label for="product-variant-price-${countVariant}" class="label">
                    Цена
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="product-variant-price-${countVariant}" name="product-variant-price-${countVariant}"
                    type="text" class="input">
            </div>
            <div class="input-group">
                <label for="product-variant-count-${countVariant}" class="label">
                    Количество
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="product-variant-count-${countVariant}" name="product-variant-count-${countVariant}"
                    type="number" min="1" class="input">
            </div>
        </div>

        <div class="columns-1 text-white mt-4 flex justify-between mb-9 divide-x pb-2 text-3xl border-b-2 border-b-white">
            <span>Картинки варианта</span>
            <div class="btn btn-add-image small-btn border-none ml-auto">Добавить</div>
        </div>

        <div style="display:none" class="modal-btn" data-modal="add-image">Добавить</div>

        <div class="load-images-container">
            <div class="empty-data">
            </div>
        </div>
    </div>
@endsection

@section('sidebar')
    <x-admin.sidebar.categories item_show="products" />
@endsection

@section('scripts')
    @vite(['resources/js/pages/createVariantPage.js'])
@endsection

@push('modals')
    <div class="modal-container hidden">
        <div class="modal-overlay hidden"></div>
        <div class="modal hidden" data-modal="add-image">
            <div class="modal-header mb-5 text-2xl">
                <div class="title">
                   <div class="flex items-center">
                    <span>Новая картинка</span>
                    <div class="checkbox ml-3 text-sm mt-1">
                        <input class="custom-checkbox" type="checkbox" checked id="proportions">
                        <label for="proportions">Пропорции</label>
                    </div>
                   </div>
                </div>
                <div class="close-modal">
                    ✖
                </div>
            </div>
                <div class="modal-content scrollbar">
                    <div class="input-group  mb-2">
                        <label for="image-mark" class="label black">
                            Пометка
                        </label>
                        <input id="image-mark" type="text" class="input border border-theme-blue border-solid">
                    </div>
                    <div class="columns-2">
                        <div class="input-group  mb-2">
                            <label for="image-width" class="label black pb-1">
                                Ширина
                            </label>
                            <input id="image-width" type="text" class="input border border-theme-blue border-solid">
                        </div>
                        <div class="input-group  mb-2">
                            <label for="image-height" class="label black pb-1">
                                Высота
                            </label>
                            <input id="image-height" type="text" class="input border border-theme-blue border-solid">
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex justify-end">
                    <div class="btn bg-green mr-2" id="addNewImage">
                        <span class="loader dark"></span>
                        Добавить
                    </div>
                </div>
        </div>
    </div>
@endpush
