@extends('admin-panel.layouts.main')

@section('title', 'Новая категория')

@section('content')
    <form action="{{ route('admin.catalog.categories.store') }}" method="POST" enctype="multipart/form-data">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session()->has('successfully-created'))
            <div class="alert alert-success">
               {{session()->get('successfully-created')}}
            </div>
        @endif
        @csrf
        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
            <span>Общие сведения</span>
            <button type="submit" class="btn load-applications small-btn border-none">Добавить</button>
        </div>
        <div class="columns-3 mb-9">
            <div class="input-group">
                <label for="name" class="label flex">
                    <span>Название</span>
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="name" name="name" type="text" class="input" value="{{old('name')}}">
            </div>
            <div class="input-group">
                <label for="slug" class="label">
                    Адрес в сети
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="slug" name="slug" type="text" class="input" value="{{old('slug')}}">
            </div>
            <div class="input-group">
                <label for="position" class="label">
                    Позиция
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input value="{{old('position')}}" id="position" name="position" type="number" class="input" min="{{$minPosition}}" max="{{++$maxPosition}}">
            </div>
        </div>
        <div class="columns-2">
            <div class="input-group">
                <label for="page_title" class="label flex">
                    <span>Загловок</span>
                </label>
                <input value="{{old('page_title')}}" id="page_title" name="page_title" type="text" class="input">
            </div>
            <div class="input-group">
                <label for="parent_id" class="label flex">
                    <span>Родительская категория</span>
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <select class="select" name="parent_id" id="parent_id" @if ($selectedCategory) disabled @endif>
                    @if ($selectedCategory)
                        <option selected value="{{$selectedCategory->id}}">{{$selectedCategory->name}}</option>
                    @endif
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                        <option value="">Родительская</option>
                </select>
            </div>
        </div>
        <div class="columns-2 mb-9">
            <div class="input-group">
                <label for="description" class="label flex">
                    <span>Описание для seo</span>
                </label>
                <textarea id="description" class="input" name="description" rows="5" cols="33">{{old('description')}}</textarea>
            </div>
            <div class="input-group">
                <label for="keywords" class="label">
                    Ключевые слова для seo
                </label>
                <textarea id="keywords" name="keywords" class="input" name="story" rows="5" cols="33">{{old('keywords')}}</textarea>
            </div>
        </div>
        <div class="columns-1 mb-9">
            <div class="input-group">
                <label for="page_description" class="label">
                    Описание страницы
                    <x-admin.tinymce.message />
                </label>
                <textarea name="page_description" id="page_description" class="input" name="story" rows="5" cols="33">{{old('page_description')}}</textarea>
            </div>
        </div>
        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
            <span>Свойства (<span class="count_properties">0</span>)</span>
            <div class="btn add-property small-btn border-none">Добавить</div>
        </div>
        <div class="category-properties-container flex flex-col">
            @if (old('category-property'))
                <div class="old-data hidden">
                    @foreach (old('category-property') as $item)
                        <div class="old-row">
                            <input type="text" hidden name="category-property[{{$loop->iteration}}][name]" value="{{$item['name']}}">
                            <input type="text" hidden name="category-property[{{$loop->iteration}}][description]" value="{{$item['description']}}">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </form>

    <x-admin.tinymce.setting />
@endsection


@section('sidebar')
    <x-admin.sidebar.categories item_show="categories" />
@endsection

@section('scripts')
    @vite(['resources/js/pages/createCategoryPage.js'])

    <x-admin.tinymce.script />
@endsection
