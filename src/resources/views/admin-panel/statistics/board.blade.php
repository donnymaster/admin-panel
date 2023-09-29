@extends('admin-panel.layouts.main')

@section('title', 'Доска')

@section('content')
    <div class="columns-3 mb-8">
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
                154 545
            </div>
            <div class="name">
                посетителей
            </div>
        </div>
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
                154 545
            </div>
            <div class="name">
                Заказов
            </div>
        </div>
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
                154 545
            </div>
            <div class="name">
                Заявок
            </div>
        </div>
    </div>

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
            <div class="btn load-applications small-btn">Обновить</div>
        </div>
    </div>
    <div class="flex mb-8">
        <div style="width: 100%; height: 250px" class="bg-white rounded-3xl">
            <canvas id="ordersStatistics"></canvas>
        </div>
    </div>



    <div class="flex text-2xl text-white mb-5">
        <div class="title mr-5">
            Количество отзывов по балам
        </div>
        {{-- <div class="flex">
            <div class="date-start mr-4 flex items-center">
                <span class="mr-2 text-sm">Начало</span>
                <input type="date" class="date" name="date-start" value="{{$reviewPeriod['min']}}" min="{{$reviewPeriod['min']}}" max="{{$reviewPeriod['max']}}">
            </div>
            <div class="date-end mr-4 flex items-center">
                <span class="mr-2 text-sm">Конец</span>
                <input type="date" class="date" name="date-end" value="{{$reviewPeriod['max']}}" min="{{$reviewPeriod['min']}}" max="{{$reviewPeriod['max']}}">
            </div>
            <div class="btn load-applications small-btn">Обновить</div>
        </div> --}}
    </div>
    <div class="flex mb-8">
        <div style="width: 100%; height: 250px" class="bg-white rounded-3xl">
            <canvas id="reviewsStatistics" class="hidden"></canvas>
            <div id="loadingReviews" class="loading-data flex items-center w-full justify-center h-full">
                <span class="loader dark"></span>
            </div>
        </div>
    </div>

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
