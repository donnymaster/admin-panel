@extends('admin-panel.layouts.main')

@section('title', 'Заказы')

@section('content')
    <div class="flex text-2xl text-white mb-5">
        <div class="title mr-5 flex items-center">
            <span>
                Заказы
            </span>
            <a href="{{route('admin.orders')}}?status_type=new" class="role-badge ml-4">Новый</a>
            <a href="{{route('admin.orders')}}?status_type=in_processing" class="role-badge ml-4">В обработке</a>
            <a href="{{route('admin.orders')}}?status_type=processed" class="role-badge ml-4">Обработанные</a>
        </div>
    </div>

    {{ $dataTable->table() }}


    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endsection

@section('sidebar')
    <x-admin.sidebar.statistics item_show="orders" />
@endsection
