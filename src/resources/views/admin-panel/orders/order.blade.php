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
                <div class="role-badge ml-2 print-order cursor-pointer">Печатать</div>
            </span>
            <div class="flex ml-auto change-status-order" data-id="{{ $order->id }}">
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
        <form id="mainForm" data-id="{{ $order->id }}" class="disabled">
        @else
            <form id="mainForm" data-id="{{ $order->id }}"
                action="{{ route('admin.orders.update', ['order' => $order->id]) }}" method="POST">
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
            <input id="client_name" name="client_name" type="text" class="input" @disabled($service::STATUS_ORDER_PROCESSED == $order->status)
                value="{{ old('client_name') ? old('client_name') : $order->client_name }}">
        </div>
        <div class="input-group">
            <label for="phone_number" class="label">
                Номер телефона
                <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
            </label>
            <input id="phone_number" name="phone_number" type="text" class="input" @disabled($service::STATUS_ORDER_PROCESSED == $order->status)
                value="{{ old('phone_number') ? old('phone_number') : $order->phone_number }}">
        </div>
    </div>
    <div class="columns-2 mb-9">
        <div class="input-group">
            <label for="delivery_address" class="label flex">
                <span>Адрес доставки</span>
                <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
            </label>
            <input id="delivery_address" name="delivery_address" type="text" class="input" @disabled($service::STATUS_ORDER_PROCESSED == $order->status)
                value="{{ old('delivery_address') ? old('delivery_address') : $order->delivery_address }}">
        </div>
        <div class="input-group">
            <label for="type_delivery" class="label">
                Вариант доставки
                <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
            </label>
            <input id="type_delivery" name="type_delivery" type="text" class="input" @disabled($service::STATUS_ORDER_PROCESSED == $order->status)
                value="{{ old('type_delivery') ? old('type_delivery') : $order->type_delivery }}">
        </div>
    </div>
    <div class="columns-2 mb-9">
        <div class="input-group">
            <label for="user_annotation" class="label flex">
                <span>Пометки пользователя</span>
            </label>
            <textarea id="user_annotation" class="input" name="user_annotation" rows="5" @disabled($service::STATUS_ORDER_PROCESSED == $order->status)
                cols="33">{{ old('user_annotation') ? old('user_annotation') : $order->user_annotation }}</textarea>
        </div>
        <div class="input-group">
            <label for="admin_annotation" class="label">
                Пометки администратора
            </label>
            <textarea id="admin_annotation" class="input" name="admin_annotation" rows="5" @disabled($service::STATUS_ORDER_PROCESSED == $order->status)
                cols="33">{{ old('admin_annotation') ? old('admin_annotation') : $order->admin_annotation }}</textarea>
        </div>
    </div>
    <div class="flex justify-end print-hidden">
        @if ($service::STATUS_ORDER_PROCESSED != $order->status)
            <button class="btn load-applications border-none">
                Обновить
            </button>
        @endif
    </div>
    </form>

    <div class="parent-search mt-5 columns-1 flex mb-5 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
        <span class="border-none mr-4">Товары</span>
        <div class="print-hidden input-group mb-2 input-search-parent relative">
            <input id="addVariant" type="text" class="input border border-theme-blue border-solid">
        </div>
    </div>

    <div class="products-list">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Фото</th>
                        <th>Описание</th>
                        <th>Количество</th>
                        <th>Цена</th>
                        <th>Сумма</th>
                        <th class="text-center print-hidden">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->variants as $variant)
                        @php
                            $name = mb_strlen($variant->title) >= 20 ? mb_substr($variant->title, 0, 20) . '...' : $variant->title;
                        @endphp
                        <tr data-id="{{$variant->id}}">
                            <td>
                                @if (!is_null($variant->images->where('slug', 'image-mini')->first()))
                                    <img src="/storage/{{ $variant->images->where('slug', 'image-mini')->first()->path }}"
                                        alt="{{ $name }}">
                                @else
                                    <img alt="{{ $name }}">
                                @endif
                            </td>
                            <td>
                                <div class="inline-flex flex-col items-center">
                                    <div title="{{ $variant->title }}" class="text-start variant-name">{{ $name }}</div>
                                    <div data-count="{{ $variant->count }}"
                                        class="text-sm self-start font-light total-variant">
                                        <span>{{ $variant->count }}</span> шт.
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input data-id="{{ $variant->id }}" type="number" min="1"
                                    max="{{ $variant->count }}" class="input input-order"
                                    value="{{ $variant->pivot->count_product }}">
                            </td>
                            <td class="variant-price">
                                <span>{{ $variant->price }}</span> руб.
                            </td>
                            <td class="variant-total-price">
                                <span>{{ $variant->price * $variant->pivot->count_product }}</span> руб.
                            </td>
                            <td class="print-hidden">
                                <div data-id="{{ $variant->id }}" class="remove-icon"></div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div
            class="mt-5 columns-1 flex-wrap justify-end flex mb-9 divide-x pt-4 text-white text-3xl border-t-2 border-b-white">
            @php
                $totalPrice = $order->variants->sum(function ($variant) {
                    return $variant->price * $variant->pivot->count_product;
                });
            @endphp

            <div class="border-none mb-4 w-full text-lg text-right">
                Общая стоимость:
                <span class="total-order-price"> {{ $totalPrice }}</span> руб.
            </div>

            @if ($order->promocode)
                <div class="flex items-center border-none promocode-container">
                    <svg id="deletePromocode" class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M11.92 22C17.42 22 21.92 17.5 21.92 12C21.92 6.5 17.42 2 11.92 2C6.42004 2 1.92004 6.5 1.92004 12C1.92004 17.5 6.42004 22 11.92 22Z"
                            stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M7.92004 12H15.92" stroke="black" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <div class="border-none ml-2 w-full text-lg text-right">
                        Промокод(<span class="promocode-percentage">{{ $order->promocode->percentages }}</span>%):
                        <span class="total-order-price-promocode">
                            {{ $totalPrice - ($totalPrice * $order->promocode->percentages) / 100 }}
                        </span> руб.
                    </div>
                </div>
            @else
                <div class="flex items-center border-none">
                    <svg id="addPromocode" class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z"
                            stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M8 12H16" stroke="black" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M12 16V8" stroke="black" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <div class="border-none ml-2 w-full text-lg text-right">Промокод: -</div>
                </div>
            @endif
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
