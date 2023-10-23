@extends('admin-panel.layouts.main')

@section('title', $category->name)

@section('content')
    <form action="{{route('admin.catalog.category.update', ['category' => $category->id])}}" method="POST">
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
            {{session()->get('successfully')}}
            </div>
        @endif
        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
            <span>Информация о категории</span>
            <div class="flex border-none">
                <div data-id="{{$category->id}}" class="mr-3 btn bg-red load-applications small-btn border-none delete-category">Удалить</div>
                <button class="btn load-applications small-btn border-none mr-3">Обновить</button>
            </div>
        </div>
        @csrf
        @method('PATCH')
        <div class="columns-4 mb-9">
            <div class="input-group">
                <label for="name" class="label flex">
                    <span>Название</span>
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="name" value="{{ $category->name }}" name="name" type="text" class="input convert-parent" data-child="slug-convert">
            </div>
            <div class="input-group">
                <label for="slug" class="label">
                    Slug
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="slug" value="{{ $category->slug }}" name="slug" type="text"class="input slug-convert">
            </div>
            <div class="input-group">
                <label for="position" class="label">
                    Позиция
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="position" value="{{ $category->position }}" name="position" type="text" class="input">
            </div>
            <div class="input-group">
                <label for="page_title" class="label">
                    Название страницы
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="page_title" value="{{ $category->page_title }}" name="page_title" type="text" class="input">
            </div>
        </div>
        <div class="columns-1 mb-9">
            <div class="flex flex-col input-group">
                <label for="parent-id" class="mb-4 label">Родительская категория</label>
                <select class="select" name="parent_id" id="parent-id">
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $category->parent_id ? 'selected' : null }}>
                            {{ $item->name }}</option>
                    @endforeach
                    @if ($category->parent_id)
                        <option value="">Отсутсвует</option>
                    @else
                        <option selected value="">Отсутсвует</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="columns-2 mb-9">
            <div class="input-group">
                <label for="keywords" class="label flex">
                    <span> Ключевые слова для seo</span>
                </label>
                <textarea id="keywords" class="input" name="keywords" rows="5" cols="33">{{$category->keywords}}</textarea>
            </div>
            <div class="input-group">
                <label for="description" class="label">
                    Описание для seo
                </label>
                <textarea id="description" name="description" class="input" name="story" rows="5" cols="33">{{$category->description}}</textarea>
            </div>
        </div>
        <div class="columns-1 mb-9">
            <div class="input-group">
                <label for="page_description" class="label flex">
                    Описание страницы
                    <x-admin.tinymce.message />
                </label>
                <textarea id="page_description" name="page_description" class="input" name="story" rows="5" cols="33">{{$category->page_description}}</textarea>
            </div>
        </div>
    </form>
    <input type="text" hidden name="category_id" value="{{$category->id}}">
    <div class="flex">
        <div class="columns-1 w-full flex justify-between mt-9 mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
            <span>Свойства категории</span>
            </div>
        </div>
        <div class="flex items-center mb-6">
            <div class="w-4/12 mr-4">
                <select id="new-property-category" name="new-property-category">
                    <option value="">Выберете свойство</option>
                </select>
            </div>
            <div class="btn bg-green" id="addCaregoryPropertyBtn">
                <span class="loader dark"></span>
                Добавить
        </div>
    </div>

    {{ $dataTable->table() }}

    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <x-admin.tinymce.setting />
@endsection


@section('sidebar')
    <x-admin.sidebar.categories item_show="categories" />
@endsection

@section('scripts')
    @vite(['resources/js/pages/updateCategoryProduct.js'])
    <x-admin.tinymce.script />
@endsection


{{-- @push('modals')
    <div class="modal-container hidden">
        <div class="modal-overlay hidden"></div>
        <div class="modal hidden" data-modal="create-category-property">
            <div class="modal-header mb-5 text-2xl">
                <div class="title">Новое свойство</div>
                <div class="close-modal">
                    ✖
                </div>
            </div>
            <div class="modal-content scrollbar">
                <div class="input-group mb-3">
                    <label for="property-name" class="label black pb-1">
                        Свойство
                    </label>
                    <select id="new-property-category" name="new-property-category">
                        <option value="">Выберете свойство</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer flex justify-end">
                <div class="btn bg-green mr-2" id="addCaregoryPropertyBtn">
                    <span class="loader dark"></span>
                    Добавить
                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="categoty_id" value="{{ $category->id }}">
        </div>

        <div class="modal hidden" data-modal="update-category-property">
            <div class="modal-header mb-5 text-2xl">
                <div class="title">Обновить свойство</div>
                <div class="close-modal">
                    ✖
                </div>
            </div>
            <div class="modal-content scrollbar">
                <div class="input-group mb-3">
                    <label for="name-property" class="label black pb-1">
                        Название
                    </label>
                    <input id="name-property" type="text" class="input border border-theme-blue border-solid"
                        placeholder="">
                </div>
                <div class="input-group mb-3">
                    <label for="description-property" class="label black pb-1">
                        Описание
                    </label>
                    <input id="description-property" type="text" class="input border border-theme-blue border-solid"
                        placeholder="">
                </div>
            </div>
            <div class="modal-footer flex justify-end">
                <div class="btn bg-green mr-2" id="updateCaregoryPropertyBtn">
                    <span class="loader dark"></span>
                    Обновить
                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="property_id" value="">
        </div>
    </div>
@endpush --}}
