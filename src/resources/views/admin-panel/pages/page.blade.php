@extends('admin-panel.layouts.main')

@section('title', 'Страницы')

@section('content')
    <div class="flex text-2xl text-white mb-5">
        <div class="title mr-5">
            Статистика по Страницам
        </div>
        <a href="{{ route('admin.page.create') }}" class="btn bg-green mr-2 small-btn ml-auto">
            Добавить
        </a>
    </div>
    <div class="flex flex-col w-full mt-5 mb-5 items-start">
        <div class="flex mb-4 items-center">
            <div class="flex mr-4 text-xl text-white">
                Диапазон
            </div>
        <div class="flex">
            <div class="date-start mr-4 flex items-center">
                <span class="mr-2 text-sm">Начало</span>
                <input type="date" id="startDate" class="date" name="date-start-application">
            </div>
            <div class="date-end mr-4 flex items-center">
                <span class="mr-2 text-sm">Конец</span>
                <input type="date" id="endDate" class="date" name="date-end-application">
            </div>
        </div>
        </div>
        <div class="flex flex-col mb-5 w-full">
            <div class="flex text-xl text-white mb-4">
                Страницы
            </div>
            <span class="loader" id="loadingChoicePages"></span>
            <div class="empty-data-pages text-xl text-white hidden">Данные отсутствуют!</div>
            <div class="flex w-full">
               <select id="selected-pages" class="hidden" multiple>
               </select>
            </div>
        </div>
        <div class="btn update-applications bg-green small-btn">Обновить</div>
    </div>
    <div class="flex bg-white rounded-3xl" style="width: 100%;">
        <canvas id="line-chart" class="hidden" style="width: 100%;"></canvas>
        <div class="empty-data-chart text-xl text-black p-9 text-center hidden w-full">Данные отсутствуют!</div>
        <div id="loadingChartPages" class="loading-data flex items-center w-full h-24 justify-center">
            <span class="loader dark"></span>
        </div>
    </div>

    <div class="flex mt-10 mb-5 text-2xl text-white items-center">
        <span class="mr-3">Статистика по страницам</span>
        <div class="text-xl flex remove-history-pages">
            <div data-type="all" class="btn bg-green mr-2 small-btn ml-auto">
                Очистить
            </div>
            <div data-type="30days" class="btn bg-green mr-2 small-btn ml-auto">
                Очистить за последние 30 дней
            </div>
        </div>
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
