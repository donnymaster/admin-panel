@extends('admin-panel.layouts.main')

@section('title', 'Заказы')

@section('content')
    <div class="flex text-2xl text-white mb-5">
        <div class="title mr-5 flex items-center">
            <span>
                Заказы
            </span>
            <a id="countNew" href="{{route('admin.orders')}}?status_type=new" class="role-badge ml-4">Новый (0)</a>
            <a id="countInProcessing" href="{{route('admin.orders')}}?status_type=in_processing" class="role-badge ml-2">В обработке (0)</a>
            <a id="countProcessed" href="{{route('admin.orders')}}?status_type=processed" class="role-badge ml-2">Обработанные (0)</a>
            <a href="{{route('admin.orders')}}" class="role-badge ml-2">Все</a>


            <div id="updateOrdersToInprocessing" class="role-badge ml-5 cursor-pointer">В обработке</div>
            <div id="updateOrdersToProcessed" class="role-badge ml-2 cursor-pointer">Закрыт</div>
        </div>
    </div>

    {{ $dataTable->table() }}


    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endsection

@section('sidebar')
    <x-admin.sidebar.statistics item_show="orders" />
@endsection


@section('scripts')
    @vite(['resources/js/pages/ordersPage.js'])
@endsection
