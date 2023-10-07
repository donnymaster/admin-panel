<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" type="image/x-icon" href="/logo.ico">
    <title>Вход в панель</title>
</head>

<body class="form-container">
    <form action="{{ route('post.login') }}" method="POST" class="login-form flex flex-col">
        @csrf
        <div class="login-logo-company flex justify-center">
            <svg width="226" height="49" viewBox="0 0 226 49" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M57.4285 26H63.6737L68.1769 14.66L72.7129 26H78.9252L85.532 11.5374V9.56522H80.3715L75.7369 20.5765L71.1351 9.56522H65.2186L60.6497 20.5765L55.9823 9.56522H50.8217V11.5374L57.4285 26ZM89.2686 26H106.525V21.8913H92.6213V19.3932H105.605V15.9748H92.6213V13.6739H106.525V9.56522H87.3622V24.0936L89.2686 26ZM109.158 26H128.222L130.128 24.0936V19.5904L128.255 17.684L129.537 16.3692V11.4716L127.63 9.56522H109.158V26ZM114.417 15.9748V13.6739H124.278V15.9748H114.417ZM114.417 21.8913V19.3932H124.869V21.8913H114.417ZM53.2212 49H71.5296V44.5955H56.5739V36.9697H66.5663V39.8623H71.5296V32.5652H53.2212L51.3148 34.4716V47.0936L53.2212 49ZM76.0758 49H93.2338L95.1402 47.0936V34.4716L93.2338 32.5652H76.0758L74.1694 34.4716V47.0936L76.0758 49ZM79.4285 44.5955V36.9697H89.8811V44.5955H79.4285ZM96.7839 49H101.944L104.212 38.3831L107.795 49H113.482L117.064 38.3831L119.332 49H124.493V47.1264L120.647 32.5652H114.139L110.622 42.6233L107.138 32.5652H100.63L96.7839 47.1264V49ZM125.802 49H130.962L133.23 38.3831L136.813 49H142.499L146.082 38.3831L148.35 49H153.511V47.1264L149.665 32.5652H143.157L139.64 42.6233L136.156 32.5652H129.647L125.802 47.1264V49ZM154.819 49H159.947L161.36 46.3704H172.01L173.423 49H178.551V47.0607L169.808 32.5652H163.563L154.819 47.0607V49ZM163.727 41.9988L166.685 36.5424L169.643 41.9988H163.727ZM180.193 49H185.452V38.5803L193.472 49H200.211V32.5652H194.951V43.1492L186.635 32.5652H180.193V49ZM202.855 49H221.919L223.826 47.0936V39.3035L217.088 32.5652H202.855V49ZM208.114 44.5955V36.9697H214.655L218.567 40.8812V44.5955H208.114Z"
                    fill="#01D4BA"></path>
                <path d="M12.4309 10L1 20.7927V48.3036H30.0969L40.6964 39.2038" stroke="#01D4BA"
                    stroke-width="0.696429"></path>
                <path d="M30 22.5001L41 10.2188V39.5001L30 48.8036V22.5001Z" fill="#01D4BA"></path>
                <path d="M12.5 9.5H40.5L30 21H1L12.5 9.5Z" fill="#01D4BA"></path>
                <path
                    d="M138.715 21.3611H139.431V15.0101L142.147 21.3611H142.746L145.463 15.0101V21.3611H146.178V14.2078H145.076L142.447 20.2978L139.817 14.2078H138.715V21.3611ZM152.876 16.0734H152.2V16.9918H152.18C151.542 16.0154 150.556 15.9478 150.102 15.9478C148.207 15.9478 147.289 17.4268 147.289 18.6834C147.289 20.3268 148.536 21.4868 150.121 21.4868C151.272 21.4868 151.881 20.8294 152.18 20.3751H152.2V21.3611H152.876V16.0734ZM150.102 16.5954C151.301 16.5954 152.2 17.5524 152.2 18.7511C152.2 19.9111 151.281 20.8391 150.121 20.8391C148.99 20.8391 148.004 19.9498 148.004 18.7414C148.004 17.5138 148.952 16.5954 150.102 16.5954ZM154.091 21.3611H154.806V18.2291C154.806 17.1561 155.628 16.7114 156.304 16.6728V15.9574C155.657 15.9381 155.077 16.2668 154.787 16.8371H154.767V16.0734H154.091V21.3611ZM156.998 21.3611H157.714V20.3558L158.555 19.2731L160.275 21.3611H161.194L159.009 18.7221L161.058 16.0734H160.208L157.714 19.3698V14.2078H156.998V21.3611ZM167.119 18.9734C167.129 17.6104 166.404 15.9478 164.403 15.9478C162.605 15.9478 161.648 17.4171 161.648 18.7221C161.648 20.3074 162.846 21.4868 164.403 21.4868C165.601 21.4868 166.568 20.7811 166.993 19.6404H166.249C165.92 20.3654 165.234 20.8391 164.403 20.8391C163.291 20.8391 162.479 20.0271 162.392 18.9734H167.119ZM162.392 18.3258C162.566 17.3204 163.388 16.5954 164.403 16.5954C165.321 16.5954 166.143 17.2528 166.346 18.3258H162.392ZM168.747 21.3611H169.462V16.7211H170.69V16.0734H169.462V14.2078H168.747V16.0734H167.645V16.7211H168.747V21.3611ZM171.413 21.3611H172.129V16.0734H171.413V21.3611ZM171.413 15.4258H172.129V14.2078H171.413V15.4258ZM173.349 21.3611H174.064V18.4611C174.064 16.9724 174.953 16.5954 175.688 16.5954C177.341 16.5954 177.37 18.1904 177.37 18.5771V21.3611H178.085V18.5771C178.085 16.6921 176.974 15.9478 175.775 15.9478C175.079 15.9478 174.451 16.2378 174.045 16.8371H174.025V16.0734H173.349V21.3611ZM184.536 16.0734H183.86V17.0981H183.84C183.454 16.3731 182.729 15.9478 181.762 15.9478C180.206 15.9478 179.046 17.1754 179.046 18.7318C179.046 20.2301 180.215 21.4868 181.801 21.4868C182.758 21.4868 183.454 21.0324 183.802 20.3171H183.821V20.6071C183.821 21.1968 183.734 22.7821 181.878 22.7821C181.124 22.7821 180.283 22.3568 179.925 21.4868H179.21C179.568 22.6468 180.554 23.4298 181.888 23.4298C183.26 23.4298 184.536 22.6371 184.536 20.6071V16.0734ZM181.772 16.5954C182.912 16.5954 183.86 17.4944 183.86 18.7221C183.86 19.8918 182.999 20.8391 181.81 20.8391C180.602 20.8391 179.761 19.8531 179.761 18.6931C179.761 17.5234 180.602 16.5954 181.772 16.5954ZM187.506 21.3611H188.28L189.314 18.9638H192.639L193.674 21.3611H194.447L191.383 14.2078H190.59L187.506 21.3611ZM189.594 18.3161L190.986 15.0391L192.359 18.3161H189.594ZM200.452 16.0734H199.776V17.0981H199.756C199.37 16.3731 198.645 15.9478 197.678 15.9478C196.122 15.9478 194.962 17.1754 194.962 18.7318C194.962 20.2301 196.131 21.4868 197.717 21.4868C198.674 21.4868 199.37 21.0324 199.718 20.3171H199.737V20.6071C199.737 21.1968 199.65 22.7821 197.794 22.7821C197.04 22.7821 196.199 22.3568 195.841 21.4868H195.126C195.484 22.6468 196.47 23.4298 197.804 23.4298C199.176 23.4298 200.452 22.6371 200.452 20.6071V16.0734ZM197.688 16.5954C198.828 16.5954 199.776 17.4944 199.776 18.7221C199.776 19.8918 198.915 20.8391 197.726 20.8391C196.518 20.8391 195.677 19.8531 195.677 18.6931C195.677 17.5234 196.518 16.5954 197.688 16.5954ZM206.937 18.9734C206.947 17.6104 206.222 15.9478 204.221 15.9478C202.423 15.9478 201.466 17.4171 201.466 18.7221C201.466 20.3074 202.665 21.4868 204.221 21.4868C205.42 21.4868 206.386 20.7811 206.812 19.6404H206.067C205.739 20.3654 205.052 20.8391 204.221 20.8391C203.109 20.8391 202.297 20.0271 202.21 18.9734H206.937ZM202.21 18.3258C202.384 17.3204 203.206 16.5954 204.221 16.5954C205.139 16.5954 205.961 17.2528 206.164 18.3258H202.21ZM207.956 21.3611H208.671V18.4611C208.671 16.9724 209.561 16.5954 210.295 16.5954C211.948 16.5954 211.977 18.1904 211.977 18.5771V21.3611H212.693V18.5771C212.693 16.6921 211.581 15.9478 210.382 15.9478C209.686 15.9478 209.058 16.2378 208.652 16.8371H208.633V16.0734H207.956V21.3611ZM218.254 19.8144C217.877 20.4814 217.201 20.8391 216.476 20.8391C215.325 20.8391 214.368 19.9111 214.368 18.7028C214.368 17.5331 215.248 16.5954 216.476 16.5954C216.717 16.5954 217.723 16.6341 218.254 17.6781H219.057C218.641 16.6341 217.703 15.9478 216.476 15.9478C214.629 15.9478 213.653 17.4461 213.653 18.7124C213.653 20.0948 214.668 21.4868 216.476 21.4868C217.926 21.4868 218.689 20.5974 219.047 19.8144H218.254ZM223.856 16.0734L222.116 20.1914L220.453 16.0734H219.603L221.681 21.1194L220.801 23.2171H221.565L224.62 16.0734H223.856Z"
                    fill="#01D4BA"></path>
            </svg>
        </div>
        <div class="input-group mb-5 mt-5">
            <label for="email" class="label">
                E-Mail адрес
            </label>
            <input required autocomplete="email" id="email" type="text"
                class="input @error('email') is-invalid @enderror" name="email" value={{ old('email') }}>
            @error('email')
                <div class="alert-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="input-group mb-5">
            <label for="password" class="label">
                Пароль
            </label>
            <input required id="password" type="password" class="input @error('password') is-invalid @enderror"
                name="password">
            @error('password')
                <div class="alert-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="checkbox mb-5">
            <input class="custom-checkbox" type="checkbox" id="remember" name="remember"
                @if (old('remember')) checked @endif>
            <label for="remember">Запомнить меня</label>
        </div>
        <button class="btn justify-center">
            Войти
        </button>
        @error('auth')
            <div class="alert-error mt-2 text-center">{{ $message }}</div>
        @enderror
    </form>
</body>

</html>
