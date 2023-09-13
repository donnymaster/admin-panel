@extends('admin-panel.layouts.main')

@section('title', 'Доска')

@section('content')
    <p>board</p>
    <form action="{{route('admin.logout')}}" method="POST">
        @csrf
        <button type="submit">logout</button>
    </form>
@endsection

@section('sidebar')
    <x-admin.sidebar.statistics />
@endsection
