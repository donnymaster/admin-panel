@extends('admin-panel.layouts.main')

@section('title', 'Пользователи')

@section('content')
    <div class="flex text-2xl text-white mb-5">
        <div class="title mr-5 flex items-center">
            <span>
                Пользователи
            </span>
            @foreach ($roles as $role)
                <a href="{{route('admin.users')}}?role_id={{$role->id}}" class="role-badge ml-4">{{$role->name}}</a>
            @endforeach
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn bg-green mr-2 small-btn ml-auto">
            Добавить
        </a>
    </div>

    {{ $dataTable->table() }}


    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endsection

@section('sidebar')
    <div class="sidebar"></div>
@endsection
