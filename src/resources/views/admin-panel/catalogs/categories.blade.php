@extends('admin-panel.layouts.main')

@section('title', 'Категории')

@section('content')
    <div class="drop-down-list-container">

    </div>

    @vite(['resources/js/pages/categoryPage.js'])
@endsection

@section('sidebar')
    <x-admin.sidebar.categories />
@endsection
