@extends('admin-panel.layouts.main')

@section('title', 'Категории')

@section('content')
    <div class="drop-down-list-container">
        <div class="drop-down-parent">
            <div class="drop-down-title">
                <div class="icon">+</div>
                <div class="title">Категории</div>
            </div>
            <div class="drop-down-child">
                <div class="drop-down-title">
                    <div class="icon">+</div>
                    <div class="title">Коляски</div>
                </div>
                <div class="drop-down-child">
                    <div class="drop-down-title">
                        <div class="icon">+</div>
                        <div class="title">Коляски для взрослых</div>
                    </div>
                </div>
            </div>
            <div class="drop-down-child">
                <div class="drop-down-title">
                    <div class="icon">+</div>
                    <div class="title">Детское питание</div>
                </div>
            </div>
            <div class="drop-down-child">
                <div class="drop-down-title">
                    <div class="icon">+</div>
                    <div class="title">Подгузники</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('sidebar')
    <x-admin.sidebar.categories />
@endsection
