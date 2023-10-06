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
            <a href="{{route('admin.users')}}" class="role-badge ml-4">Все</a>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn bg-green mr-2 small-btn ml-auto">
            Добавить
        </a>
        <div class="btn modal-btn" style="display: none" data-modal="update-user">
            Добавить
        </div>
    </div>

    {{ $dataTable->table() }}


    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    @vite(['resources/js/pages/usersPage.js'])
@endsection

@section('sidebar')
    <div class="sidebar"></div>
@endsection


@push('modals')
    <div class="modal-container hidden">
        <div class="modal-overlay hidden"></div>
        <div class="modal hidden" data-modal="update-user">
            <input type="hidden" name="user_id">
            <div class="modal-header mb-5 text-2xl">
                <div class="title">Обновить пользователя</div>
                <div class="close-modal">
                    ✖
                </div>
            </div>
            <div class="modal-content scrollbar">
                <div class="input-group mb-3">
                    <label for="name" class="label flex black">
                        <span>Имя</span>
                    </label>
                    <input id="name" name="name" type="text" class="input border border-theme-blue border-solid">
                </div>
                <div class="input-group mb-3">
                    <label for="email" class="label black">
                        Почта
                    </label>
                    <input id="email" name="email" type="email" class="input border border-theme-blue border-solid">
                </div>
                <div class="flex flex-col">
                    <label for="role_id" class="mb-2 label">Родительская категория</label>
                    <select class="select mb-3" name="role_id" id="role_id">
                        @foreach ($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group">
                    <label for="password" class="label black">
                        Пароль
                    </label>
                    <input id="password" name="password" type="password" class="input border border-theme-blue border-solid">
                </div>
            </div>
            <div class="modal-footer flex justify-end">
                <div class="btn bg-green mr-2" id="updateUser">
                    <span class="loader dark"></span>
                    Обновить
                </div>
            </div>
        </div>
    </div>
@endpush
