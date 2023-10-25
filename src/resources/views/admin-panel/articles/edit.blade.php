@extends('admin-panel.layouts.main')

@section('title', $article->title)

@section('content')
    <form action="{{ route('admin.articles.update', ['article' => $article->id]) }}" method="POST">
        @csrf
        @method('PATCH')
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
            <div class="flex">
                <span>Общие сведения</span>
                <div>
                    @if ($article->visible)
                        <div class="flex visible-article visible">
                            <input type="text" name="visible" hidden value="1">
                        </div>
                    @else
                        <div class="flex visible-article not-visible">
                            <input type="text" name="visible" hidden value="0">
                        </div>
                    @endif
                </div>
            </div>
            <button type="submit" class="btn load-applications small-btn border-none">Обновить</button>
        </div>

        <div class="columns-3 mb-9">
            <div class="input-group">
                <label for="title" class="label flex">
                    <span>Загловок</span>
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="title" name="title" type="text" class="input" value="{{ old('title') ?? $article->title }}">
            </div>
            <div class="input-group">
                <label for="time_read" class="label">
                    Время на чтение
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="time_read" name="time_read" type="text" class="input" value="{{ old('time_read') ?? $article->time_read }}">
            </div>
            <div class="input-group">
                <label class="label">
                    Автор
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input disabled value="{{ $article->user->name }}" type="text" class="input">
            </div>
        </div>
        <div class="columns-1 mb-9">
            <div class="input-group">
                <label for="tiny_description" class="label">
                    Краткое описание
                    <x-admin.tinymce.message />
                </label>
                <textarea name="tiny_description" id="tiny_description" class="input" rows="5" cols="33">{{ old('tiny_description') ?? $article->tiny_description }}</textarea>
            </div>
        </div>
        <div class="columns-1 mb-9">
            <div class="input-group">
                <label for="description" class="label">
                    Полное описание
                    <x-admin.tinymce.message />
                </label>
                <textarea name="description" id="description" class="input" rows="5" cols="33">{{ old('description') ?? $article->description }}</textarea>
            </div>
        </div>
    </form>

    <x-admin.tinymce.setting />
    @vite(['resources/js/pages/createArticlePage.js'])
@endsection

@section('sidebar')
    <x-admin.sidebar.statistics item_show="articles" />
@endsection


@section('scripts')
    <x-admin.tinymce.script />
@endsection
