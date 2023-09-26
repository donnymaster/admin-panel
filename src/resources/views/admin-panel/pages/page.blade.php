@extends('admin-panel.layouts.main')

@section('title', 'Страницы')

@section('content')
    <div class="flex text-2xl text-white mb-5">
        <div class="title mr-5">
            Статистика по Страницам
        </div>
        <div class="flex">
            <div class="date-start mr-4 flex items-center">
                <span class="mr-2 text-sm">Начало</span>
                <input type="date" class="date" name="date-start-application">
            </div>
            <div class="date-end mr-4 flex items-center">
                <span class="mr-2 text-sm">Конец</span>
                <input type="date" class="date" name="date-end-application">
            </div>
            <div class="btn load-applications small-btn">Обновить</div>
        </div>
        <a href="{{ route('admin.page.create') }}" class="btn bg-green mr-2 small-btn ml-auto">
            Добавить
        </a>
    </div>
    <div class="flex w-full mt-5 mb-5">
        <select name="demo-2" id="demo-2" placeholder="This is a placeholder" multiple>
            <option value="Dropdown item 1">Dropdown item 1</option>
            <option value="Dropdown item 2">Dropdown item 2</option>
            <option value="Dropdown item 3" selected>Dropdown item 3</option>
          </select>
    </div>
    <canvas id="line-chart" style="width: 100%" class="bg-white rounded-3xl" height="450"></canvas>

    <div class="flex mt-10 mb-5 text-2xl text-white">
        Статистика по страницам
    </div>

    {{ $dataTable->table() }}


    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endsection

@section('sidebar')
    <x-admin.sidebar.pages />
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/js/pages/statisticPage.js'])
@endsection
