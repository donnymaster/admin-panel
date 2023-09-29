@extends('admin-panel.layouts.main')

@section('title', 'Новая категория')

@inject('service', 'App\Services\AdminPanel\SiteSettingService')

@section('content')
    <form action="#" method="POST" enctype="multipart/form-data">
        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
            <span>Общие сведения</span>
            <button type="submit" class="btn load-applications small-btn border-none">Добавить</button>
        </div>
        <div class="columns-4 mb-9">
            <div class="input-group">
                <label for="page_name" class="label flex">
                    <span>Название</span>
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="page_name" name="name" type="text" class="input @error('name') is-invalid @enderror">
                @error('name')
                    <div class="alert-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label for="route" class="label">
                    Адрес в сети
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="route" name="route" type="text" class="input @error('route') is-invalid @enderror">
                @error('route')
                    <div class="alert-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label for="title" class="label">
                    Позиция
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="title" name="title" type="text" class="input @error('title') is-invalid @enderror">
                @error('title')
                    <div class="alert-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label for="page_name" class="label flex">
                    <span>загловок</span>
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="page_name" name="name" type="text" class="input @error('name') is-invalid @enderror">
                @error('name')
                    <div class="alert-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="columns-2 mb-9">
            <div class="input-group">
                <label for="description" class="label flex">
                    <span>Описание для seo</span>
                </label>
                <textarea id="description" class="input" name="description" rows="5" cols="33"></textarea>
            </div>
            <div class="input-group">
                <label for="keywords" class="label">
                    Ключевые слова для seo
                </label>
                <textarea id="keywords" name="keywords" class="input" name="story" rows="5" cols="33"></textarea>
            </div>
        </div>
        <div class="columns-1 mb-9">
            <div class="input-group">
                <label for="email" class="label">
                    Описание страницы
                    @if (!$service->getValueVariable('redaktor-tiny-url'))
                        <br>
                        Подключите TinyMCE установив переменную 'redaktor-tiny-url'
                    @endif
                </label>
                <textarea name="page_description" id="page_description" class="input" name="story" rows="5" cols="33"></textarea>
            </div>
        </div>
        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
            <span>Свойства</span>
            <div class="btn add-property small-btn border-none">Добавить</div>
        </div>
    </form>
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


@section('sidebar')
    <x-admin.sidebar.categories item_show="categories" />
@endsection

@section('scripts')
    @vite(['resources/js/pages/createCategoryPage.js'])
    @if ($service->getValueVariable('redaktor-tiny-url'))
        <script src="{{ $service->getValueVariable('redaktor-tiny-url') }}" referrerpolicy="origin"></script>
    @endif
@endsection
