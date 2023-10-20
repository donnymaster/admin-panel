@extends('admin-panel.layouts.main')

@section('title', 'Обмен данными')

@section('content')
    <div class="columns-1 flex mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
        <span>Обмен данными</span>
        <div class="check-status-files border-none btn bg-green small-btn ml-auto">
            Проверить файлы
        </div>


    </div>
@endsection

@section('sidebar')
    <div class="sidebar"></div>
@endsection

@section('scripts')
    @vite(['resources/js/pages/dataExchangePage.js'])
@endsection
