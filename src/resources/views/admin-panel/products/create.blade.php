@extends('admin-panel.layouts.main')

@section('title', 'Новый товар')

@section('content')
    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
            <span>Общие сведения</span>
            <button href="{{route('admin.products.create')}}" class="btn load-applications small-btn border-none">Добавить</button>
        </div>



        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
            <span>Вариации товара</span>
            <button href="{{route('admin.products.create')}}" class="btn load-applications small-btn border-none">Добавить</button>
        </div>
    </form>
@endsection

@section('sidebar')
    <x-admin.sidebar.categories item_show="products" />
@endsection
