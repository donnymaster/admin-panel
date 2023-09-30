@extends('admin-panel.layouts.main')

@section('title', 'Новый товар')

@section('content')
    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
            <span>Общие сведения</span>
            <button href="{{ route('admin.products.create') }}"
                class="btn load-applications small-btn border-none">Добавить</button>
        </div>

        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-2xl border-b-2 border-b-white">
            Категория
        </div>

        <div class="flex">
            <select class="mr-5 selected-category" class="select" name="parent_id" id="parent_id" @if ($category) disabled @endif>
                <option value="1">Родитель 1</option>
                @if ($category)
                    <option selected value="{{$category->id}}">{{$category->name}}</option>
                @else

                @endif
                @foreach ($categories as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
            <div class="flex">
                <span>
                    Категория 1
                </span>
                <span>
                    >
                </span>
                <span>
                    Категория 2
                </span>
            </div>
        </div>

        <div class="columns-1 flex items-center justify-between mb-9 divide-x pb-2 text-white text-1xl border-b-2 border-b-white">
            <span>Список уникальных свойст</span>
            <span class="border-none text-3xl cursor-pointer">+</span>
        </div>

        <div class="container-category-property">

        </div>

        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
            <span>Вариации товара</span>
            <button href="{{ route('admin.products.create') }}"
                class="btn load-applications small-btn border-none">Добавить</button>
        </div>
    </form>
@endsection

@section('sidebar')
    <x-admin.sidebar.categories item_show="products" />
@endsection

@section('scripts')
    @vite(['resources/js/pages/createProductPage.js'])
@endsection
