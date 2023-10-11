@extends('admin-panel.layouts.main')

@section('title', $product->name)

@section('content')
    <form data-product="{{$product->id}}" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="formUpdateProduct">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session()->has('successfully'))
            <div class="alert alert-success">
                {{ session()->get('successfully') }}
            </div>
        @endif
        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
            <span>Общие сведения</span>
            <div class="flex product-types">
                @if ($product->visible)
                    <div class="flex visible-product visible">
                        <input type="checkbox" name="visible" hidden checked>
                    </div>
                @else
                    <div class="flex visible-product not-visible">
                        <input type="checkbox" name="visible" hidden>
                    </div>
                @endif
            </div>
            <button class="btn load-applications small-btn border-none">
                Обновить
            </button>
        </div>

        <div class="columns-3 mb-9">
            <div class="input-group">
                <label for="name" class="label flex">
                    <span>Название</span>
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="name" name="name" type="text" class="input"
                    value="{{ old('name') ? old('name') : $product->name }}">
            </div>
            <div class="input-group">
                <label for="slug" class="label">
                    Адрес в сети
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="slug" name="slug" type="text" class="input"
                    value="{{ old('slug') ? old('slug') : $product->slug }}">
            </div>
            <div class="input-group">
                <label for="page_title" class="label">
                    Заголовок страницы
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="page_title" name="page_title" type="text" class="input"
                    value="{{ old('page_title') ? old('page_title') : $product->page_title }}">
            </div>
        </div>
        <div class="columns-3 mb-9">
            <div class="input-group">
                <label for="name_tile" class="label">
                    Название на плитку
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="name_tile" name="name_tile" type="text" class="input"
                    value="{{ old('name_tile') ? old('name_tile') : $product->name_tile }}">
            </div>
            <div class="input-group">
                <label for="vendor_code" class="label">
                    Артикул
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="vendor_code" name="vendor_code" type="text" class="input"
                    value="{{ old('vendor_code') ? old('vendor_code') : $product->vendor_code }}">
            </div>
            <div class="input-group">
                <label for="position_in_category" class="label">
                    Позиция
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="position_in_category" value="{{ $product->position_in_category }}" name="position_in_category"
                    type="number" class="input">
            </div>
        </div>

        <div class="columns-1 mb-9">
            <div class="input-group">
                <label for="page_description" class="label">
                    Описание страницы
                    <x-admin.tinymce.message />
                </label>
                <textarea name="page_description" id="page_description" class="input" name="story" rows="5" cols="33">
                {{ old('page_description') ? old('page_description') : $product->page_description }}
            </textarea>
            </div>
        </div>

        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-2xl border-b-2 border-b-white">
            <span>SEO</span>
        </div>

        <div class="columns-2 mb-9">
            <div class="input-group">
                <label for="keywords" class="label flex">
                    <span>Ключевые слова</span>
                </label>
                <input id="keywords" name="keywords" type="text" class="input"
                    value="{{ old('keywords') ? old('keywords') : $product->keywords }}">
            </div>
            <div class="input-group">
                <label for="description" class="label">
                    Описание
                </label>
                <input id="description" name="description" type="text" class="input"
                    value="{{ old('description') ? old('description') : $product->description }}">
            </div>
        </div>
        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-2xl border-b-2 border-b-white">
            <span>Категория</span>
        </div>

        <div class="flex items-center mb-3">
            <select class="select mr-5 selected-category" class="select" name="category_id" id="category_id">
            </select>
            <div class="category_list flex">
            </div>
        </div>
    </form>




    <div class="mt-8 columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
        <span>Уникальные свойства</span>
        <a class="btn small-btn border-none add-unique-property-product modal-btn" data-modal="create-unique-property">Добавить</a>
        <a style="display: none" class="modal-btn" data-modal="update-unique-property">Добавить</a>
    </div>
    {{ $productUniquePropertyTable->table() }}

    {{ $productUniquePropertyTable->scripts(attributes: ['type' => 'module']) }}

    <div class="mt-8 columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
        <span>Варианты</span>
        <a href="{{route('admin.products.variants.create', ['product' => $product->id])}}" class="btn small-btn border-none">Добавить</a>
    </div>
    {{ $variantsTable->table() }}

    {{ $variantsTable->scripts(attributes: ['type' => 'module']) }}


    <x-admin.tinymce.script />
    <x-admin.tinymce.setting />
@endsection

@section('sidebar')
    <x-admin.sidebar.categories item_show="products" />
@endsection


@section('scripts')
    @vite(['resources/js/pages/productPage.js'])
@endsection


@push('modals')
    <div class="modal-container hidden">
        <div class="modal-overlay hidden"></div>
        <div class="modal hidden" data-modal="create-unique-property">
            <div class="modal-header mb-5 text-2xl">
                <div class="title">Новая свойство</div>
                <div class="close-modal">
                    ✖
                </div>
            </div>
            <div class="modal-content scrollbar">
                <div class="input-group  mb-2">
                    <label for="name" class="label black">
                        Название
                    </label>
                    <input id="name" type="text" class="input border border-theme-blue border-solid">
                </div>
                <div class="input-group  mb-2">
                    <label for="value" class="label black">
                        Значение
                    </label>
                    <input id="value" type="text" class="input border border-theme-blue border-solid">
                </div>
            </div>
            <div class="modal-footer flex justify-end">
                <div class="btn bg-green mr-2" id="createUniqueProperty">
                    <span class="loader dark"></span>
                    Добавить
                </div>
            </div>
        </div>

        <div class="modal hidden" data-modal="update-unique-property">
            <div class="modal-header mb-5 text-2xl">
                <div class="title"></div>
                <div class="close-modal">
                    ✖
                </div>
            </div>
            <div class="modal-content scrollbar">
                <div class="input-group  mb-2">
                    <label for="property-name" class="label black">
                        Название
                    </label>
                    <input id="property-name" type="text" class="input border border-theme-blue border-solid">
                </div>
                <div class="input-group  mb-2">
                    <label for="property-value" class="label black">
                        Значение
                    </label>
                    <input id="property-value" type="text" class="input border border-theme-blue border-solid">
                </div>
            </div>
            <div class="modal-footer flex justify-end">
                <div class="btn bg-green mr-2" id="updateUniqueProperty">
                    <span class="loader dark"></span>
                    Обновить
                </div>
            </div>
        </div>
    </div>
@endpush
