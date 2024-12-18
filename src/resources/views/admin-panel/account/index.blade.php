@extends('admin-panel.layouts.main')

@section('title', $user->name)

@section('content')
    <form action="{{route('admin.account.update')}}" method="POST">
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
        @method('PATCH')
        <div class="columns-2 mb-9">
            <div class="input-group">
                <label for="name" class="label flex">
                    <span>Имя</span>
                </label>
                <input id="name" name="name" type="text" class="input" value="{{$user->name}}">
            </div>
            <div class="input-group">
                <label for="email" class="label">
                    Почта
                </label>
                <input id="email" name="email" type="email" class="input" value="{{$user->email}}">
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
                <label class="label">
                    Роль
                </label>
                <input disabled type="text" class="input" value="{{$user->role->name}}">
            </div>
        </div>
        <div class="flex">
            <button type="submit" class="btn bg-green ml-auto">
                Обновить
            </button>
        </div>
    </form>
@endsection

@section('sidebar')
    <div class="sidebar"></div>
@endsection

