@extends('admin-panel.layouts.main')

@section('title', 'Заказы')

@inject('orderService', 'App\Services\AdminPanel\OrderService')

@section('content')
    <div class="flex text-2xl text-white mb-5">
        <div class="title mr-5 flex items-center">
            <span>
                Заказы
            </span>
            <a href="{{route('admin.orders')}}?status_type=new" class="role-badge ml-4">Новый ({{$informationStatuses[$orderService::STATUS_ORDER_NEW]}})</a>
            <a href="{{route('admin.orders')}}?status_type=in_processing" class="role-badge ml-4">В обработке ({{$informationStatuses[$orderService::STATUS_ORDER_IN_PROCESSING]}})</a>
            <a href="{{route('admin.orders')}}?status_type=processed" class="role-badge ml-4">Обработанные ({{$informationStatuses[$orderService::STATUS_ORDER_PROCESSED]}})</a>
        </div>
    </div>

    {{ $dataTable->table() }}


    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endsection

@section('sidebar')
    <x-admin.sidebar.statistics item_show="orders" />
@endsection
