@extends('admin-panel.layouts.main')

@section('title', $order->client_name)

@inject('service', 'App\Services\AdminPanel\OrderService')

@section('content')
    <div class="flex text-2xl text-white mb-5">
        <div class="title flex items-center w-full">
            <span>
                Заказ № {{ $order->id }}
            </span>
            <div class="flex ml-auto">
                @if ($service::STATUS_ORDER_NEW == $order->status)
                    <div id="updateOrdersToInprocessing" class="role-badge ml-5 cursor-pointer">В обработке</div>
                    <div id="updateOrdersToProcessed" class="role-badge ml-2 cursor-pointer">Закрыт</div>
                @endif

                @if ($service::STATUS_ORDER_IN_PROCESSING == $order->status)
                    <div id="updateOrdersToInprocessing" class="role-badge ml-5 cursor-pointer">Новый</div>
                    <div id="updateOrdersToProcessed" class="role-badge ml-2 cursor-pointer">Закрыт</div>
                @endif

                @if ($service::STATUS_ORDER_PROCESSED == $order->status)
                    <div id="updateOrdersToInprocessing" class="role-badge ml-5 cursor-pointer">В обработке</div>
                    <div id="updateOrdersToProcessed" class="role-badge ml-2 cursor-pointer">Закрыт</div>
                @endif
            </div>
        </div>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="formCreateProduct">
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
        <div class="columns-2 mb-9">
            <div class="input-group">
                <label for="client_name" class="label flex">
                    <span>Клиент</span>
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="client_name" name="client_name" type="text" class="input"
                    value="{{ old('client_name') ? old('client_name') : $order->client_name }}">
            </div>
            <div class="input-group">
                <label for="phone_number" class="label">
                    Номер телефона
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="phone_number" name="phone_number" type="text" class="input"
                    value="{{ old('phone_number') ? old('phone_number') : $order->phone_number }}">
            </div>
        </div>
        <div class="columns-2 mb-9">
            <div class="input-group">
                <label for="delivery_address" class="label flex">
                    <span>Адрес доставки</span>
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="delivery_address" name="delivery_address" type="text" class="input"
                    value="{{ old('delivery_address') ? old('delivery_address') : $order->delivery_address }}">
            </div>
            <div class="input-group">
                <label for="type_delivery" class="label">
                    Вариант доставки
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="type_delivery" name="type_delivery" type="text" class="input"
                    value="{{ old('type_delivery') ? old('type_delivery') : $order->type_delivery }}">
            </div>
        </div>
        <div class="columns-2 mb-9">
            <div class="input-group">
                <label for="user_annotation" class="label flex">
                    <span>Пометки пользователя</span>
                </label>
                <textarea id="user_annotation" class="input" name="user_annotation" rows="5" cols="33">{{ old('user_annotation') ? old('user_annotation') : $order->user_annotation }}</textarea>
            </div>
            <div class="input-group">
                <label for="admin_annotation" class="label">
                    Пометки администратора
                </label>
                <textarea id="admin_annotation" class="input" name="admin_annotation" rows="5" cols="33">{{ old('admin_annotation') ? old('admin_annotation') : $order->admin_annotation }}</textarea>
            </div>
        </div>
       <div class="flex justify-end">
            <button class="btn load-applications small-btn border-none">
                Обновить
            </button>
       </div>
    </form>

    <div class="mt-5 items-end columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
        <div class="flex items-center">
            <span class="mr-2">Товары</span>
            <div class="variant-add add-custom-image"></div>
        </div>
        <span class="text-sm border-none">Общая стоимость: <span>{{$order->total_quantity}} руб.</span></span>
    </div>
    <div class="products-list">
        <div class="accordion" id="accordion-1">
            @foreach ($products as $productList)
                <div data-id="{{$productList->first()->product->id}}" class="accordion__item">
                    <div class="accordion__header">
                        <div class="flex justify-between items-center">
                            <div class="mr-3">
                                {{$productList->first()->product->title}} : {{$productList->sum('pivot.count_product')}} шт.
                            </div>

                            <div class="flex">
                                <div class="variant-delete remove-row"></div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion__body">
                        @foreach ($productList as $variant)
                            <div class="flex variant-item">
                                <div class="flex items-center">
                                    <div class="variant-title mr-3">{{$variant->title}}</div>
                                    <div class="variant-price text-theme-green mr-3">{{$variant->price}} руб.</div>
                                    <div class="variant-price">{{$variant->pivot->count_product}} шт.</div>
                                </div>
                                <div class="flex">
                                    <div class="variant-delete remove-row"></div>
                                    <div class="variant-add add-custom-image"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('sidebar')
    <x-admin.sidebar.statistics item_show="orders" />
@endsection


@section('scripts')
    @vite(['resources/js/pages/orderPage.js'])
@endsection
