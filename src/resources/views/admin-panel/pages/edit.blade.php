@extends('admin-panel.layouts.main')

@section('title', $page->name)

@inject('service', 'App\Services\AdminPanel\SiteSettingService')

@section('content')
    <form enctype="multipart/form-data" action="{{ route('admin.page.update', ['page' => $page->id]) }}" method="POST">
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
        @method('PATCH')
        <div class="columns-1 flex mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
            <span>Общие сведения</span>
            <div class="flex border-none">
               @if ($page->is_show)
                    <div class="flex visible-page visible">
                        <input type="text" name="is_show" hidden value="1">
                    </div>
               @else
                    <div class="flex visible-page not-visible">
                        <input type="text" name="is_show" hidden value="0">
                    </div>
               @endif
            </div>
            <div class="flex border-none">
                @if ($page->is_track)
                    <div class="flex is-track track-icon">
                        <input type="text" name="is_track" hidden value="1">
                    </div>
                @else
                    <div class="flex is-track no-track-icon">
                        <input type="text" name="is_track" hidden value="0">
                    </div>
                @endif
            </div>
        </div>
        <div class="columns-3 mb-9">
            <div class="input-group">
                <label for="name" class="label flex">
                    <span>Название</span>
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    class="input"
                    value="{{ old('name') ?? $page->name }}"
                >
            </div>
            <div class="input-group">
                <label for="route" class="label">
                    Адрес в сети
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input
                    id="route"
                    name="route"
                    type="text"
                    class="input"
                    value="{{ old('route') ?? $page->route }}"
                >
            </div>
            <div class="input-group">
                <label for="title" class="label">
                    Название в сети
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input
                    id="title"
                    name="title"
                    type="text"
                    class="input"
                    value="{{ old('title') ?? $page->title }}"
                >
            </div>
        </div>
        <div class="columns-2 mb-9">
            <div class="input-group">
                <label for="description" class="label flex">
                    <span>Описание для seo</span>
                </label>
                <textarea id="description" class="input" name="description" rows="5" cols="33">{{ old('description') ?? $page->description }}</textarea>
            </div>
            <div class="input-group">
                <label for="keywords" class="label">
                    Ключевые слова для seo
                </label>
                <textarea id="keywords" name="keywords" class="input" name="story" rows="5" cols="33">{{ old('keywords') ?? $page->keywords }}</textarea>
            </div>
        </div>
        <div class="columns-2 mb-9">
            <div class="input-group">
                <label for="old_route" class="label flex">
                    <span>Старый адрес</span>
                </label>
                <input
                    id="old_route"
                    name="old_route"
                    type="text"
                    class="input"
                    value="{{ old('old_route') ?? $page->old_route }}"
                >
            </div>
            <div class="input-group">
                <label for="canonical_address" class="label">
                    Каноническая ссылка
                </label>
                <input
                    id="canonical_address"
                    name="canonical_address"
                    type="text"
                    class="input"
                    value="{{ old('canonical_address') ?? $page->canonical_address }}"
                >
            </div>
        </div>
        <div class="columns-1 mb-9">
            <div class="input-group">
                <label for="page_description" class="label">
                    <span>Описание страницы</span>
                    @if (!$service->getValueVariable('redaktor-tiny-url'))
                        <br>
                        <span class="mr-2">Подключите TinyMCE установив переменную 'redaktor-tiny-url'</span>
                    @endif
                </label>
                <textarea name="page_description" id="page_description" class="input" name="story" rows="5" cols="33">{{ old('page_description') ?? $page->page_description }}</textarea>
            </div>
        </div>
        <div class="columns-1 mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
            Open Graph
        </div>
        <div class="columns-3 mb-9">
            <div class="input-group">
                <label for="og_title" class="label">
                    Open Graph Заголовок
                </label>
                <input
                    id="og_title"
                    name="og_title"
                    type="text"
                    class="input"
                    value="{{ old('og_title') ?? $page->og_title }}"
                >
            </div>
            <div class="input-group">
                <label for="og_type" class="label">
                    Open Graph Тип
                </label>
                <input
                    id="og_type"
                    name="og_type"
                    type="text"
                    class="input"
                    value="{{ old('og_type') ?? $page->og_type }}"
                >
            </div>
            <div class="input-group">
                <label for="og_url" class="label">
                    Open Graph Адрес
                </label>
                <input
                    id="og_url"
                    name="og_url"
                    type="text"
                    class="input"
                    value="{{ old('og_url') ?? $page->og_url }}"
                >
            </div>
        </div>
        <div class="mb-9 flex justify-between columns-1">
            <div class="input-group w-full">
                <label for="og_description" class="label">
                    Open Graph Описание
                </label>
                <textarea id="og_description" class="input" name="og_description" rows="5" style="width: 100%">{{ old('og_description') ?? $page->og_description }}</textarea>
            </div>
        </div>
        <div class="columns-4 mb-9">
            <div class="input-group">
                <label for="og_image" class="label">
                    Картинка
                </label>
                @if ($page->og_image)
                    <div class="image-create-page" style="background-image: url('/storage/{{$page->og_image}}')">
                @else
                    <div class="image-create-page">
                @endif
                    <svg class="@if ($page->og_image) hidden @endif" xmlns="http://www.w3.org/2000/svg" width="173" height="173" viewBox="0 0 173 173"
                        fill="none">
                        <path
                            d="M64.8749 43.25C56.9458 43.25 50.4583 49.7375 50.4583 57.6667C50.4583 65.5958 56.9458 72.0833 64.8749 72.0833C72.8041 72.0833 79.2916 65.5958 79.2916 57.6667"
                            stroke="#9900FF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M14.4167 93.6362V108.125C14.4167 144.167 28.8334 158.583 64.8751 158.583H108.125C144.167 158.583 158.583 144.167 158.583 108.125V72.0833"
                            stroke="#9900FF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M93.7084 14.4167H64.8751C28.8334 14.4167 14.4167 28.8333 14.4167 64.875" stroke="#9900FF"
                            stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M113.531 36.0417H153.177" stroke="#9900FF" stroke-width="3" stroke-linecap="round" />
                        <path d="M133.354 55.8646V16.2188" stroke="#9900FF" stroke-width="3" stroke-linecap="round" />
                        <path
                            d="M19.2463 136.598L54.7834 112.738C60.478 108.918 68.6955 109.35 73.8134 113.748L76.1922 115.838C81.8147 120.668 90.8972 120.668 96.5197 115.838L126.506 90.1042C132.129 85.2746 141.211 85.2746 146.834 90.1042L158.583 100.196"
                            stroke="#9900FF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <input hidden id="og_image" type="file" class="input" name="og_image">
            </div>
            <div class="input-group">
                <label class="label">
                    Картинка Вконтакте
                </label>
                @if ($page->og_vk_image)
                    <div class="image-create-page" style="background-image: url('/storage/{{$page->og_vk_image}}')">
                @else
                    <div class="image-create-page">
                @endif
                    <svg class="@if ($page->og_vk_image) hidden @endif" xmlns="http://www.w3.org/2000/svg" width="173" height="173" viewBox="0 0 173 173"
                        fill="none">
                        <path
                            d="M64.8749 43.25C56.9458 43.25 50.4583 49.7375 50.4583 57.6667C50.4583 65.5958 56.9458 72.0833 64.8749 72.0833C72.8041 72.0833 79.2916 65.5958 79.2916 57.6667"
                            stroke="#9900FF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M14.4167 93.6362V108.125C14.4167 144.167 28.8334 158.583 64.8751 158.583H108.125C144.167 158.583 158.583 144.167 158.583 108.125V72.0833"
                            stroke="#9900FF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M93.7084 14.4167H64.8751C28.8334 14.4167 14.4167 28.8333 14.4167 64.875" stroke="#9900FF"
                            stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M113.531 36.0417H153.177" stroke="#9900FF" stroke-width="3" stroke-linecap="round" />
                        <path d="M133.354 55.8646V16.2188" stroke="#9900FF" stroke-width="3" stroke-linecap="round" />
                        <path
                            d="M19.2463 136.598L54.7834 112.738C60.478 108.918 68.6955 109.35 73.8134 113.748L76.1922 115.838C81.8147 120.668 90.8972 120.668 96.5197 115.838L126.506 90.1042C132.129 85.2746 141.211 85.2746 146.834 90.1042L158.583 100.196"
                            stroke="#9900FF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <input hidden type="file" class="input" name="og_vk_image">
            </div>
            <div class="input-group">
                <label class="label">
                    Картинка Facebook
                </label>
                @if ($page->og_fb_image)
                    <div class="image-create-page" style="background-image: url('/storage/{{$page->og_fb_image}}')">
                @else
                    <div class="image-create-page">
                @endif
                    <svg class="@if ($page->og_fb_image) hidden @endif" xmlns="http://www.w3.org/2000/svg" width="173" height="173" viewBox="0 0 173 173"
                        fill="none">
                        <path
                            d="M64.8749 43.25C56.9458 43.25 50.4583 49.7375 50.4583 57.6667C50.4583 65.5958 56.9458 72.0833 64.8749 72.0833C72.8041 72.0833 79.2916 65.5958 79.2916 57.6667"
                            stroke="#9900FF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M14.4167 93.6362V108.125C14.4167 144.167 28.8334 158.583 64.8751 158.583H108.125C144.167 158.583 158.583 144.167 158.583 108.125V72.0833"
                            stroke="#9900FF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M93.7084 14.4167H64.8751C28.8334 14.4167 14.4167 28.8333 14.4167 64.875" stroke="#9900FF"
                            stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M113.531 36.0417H153.177" stroke="#9900FF" stroke-width="3" stroke-linecap="round" />
                        <path d="M133.354 55.8646V16.2188" stroke="#9900FF" stroke-width="3" stroke-linecap="round" />
                        <path
                            d="M19.2463 136.598L54.7834 112.738C60.478 108.918 68.6955 109.35 73.8134 113.748L76.1922 115.838C81.8147 120.668 90.8972 120.668 96.5197 115.838L126.506 90.1042C132.129 85.2746 141.211 85.2746 146.834 90.1042L158.583 100.196"
                            stroke="#9900FF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <input hidden type="file" class="input" name="og_fb_image">
            </div>
            <div class="input-group">
                <label class="label">
                    Картинка Twitter
                </label>
                @if ($page->og_twitter_image)
                    <div class="image-create-page" style="background-image: url('/storage/{{$page->og_twitter_image}}')">
                @else
                    <div class="image-create-page">
                @endif
                    <svg class="@if ($page->og_twitter_image) hidden @endif" xmlns="http://www.w3.org/2000/svg" width="173" height="173" viewBox="0 0 173 173"
                        fill="none">
                        <path
                            d="M64.8749 43.25C56.9458 43.25 50.4583 49.7375 50.4583 57.6667C50.4583 65.5958 56.9458 72.0833 64.8749 72.0833C72.8041 72.0833 79.2916 65.5958 79.2916 57.6667"
                            stroke="#9900FF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M14.4167 93.6362V108.125C14.4167 144.167 28.8334 158.583 64.8751 158.583H108.125C144.167 158.583 158.583 144.167 158.583 108.125V72.0833"
                            stroke="#9900FF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M93.7084 14.4167H64.8751C28.8334 14.4167 14.4167 28.8333 14.4167 64.875" stroke="#9900FF"
                            stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M113.531 36.0417H153.177" stroke="#9900FF" stroke-width="3" stroke-linecap="round" />
                        <path d="M133.354 55.8646V16.2188" stroke="#9900FF" stroke-width="3" stroke-linecap="round" />
                        <path
                            d="M19.2463 136.598L54.7834 112.738C60.478 108.918 68.6955 109.35 73.8134 113.748L76.1922 115.838C81.8147 120.668 90.8972 120.668 96.5197 115.838L126.506 90.1042C132.129 85.2746 141.211 85.2746 146.834 90.1042L158.583 100.196"
                            stroke="#9900FF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <input hidden type="file" class="input" name="og_twitter_image" @if ($page->og_twitter_image) value="{{$page->og_twitter_image}}" @endif>
            </div>
        </div>
        <div class="flex">
            <button type="submit" class="btn bg-green ml-auto">
                <span class="icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="vuesax/broken/additem">
                            <g id="additem">
                                <path id="Vector" d="M2 5.43C2 3.14 3.14 2 5.43 2H10C12.29 2 13.43 3.14 13.43 5.43"
                                    stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path id="Vector_2" d="M8 16H5.43C3.14 16 2 14.86 2 12.57V9.98001" stroke="white"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path id="Vector_3"
                                    d="M18.5701 22H14.0001C11.7101 22 10.5701 20.86 10.5701 18.57V11.43C10.5701 9.14 11.7101 8 14.0001 8H18.5701C20.8601 8 22.0001 9.14 22.0001 11.43V18.57C22.0001 20.86 20.8601 22 18.5701 22Z"
                                    stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path id="Vector_4" d="M14.8701 15H18.1301" stroke="white" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path id="Vector_5" d="M16.5 16.63V13.37" stroke="white" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </g>
                        </g>
                    </svg>
                </span>
                Обновить
            </button>
        </div>
        @isSuperAdmin
            1
        @endIsSuperAdmin
    </form>
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

@section('sidebar')
    <x-admin.sidebar.pages />
@endsection


@section('scripts')
    @if ($service->getValueVariable('redaktor-tiny-url'))
        <script src="{{ $service->getValueVariable('redaktor-tiny-url') }}" referrerpolicy="origin"></script>
    @endif
    @vite(['resources/js/pages/createNewPage.js'])
@endsection
