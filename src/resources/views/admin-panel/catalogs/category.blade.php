@extends('admin-panel.layouts.main')

@section('title', $category->name)

@section('content')
    <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
        <span>Информация о категории</span>
        <div class="btn load-applications small-btn border-none">Обновить</div>
    </div>
    <form action="#">
        <div class="columns-4 mb-9">
            <div class="input-group">
                <label for="page_name" class="label flex">
                    <span>Название</span>
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="page_name" value="{{ $category->name }}" name="name" type="text"
                    class="input @error('name') is-invalid @enderror">
                @error('name')
                    <div class="alert-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label for="route" class="label">
                    Slug
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="route" value="{{ $category->slug }}" name="route" type="text"
                    class="input @error('route') is-invalid @enderror">
                @error('route')
                    <div class="alert-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label for="title" class="label">
                    Позиция
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="title" value="{{ $category->position }}" name="title" type="text"
                    class="input @error('title') is-invalid @enderror">
                @error('title')
                    <div class="alert-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label for="title" class="label">
                    Название страницы
                    <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                </label>
                <input id="title" value="{{ $category->page_title }}" name="title" type="text"
                    class="input @error('title') is-invalid @enderror">
                @error('title')
                    <div class="alert-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="columns-1 mb-9">
            <div class="flex flex-col">
                <label for="parent-id" class="mb-4">Родительская категория</label>
                <select name="parent" id="parent-id">
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $category->parent_id ? 'selected' : null }}>
                            {{ $item->name }}</option>
                    @endforeach

                    @if ($category->parent_id)
                        <option value="0">Отсутсвует</option>
                    @else
                        <option selected value="0">Отсутсвует</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="columns-2 mb-9">
            <div class="input-group">
                <label for="description" class="label flex">
                    <span> Ключевые слова для seo</span>
                </label>
                <textarea id="description" class="input" name="description" rows="5" cols="33"></textarea>
            </div>
            <div class="input-group">
                <label for="keywords" class="label">
                    Описание для seo
                </label>
                <textarea id="keywords" name="keywords" class="input" name="story" rows="5" cols="33"></textarea>
            </div>
        </div>
        <div class="columns-1 mb-9">
            <div class="input-group">
                <label for="old_route" class="label flex">
                    <span>Описание страницы</span>
                </label>
                <textarea id="keywords" name="keywords" class="input" name="story" rows="5" cols="33"></textarea>
            </div>
        </div>
    </form>
    <div class="columns-1 flex justify-between mt-9 mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
        <span>Свойства категории</span>
        <div class="btn load-applications small-btn border-none">Добавить</div>
    </div>

    {{ $dataTable->table() }}

    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endsection


@section('sidebar')
    <x-admin.sidebar.categories item_show="categories" />
@endsection
