@extends('admin-panel.layouts.main')

@section('title', 'Комментарии')

@section('content')
    @if ($variant)
        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-2xl border-b-2 border-b-white border-r-0">
            <span>
                Вариант: {{$variant->page_title}} |
                <a class="link white" href="{{route('admin.products.show', ['product' => $variant->product_id])}}">продукт 🡵</a></span>
        </div>
    @else
        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-2xl border-b-2 border-b-white">
            <span>Все комментарии</span>
        </div>
    @endif

    {{ $dataTable->table() }}

    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <div style="display: none;" class="btn bg-green mr-2 modal-btn" data-modal="show-review"></div>
    <div style="display: none;" class="btn bg-green mr-2 modal-btn" data-modal="update-review"></div>
@endsection


@section('scripts')
    @vite(['resources/js/pages/productReviewPage.js'])
@endsection

@section('sidebar')
    <x-admin.sidebar.categories item_show="reviews" />
@endsection



@push('modals')
    <div class="modal-container hidden">
        <div class="modal-overlay hidden"></div>
        <div class="modal hidden" data-modal="show-review">
            <div class="modal-header mb-5 text-2xl">
                <div class="title text-1xl"></div>
                <div class="close-modal">
                    ✖
                </div>
            </div>
            <div class="modal-content scrollbar">
                <div class="flex items-center justify-between mb-3">
                    <div class="client mr-2"></div>
                    <div class="rating mr-auto"></div>
                    <div class="status"></div>
                </div>
                <div class="description-title">Комментарий</div>
                <div class="description"></div>
            </div>
        </div>

        <div class="modal hidden" data-modal="update-review">
            <div class="modal-header mb-5 text-2xl">
                <div class="title text-1xl"></div>
                <div class="close-modal">
                    ✖
                </div>
            </div>
            <div class="modal-content scrollbar">
                <div class="input-group mb-2">
                    <label for="review-position" class="label black pb-1">
                        Позиция
                    </label>
                    <input id="review-position" type="text" class="input border border-theme-blue border-solid">
                </div>
            </div>
            <div class="modal-footer flex justify-end">
                <div class="btn bg-green mr-2" id="updateProductReview">
                    <span class="loader dark"></span>
                    Обновить
                </div>
            </div>
        </div>
    </div>
@endpush
