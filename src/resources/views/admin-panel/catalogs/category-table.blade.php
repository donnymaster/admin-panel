@extends('admin-panel.layouts.main')

@section('title', 'Категории')

@section('content')
    {{ $dataTable->table() }}

    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endsection


@section('sidebar')
    <x-admin.sidebar.categories item_show="categories" />
@endsection
