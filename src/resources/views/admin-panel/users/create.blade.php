@extends('admin-panel.layouts.main')

@section('title', 'Новый пользователь')

@section('content')
    <form action="{{route('admin.users.store')}}" method="POST">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session()->has('successfully'))
            <div class="alert alert-success">
                {{session()->get('successfully')}}
            </div>
        @endif
        @csrf
        <div class="columns-2 mb-9">
            <div class="input-group">
                <label for="name" class="label flex">
                    <span>Имя</span>
                </label>
                <input id="name" name="name" type="text" class="input" value="{{old('name')}}">
            </div>
            <div class="input-group">
                <label for="email" class="label">
                    Почта
                </label>
                <input id="email" name="email" type="email" class="input" value="{{old('email')}}">
            </div>
        </div>
        <div class="columns-2 mb-9">
            <div class="input-group">
                <label for="password" class="label">
                    Пароль
                </label>
                <input id="password" name="password" type="password" class="input">
            </div>
            <div class="input-group">
                <label for="role_id" class="label">
                    Роль
                </label>
                <select name="role_id" id="role_id" class="select">
                    @foreach ($roles as $role)
                        <option value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex">
            <button type="submit" class="btn bg-green ml-auto">
                Добавить
            </button>
        </div>
    </form>
@endsection

@section('sidebar')
    <div class="sidebar"></div>
@endsection

