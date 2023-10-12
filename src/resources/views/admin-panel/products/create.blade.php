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
            <div class="flex product-types">
                <div class="product-type product-new">
                    <span>Новый</span>
                    <div class="checkbox">
                        @if (old('product-type-new'))
                            <input class="custom-checkbox" checked id="new" type="checkbox" name="product-type-new">
                        @elseif($errors->any())
                            <input class="custom-checkbox" @if (old('product-type-new')) checked @endif id="new" type="checkbox" name="product-type-new">
                        @else
                            <input class="custom-checkbox" id="new" type="checkbox" name="product-type-new">
                        @endif
                        <label for="new"></label>
                    </div>
                </div>
                <div class="product-type product-top-sellers">
                    <span>Топ продаж</span>
                    <div class="checkbox">
                        @if (old('product-type-top-sellers'))
                            <input class="custom-checkbox" checked id="top-sellers" type="checkbox" name="product-type-top-sellers">
                        @elseif($errors->any())
                            <input class="custom-checkbox" @if (old('product-type-top-sellers')) checked @endif id="top-sellers" type="checkbox" name="product-type-top-sellers">
                        @else
                            <input class="custom-checkbox" id="top-sellers" type="checkbox" name="product-type-top-sellers">
                        @endif
                        <label for="top-sellers"></label>
                    </div>
                </div>
                <div class="product-type product-popular">
                    <span>Популярный</span>
                    <div class="checkbox">
                        @if (old('product-type-popular'))
                            <input class="custom-checkbox" checked id="popular" type="checkbox" name="product-type-popular">
                        @elseif($errors->any())
                            <input class="custom-checkbox" @if (old('product-type-popular')) checked @endif id="popular" type="checkbox" name="product-type-popular">
                        @else
                            <input class="custom-checkbox" id="popular" type="checkbox" name="product-type-popular">
                        @endif
                        <label for="popular"></label>
                    </div>
                </div>

                @if (old('visible'))
                    <div class="flex visible-product visible">
                        <input type="text" name="visible" hidden>
                    </div>
                @elseif ($errors->any())
                    <div class="flex visible-product not-visible">
                        <input type="text" name="visible" hidden>
                    </div>
                @else
                    <div class="flex visible-product not-visible">
                        <input type="text" name="visible" hidden value="0">
                    </div>
                @endif

            </div>
            <button
                href="{{ route('admin.products.create') }}"
                class="btn load-applications small-btn border-none"
            >
                Добавить
            </button>
        </div>

        <div class="columns-3 mb-9">
            <div class="input-group">
                <label for="title" class="label flex">
                    <span>Название</span>
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                @if ($parent)
                    <input  id="title" name="title" type="text" class="input convert-parent" value="{{old('title') ? old('title') : $parent->title}}" data-child="slug-convert">
                @else
                    <input  id="title" name="title" type="text" class="input convert-parent" value="{{old('title')}}" data-child="slug-convert">
                @endif
            </div>
            <div class="input-group">
                <label for="slug" class="label">
                    Адрес в сети
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                @if ($parent)
                    <input  id="slug" name="slug" type="text" class="input slug-convert" value="{{old('slug') ? old('slug') : $parent->slug}}">
                @else
                    <input  id="slug" name="slug" type="text" class="input slug-convert" value="{{old('slug')}}">
                @endif
            </div>
            <div class="input-group">
                <label for="page_title" class="label">
                    Заголовок страницы
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                @if ($parent)
                    <input  id="page_title" name="page_title" type="text" class="input" value="{{old('page_title') ? old('page_title') : $parent->page_title}}">
                @else
                    <input  id="page_title" name="page_title" type="text" class="input" value="{{old('page_title')}}">
                @endif
            </div>
        </div>
        <div class="columns-3 mb-9">
            <div class="input-group">
                <label for="name_tile" class="label">
                    Название на плитку
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                @if ($parent)
                    <input id="name_tile" name="name_tile" type="text" class="input" value="{{old('name_tile') ? old('name_tile') : $parent->name_tile}}">
                @else
                    <input id="name_tile" name="name_tile" type="text" class="input" value=""{{old('name_tile')}}>
                @endif
            </div>
            <div class="input-group">
                <label for="vendor_code" class="label">
                    Артикул
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                @if ($parent)
                    <input id="vendor_code" name="vendor_code" type="text" class="input" value="{{old('vendor_code') ? old('vendor_code') : $parent->vendor_code}}">
                @else
                    <input  id="vendor_code" name="vendor_code" type="text" class="input" value="{{old('vendor_code')}}">
                @endif
            </div>
            <div class="input-group">
                <label for="position_in_category" class="label">
                    Позиция
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="position_in_category" value="1" name="position_in_category" type="number" class="input">
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
                <textarea name="page_description" id="page_description" class="input" name="story" rows="5" cols="33">
                    @if ($parent)
                        {{old('page_description') ? old('page_description') : $parent->page_description}}
                    @else
                        {{old('page_description')}}
                    @endif
                    {{old('page_description')}}
                </textarea>
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
                @if ($parent)
                    <textarea id="keywords" class="input" name="keywords" rows="5" cols="33">{{old('keywords') ? old('keywords') : $parent->keywords}}</textarea>
                @else
                    <textarea id="keywords" class="input" name="keywords" rows="5" cols="33">{{old('keywords')}}</textarea>
                @endif
            </div>
            <div class="input-group">
                <label for="description" class="label">
                    Описание
                </label>
                @if ($parent)
                    <textarea id="description" class="input" name="description" rows="5" cols="33">{{old('description') ? old('description') : $parent->description}}</textarea>
                @else
                    <textarea id="description" class="input" name="description" rows="5" cols="33">{{old('description')}}</textarea>
                @endif
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
            <select class="select mr-5 selected-category" class="select" name="category_id" id="category_id">
                @if ($category)
                    <option selected value="{{$category->id}}">{{$category->name}}</option>
                @endif
                @foreach ($categories as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
            <div class="category_list flex">
            </div>
        </div>

        <div style="display: none" class="columns-1 flex items-center justify-between mb-9 divide-x pb-2 text-white text-1xl border-b-2 border-b-white">
            <span>Список уникальных свойст</span>
            <span class="border-none text-3xl cursor-pointer">+</span>
        </div>

        <div style="display: none" class="main-container">
            <div class="container-category-property">

            </div>
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
                language_url: '/vendor/tinymce/lang/ru.js',
                language: 'ru',
            });
        </script>
    @endif
@endsection
