@extends('admin-panel.layouts.main')

@section('title', 'Категории')

@section('content')
    <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
        <span>Категории</span>
        <a href="{{route('admin.catalog.categories.new')}}" class="btn load-applications small-btn border-none">Добавить</a>
    </div>
    {{ $dataTable->table() }}

    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endsection


@section('sidebar')
    <x-admin.sidebar.categories item_show="categories" />
@endsection
