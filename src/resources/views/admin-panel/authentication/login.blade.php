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
            <form action="#" class="login-form flex flex-col">
                <div class="input-group mb-5">
                    <label for="email" class="label">
                        Почта
                    </label>
                    <input id="email" type="text" class="input">
                </div>
                <div class="input-group mb-5">
                    <label for="password" class="label">
                        Пароль
                    </label>
                    <input id="password" type="password" class="input">
                </div>
                <div class="btn justify-center">
                    Войти
                </div>
            </form>
        </div>
    </body>
</html>
