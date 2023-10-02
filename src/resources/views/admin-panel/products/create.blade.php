@extends('admin-panel.layouts.main')

@section('title', 'Новый товар')

@section('content')
    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
            <span>Общие сведения</span>
            <button href="{{ route('admin.products.create') }}"
                class="btn load-applications small-btn border-none">Добавить</button>
        </div>

        <div class="columns-1 flex justify-between mb-1 divide-x pb-2 text-white text-1xl">
            Категория
        </div>

        <div class="flex items-center mb-3">
            <select class="select mr-5 selected-category" class="select" name="parent_id" id="parent_id" @if ($category) disabled @endif>
                <option value="1">Родитель 1</option>
                @if ($category)
                    <option selected value="{{$category->id}}">{{$category->name}}</option>
                @else

                @endif
                @foreach ($categories as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
            <div class="category_list flex">
            </div>
        </div>

        <div class="columns-1 flex items-center justify-between mb-9 divide-x pb-2 text-white text-1xl border-b-2 border-b-white">
            <span>Список уникальных свойст</span>
            <span class="border-none text-3xl cursor-pointer">+</span>
        </div>

        <div class="main-container">
            <div class="container-category-property">

            </div>
        </div>

        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
            <span>Вариации товара</span>
            <div class="btn add-variant-product small-btn border-none">Добавить</div>
        </div>
        <div class="container-variant-products">

        </div>
    </form>
@endsection

@section('sidebar')
    <x-admin.sidebar.categories item_show="products" />
@endsection

@section('scripts')
    <script>
        const categories = <?php echo json_encode($categories); ?>;
    </script>
    @vite(['resources/js/pages/createProductPage.js'])
@endsection
