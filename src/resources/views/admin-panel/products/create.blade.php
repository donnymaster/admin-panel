@extends('admin-panel.layouts.main')

@section('title', 'Новый товар')

@inject('service', 'App\Services\AdminPanel\SiteSettingService')

@section('content')
    <form action="{{route('admin.products.store')}}" method="POST" enctype="multipart/form-data" id="formCreateProduct">
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
            {{session()->get('successfully')}}
            </div>
        @endif
        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
            <span>Общие сведения</span>
            <button
                href="{{ route('admin.products.create') }}"
                class="btn load-applications small-btn border-none"
            >
                Добавить
            </button>
        </div>

        <div class="columns-3 mb-9">
            <div class="input-group">
                <label for="name" class="label flex">
                    <span>Название</span>
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input required id="name" name="name" type="text" class="input" value="{{old('name')}}">
            </div>
            <div class="input-group">
                <label for="slug" class="label">
                    Адрес в сети
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input required id="slug" name="slug" type="text" class="input" value="{{old('slug')}}">
            </div>
            <div class="input-group">
                <label for="page_title" class="label">
                    Заголовок страницы
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input required id="page_title" name="page_title" type="text" class="input" value="{{old('page_title')}}">
            </div>
        </div>
        <div class="columns-2 mb-9">
            <div class="input-group">
                <label for="name_tile" class="label">
                    Название на плитку
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="name_tile" name="name_tile" type="text" class="input" value=""{{old('name_tile')}}>
            </div>
            <div class="input-group">
                <label for="vendor_code" class="label">
                    Артикул
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input required id="vendor_code" name="vendor_code" type="text" class="input" value="{{old('vendor_code')}}">
            </div>
        </div>

        <div class="columns-1 mb-9">
            <div class="input-group">
                <label for="page_description" class="label">
                    Описание страницы
                    @if (!$service->getValueVariable('redaktor-tiny-url'))
                        <br>
                        Подключите TinyMCE установив переменную 'redaktor-tiny-url'
                    @endif
                </label>
                <textarea name="page_description" id="page_description" class="input" name="story" rows="5" cols="33">{{old('page_description')}}</textarea>
            </div>
        </div>

        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-2xl border-b-2 border-b-white">
            <span>SEO</span>
        </div>

        <div class="columns-2 mb-9">
            <div class="input-group">
                <label for="keywords" class="label flex">
                    <span>Ключевые слова</span>
                </label>
                <input id="keywords" name="keywords" type="text" class="input" value="{{old('keywords')}}">
            </div>
            <div class="input-group">
                <label for="description" class="label">
                    Описание
                </label>
                <input id="description" name="description" type="text" class="input" value="{{old('description')}}">
            </div>
        </div>

        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-2xl border-b-2 border-b-white">
            <span>Уникальные свойства (<span class="product-unique-property-count">0</span>)</span>
            <div class="btn add-product-unique-property small-btn border-none">
                Добавить
            </div>
        </div>
        <div class="container-product-unique-property mb-4">
        </div>

        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-2xl border-b-2 border-b-white">
            <span>Категория</span>
        </div>

        <div class="flex items-center mb-3">
            <select class="select mr-5 selected-category" class="select" name="parent_id" id="parent_id" @if ($category) disabled @endif>
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

        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-2xl border-b-2 border-b-white">
            <span>Вариации товара (<span class="variant-product-count">0</span>)</span>
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

    @if ($service->getValueVariable('redaktor-tiny-url'))
        <script src="{{ $service->getValueVariable('redaktor-tiny-url') }}" referrerpolicy="origin"></script>
    @endif

    @if ($service->getValueVariable('redaktor-tiny-url'))
        <script>
            tinymce.init({
                selector: '#page_description',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight numlist bullist indent outdent | emoticons charmap | removeformat',
            });
        </script>
    @endif
@endsection
