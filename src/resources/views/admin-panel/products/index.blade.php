@extends('admin-panel.layouts.main')

@section('title', 'Товары')

@section('content')
    @if ($category)
        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
            <span>Категория: {{ $category->name }}</span>
            <a href="{{route('admin.products.create')}}" class="btn load-applications small-btn border-none">Добавить</a>
        </div>
    @else
        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-3xl border-b-2 border-b-white">
            <a href="{{route('admin.products.create')}}" class="btn load-applications small-btn border-none ml-auto">Добавить</a>
        </div>
    @endif
    {{ $dataTable->table() }}

    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endsection


@section('sidebar')
    <x-admin.sidebar.categories item_show="products" />
@endsection
