@extends('admin-panel.layouts.main')

@section('title', 'Доска')

@inject('menuService', 'App\Services\AdminPanel\MenuService')
@inject('statisticService', 'App\Services\AdminPanel\StatisticService')

@section('content')
    <div class="statistic-cards flex mb-8">
        <div class="statistics-card">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 96 96" fill="none">
                    <path
                        d="M72.0004 28.64C71.7604 28.6 71.4804 28.6 71.2404 28.64C65.7204 28.44 61.3204 23.92 61.3204 18.32C61.3204 12.6 65.9204 8 71.6404 8C77.3604 8 81.9604 12.64 81.9604 18.32C81.9204 23.92 77.5204 28.44 72.0004 28.64Z"
                        stroke="#9900FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M67.8816 57.7608C73.3616 58.6808 79.4016 57.7208 83.6416 54.8808C89.2816 51.1208 89.2816 44.9608 83.6416 41.2008C79.3616 38.3606 73.2416 37.4006 67.7616 38.3606"
                        stroke="#9900FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M23.8819 28.64C24.1219 28.6 24.4019 28.6 24.6419 28.64C30.1619 28.44 34.5619 23.92 34.5619 18.32C34.5619 12.6 29.9619 8 24.2419 8C18.5219 8 13.9219 12.64 13.9219 18.32C13.9619 23.92 18.3619 28.44 23.8819 28.64Z"
                        stroke="#9900FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M28.0017 57.7608C22.5217 58.6808 16.4817 57.7208 12.2417 54.8808C6.60172 51.1208 6.60172 44.9608 12.2417 41.2008C16.5217 38.3606 22.6417 37.4006 28.1217 38.3606"
                        stroke="#9900FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M48.0004 58.5208C47.7604 58.4808 47.4804 58.4808 47.2404 58.5208C41.7204 58.3208 37.3203 53.8008 37.3203 48.2008C37.3203 42.4808 41.9204 37.8808 47.6404 37.8808C53.3604 37.8808 57.9604 42.5208 57.9604 48.2008C57.9204 53.8008 53.5204 58.3608 48.0004 58.5208Z"
                        stroke="#9900FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M59.6388 71.1216C53.2788 66.8816 42.7588 66.8816 36.3589 71.1216C30.7189 74.8816 30.7189 81.0412 36.3589 84.8012C42.7588 89.0812 53.2388 89.0812 59.6388 84.8012"
                        stroke="#9900FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div class="value">
                {{$statisticService::getUniqueVisitors()}}
            </div>
            <div class="name">
                посетителей
            </div>
        </div>

        @if ($menuService->checkVisibleByPageName('admin.orders'))
            <div class="statistics-card">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 96 96" fill="none">
                        <path d="M19 55.88C18.44 62.4 23.6 68 30.16 68H72.76C78.52 68 83.56 63.2801 84 57.5601L86.16 27.5601C86.64 20.9201 81.6 15.52 74.92 15.52H23.28" stroke="#9900FF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8 8H14.96C19.28 8 22.68 11.72 22.32 16L20.32 40.2" stroke="#9900FF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M65 88C67.7614 88 70 85.7614 70 83C70 80.2386 67.7614 78 65 78C62.2386 78 60 80.2386 60 83C60 85.7614 62.2386 88 65 88Z" stroke="#9900FF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M33 88C35.7614 88 38 85.7614 38 83C38 80.2386 35.7614 78 33 78C30.2386 78 28 80.2386 28 83C28 85.7614 30.2386 88 33 88Z" stroke="#9900FF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M36 32H84" stroke="#9900FF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                </div>
                <div class="value">
                    -
                </div>
                <div class="name">
                    Заказов
                </div>
            </div>
        @endif

        @if ($menuService->checkVisibleByPageName('admin.applications'))
            <div class="statistics-card">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 96 96" fill="none">
                        <path d="M37.56 24.04C38.28 25.04 38.8 25.96 39.16 26.84C39.52 27.68 39.72 28.52 39.72 29.28C39.72 30.24 39.44 31.2 38.88 32.12C38.36 33.04 37.6 34 36.64 34.96L33.6 38.12C33.16 38.56 32.96 39.08 32.96 39.72C32.96 40.04 33 40.32 33.08 40.64C33.2 40.96 33.32 41.2 33.4 41.44C34.12 42.76 35.36 44.48 37.12 46.56C38.92 48.64 40.84 50.76 42.92 52.88C45.08 55 47.16 56.96 49.28 58.76C51.36 60.52 53.08 61.72 54.44 62.44C54.64 62.52 54.88 62.64 55.16 62.76C55.48 62.88 55.8 62.92 56.16 62.92C56.84 62.92 57.36 62.68 57.8 62.24L60.84 59.24C61.84 58.24 62.8 57.48 63.72 57C64.64 56.44 65.56 56.16 66.56 56.16C67.32 56.16 68.12 56.32 69 56.68C69.88 57.04 70.8 57.56 71.8 58.24L85.04 67.64C86.08 68.36 86.8 69.2 87.24 70.2C87.64 71.2 87.88 72.2 87.88 73.32C87.88 74.76 87.56 76.24 86.88 77.68C86.2 79.12 85.32 80.48 84.16 81.76C82.2 83.92 80.04 85.48 77.6 86.48C75.2 87.48 72.6 88 69.8 88C65.72 88 61.36 87.04 56.76 85.08C52.16 83.12 47.56 80.48 43 77.16C38.4 73.8 34.04 70.08 29.88 65.96C25.76 61.8 22.04 57.44 18.72 52.88C15.44 48.32 12.8 43.76 10.88 39.24C8.96 34.68 8 30.32 8 26.16C8 23.44 8.48 20.84 9.44 18.44C10.4 16 11.92 13.76 14.04 11.76C16.6 9.24 19.4 8 22.36 8C23.48 8 24.6 8.24 25.6 8.72C26.64 9.2 27.56 9.92 28.28 10.96" stroke="#9900FF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                </div>
                <div class="value">
                    {{$statisticService::getCountApplication()}}
                </div>
                <div class="name">
                    Заявок
                </div>
            </div>
        @endif
    </div>

        @if ($menuService->checkVisibleByPageName('admin.applications'))
        <div class="flex text-2xl text-white mb-5">
            <div class="title mr-5">
                Статистика по Заявкам за последние 30 дней
            </div>
            <div class="flex">
                <div class="date-start mr-4 flex items-center">
                    <span class="mr-2 text-sm">Начало</span>
                    <input type="date" class="date" name="date-start-application" value="{{$applicationPeriod['min']}}" min="{{$applicationPeriod['min']}}" max="{{$applicationPeriod['max']}}">
                </div>
                <div class="date-end mr-4 flex items-center">
                    <span class="mr-2 text-sm">Конец</span>
                    <input type="date" class="date" name="date-end-application" value="{{$applicationPeriod['max']}}" min="{{$applicationPeriod['min']}}" max="{{$applicationPeriod['max']}}">
                </div>
                <div class="btn load-applications small-btn">Обновить</div>
            </div>
        </div>
            <div class="flex mb-8">
                <div style="width: 100%; height: 250px" class="bg-white rounded-3xl">
                    <canvas id="applicationsStatistics" class="hidden"></canvas>
                    <div id="loadingApplication" class="loading-data flex items-center w-full justify-center h-full">
                        <span class="loader dark"></span>
                    </div>
                </div>
            </div>
        @endif

        @if ($menuService->checkVisibleByPageName('admin.orders'))
            <div class="flex text-2xl text-white mb-5">
                <div class="title mr-5">
                    Статистика по Заказам за последние 30 дней
                </div>
                <div class="flex">
                    <div class="date-start mr-4 flex items-center">
                        <span class="mr-2 text-sm">Начало</span>
                        <input type="date" class="date" name="date-start" id="">
                    </div>
                    <div class="date-end mr-4 flex items-center">
                        <span class="mr-2 text-sm">Конец</span>
                        <input type="date" class="date" name="date-end" id="">
                    </div>
                    <div class="btn load-orders small-btn">Обновить</div>
                </div>
            </div>
            <div class="flex mb-8">
                <div style="width: 100%; height: 250px" class="bg-white rounded-3xl">
                    <canvas id="ordersStatistics"></canvas>
                </div>
            </div>
        @endif

        @if ($menuService->checkVisibleByPageName('admin.reviews'))
            <div class="flex text-2xl text-white mb-5">
                <div class="title mr-5">
                    Количество отзывов по балам
                </div>
            </div>
            <div class="flex mb-8">
                <div style="width: 100%; height: 250px" class="bg-white rounded-3xl">
                    <canvas id="reviewsStatistics" class="hidden"></canvas>
                    <div id="loadingReviews" class="loading-data flex items-center w-full justify-center h-full">
                        <span class="loader dark"></span>
                    </div>
                </div>
            </div>
        @endif

    <script>
        const ctxOrders = document.getElementById('ordersStatistics');

        const labels = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
        ];

        const getData = (title) => {
            return {
                labels: labels,
                datasets: [{
                    label: title,
                    data: [...Array(7)].map(_ => Math.ceil(Math.random() * 100)),
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            }
        }


        new Chart(ctxOrders, {
            type: 'line',
            data: getData('Количество заказов'),
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 30,
                        right: 30,
                        top: 15,
                        bottom: 15,
                    }
                }
            }
        });

    </script>
@endsection

@section('sidebar')
    <x-admin.sidebar.statistics item_show="board" />
@endsection


@section('scripts')
    @vite(['resources/js/pages/boardPage.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
