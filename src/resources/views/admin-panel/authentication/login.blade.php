<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>Login in Admin Panel</title>
</head>

<body class="bg-theme-light-blue flex items-center justify-center h-screen">
    <div class="login-container">
        <div class="login-logo-company">

        </div>
        <form action="{{ route('post.login') }}" method="POST" class="login-form flex flex-col">
            @csrf
            <div class="input-group mb-5">
                <label for="email" class="label">
                    Почта
                </label>
                <input id="email" type="text" class="input" name="email">
            </div>
            <div class="input-group mb-5">
                <label for="password" class="label">
                    Пароль
                </label>
                <input id="password" type="password" class="input" name="password">
            </div>
            <button class="btn justify-center">
                Войти
            </button>
        </form>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</body>

</html>
