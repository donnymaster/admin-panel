@extends('admin-panel.layouts.main')

@section('title', "Заказ № {$order->id}")

@inject('service', 'App\Services\AdminPanel\OrderService')

@section('content')
    <div class="flex text-2xl text-white mb-5">
        <div class="title flex items-center w-full">
            <span class="flex">
                <span>Заказ № {{ $order->id }}</span>
                <div class="flex">
                    @if ($service::STATUS_ORDER_NEW == $order->status)
                        <div class="role-badge ml-2">Новый</div>
                    @endif

                    @if ($service::STATUS_ORDER_IN_PROCESSING == $order->status)
                        <div class="role-badge ml-2">В обработке</div>
                    @endif

                    @if ($service::STATUS_ORDER_PROCESSED == $order->status)
                        <div class="role-badge ml-2">Закрытый</div>
                    @endif
                </div>
            </span>
            <div class="flex ml-auto change-status-order" data-id="{{$order->id}}">
                @if ($service::STATUS_ORDER_NEW == $order->status)
                    <div data-type="in_processing" class="order-status role-badge ml-5 cursor-pointer">В обработке</div>
                    <div data-type="processed" class="order-status role-badge ml-2 cursor-pointer">Закрыт</div>
                @endif

                @if ($service::STATUS_ORDER_IN_PROCESSING == $order->status)
                    <div data-type="new" class="order-status role-badge ml-5 cursor-pointer">Новый</div>
                    <div data-type="processed" class="order-status role-badge ml-2 cursor-pointer">Закрыт</div>
                @endif

                @if ($service::STATUS_ORDER_PROCESSED == $order->status)
                    <div data-type="in_processing" class="order-status role-badge ml-5 cursor-pointer">В обработке</div>
                @endif
            </div>
        </div>
    </div>

    @if ($service::STATUS_ORDER_PROCESSED == $order->status)
        <form id="mainForm" data-id="{{$order->id}}" class="disabled">
    @else
        <form id="mainForm" data-id="{{$order->id}}" action="{{ route('admin.orders.update', ['order' => $order->id]) }}" method="POST">
    @endif
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
        @method('PATCH')
        <div class="columns-2 mb-9">
            <div class="input-group">
                <label for="client_name" class="label flex">
                    <span>Клиент</span>
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input
                    id="client_name"
                    name="client_name"
                    type="text"
                    class="input"
                    @disabled($service::STATUS_ORDER_PROCESSED == $order->status)
                    value="{{ old('client_name') ? old('client_name') : $order->client_name }}"
                    >
            </div>
            <div class="input-group">
                <label for="phone_number" class="label">
                    Номер телефона
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input
                    id="phone_number"
                    name="phone_number"
                    type="text"
                    class="input"
                    @disabled($service::STATUS_ORDER_PROCESSED == $order->status)
                    value="{{ old('phone_number') ? old('phone_number') : $order->phone_number }}"
                    >
            </div>
        </div>
        <div class="columns-2 mb-9">
            <div class="input-group">
                <label for="delivery_address" class="label flex">
                    <span>Адрес доставки</span>
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input
                    id="delivery_address"
                    name="delivery_address"
                    type="text" class="input"
                    @disabled($service::STATUS_ORDER_PROCESSED == $order->status)
                    value="{{ old('delivery_address') ? old('delivery_address') : $order->delivery_address }}"
                    >
            </div>
            <div class="input-group">
                <label for="type_delivery" class="label">
                    Вариант доставки
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input
                    id="type_delivery"
                    name="type_delivery"
                    type="text"
                    class="input"
                    @disabled($service::STATUS_ORDER_PROCESSED == $order->status)
                    value="{{ old('type_delivery') ? old('type_delivery') : $order->type_delivery }}"
                    >
            </div>
        </div>
        <div class="columns-2 mb-9">
            <div class="input-group">
                <label for="user_annotation" class="label flex">
                    <span>Пометки пользователя</span>
                </label>
                <textarea
                    id="user_annotation"
                    class="input"
                    name="user_annotation"
                    rows="5"
                    @disabled($service::STATUS_ORDER_PROCESSED == $order->status)
                    cols="33">{{ old('user_annotation') ? old('user_annotation') : $order->user_annotation }}</textarea>
            </div>
            <div class="input-group">
                <label for="admin_annotation" class="label">
                    Пометки администратора
                </label>
                <textarea
                    id="admin_annotation"
                    class="input"
                    name="admin_annotation"
                    rows="5"
                    @disabled($service::STATUS_ORDER_PROCESSED == $order->status)
                    cols="33">{{ old('admin_annotation') ? old('admin_annotation') : $order->admin_annotation }}</textarea>
            </div>
        </div>
       <div class="flex justify-end">
            @if ($service::STATUS_ORDER_PROCESSED != $order->status)
                <button class="btn load-applications border-none">
                    Обновить
                </button>
            @endif
       </div>
    </form>

    <div class="mt-5 items-end columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
        <div class="flex items-center">
            <span class="mr-2">Товары</span>
            <div class="variant-add add-custom-image modal-btn" data-modal="add-product"></div>
        </div>
        <span class="text-sm border-none">Общая стоимость: <span class="text-theme-green ml-2">{{$order->total_quantity}} руб.</span></span>
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
                                <div class="variant-delete remove-product"></div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion__body">
                        @foreach ($productList as $variant)
                            <div class="flex variant-item" data-pivot="{{$variant->pivot->id}}">
                                <div class="flex items-center">
                                    <div class="variant-title mr-3">{{$loop->iteration}}) {{$variant->title}}</div>
                                    <div
                                    @class([
                                        'variant-price',
                                        'mr-3',
                                    ])
                                    >
                                        {{$variant->price}} руб.
                                    </div>
                                    <div class="variant-price mr-3">{{$variant->pivot->count_product}} шт.</div>
                                    @if (isset($variant->pivot->promocode))
                                        <div class="variant-promocode">
                                            <div class="flex items-center">
                                                <span class="mr-2">Промокод: {{$variant->pivot->promocode->percentages}}%</span>
                                                <span class="mr-2">|</span>
                                                <span class="text-theme-green mr-2">{{($variant->price - ($variant->price * ($variant->pivot->promocode->percentages / 100))) * $variant->pivot->count_product}} руб.</span>
                                                <div class="remove-promocode"></div>
                                            </div>
                                            </div>
                                    @else
                                        <div class="variant-promocode">Промокод: -</div>
                                        <div class="flex items-center">
                                            <span class="mr-2 ml-2">|</span>
                                            <span class="text-theme-green mr-2">{{$variant->price * $variant->pivot->count_product}} руб.</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex">
                                    <div class="variant-delete minus-count-variant mr-2"></div>
                                    <div class="variant-add add-count-variant"></div>
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

@push('modals')
    <div class="modal-container hidden">
        <div class="modal-overlay hidden"></div>
        <div class="modal hidden" data-modal="add-product">
            <div class="modal-header mb-5 text-2xl">
                <div class="title">Добавить товар</div>
                <div class="close-modal">
                    ✖
                </div>
            </div>
            <div class="modal-content scrollbar">
                <div class="input-group mb-2">
                    <label for="promocode" class="label black pb-1">
                        Промокод
                    </label>
                    <input id="promocode" type="text" class="input border border-theme-blue border-solid">
                </div>
                <div class="input-group mb-2">
                    <label for="variant-count" class="label black pb-1">
                        Количество
                    </label>
                    <input id="variant-count" type="text" class="input border border-theme-blue border-solid">
                </div>
                <div class="input-group mb-2 input-search-parent relative">
                    <label for="add-product" class="label black pb-1">
                        Продукт(вариация)
                    </label>
                    <input id="add-product" type="text" class="input border border-theme-blue border-solid">
                </div>
            </div>
            <div class="modal-footer flex justify-end">
                <div class="btn bg-green" id="addVariantProductInOrder">
                    <span class="loader dark"></span>
                    Добавить
                </div>
            </div>
        </div>
    </div>
@endpush
