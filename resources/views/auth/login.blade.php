<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.header')
</head>

<body class="login">
    <div class="wrapper">
        @if (session('error'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="logo_login">
            <img src="assets/img-jmtm/jmtmpng.png" width="55%" alt="">
        </div>
        <div class="text-center mt-4 name">
            LOGIN
        </div>
        <form class="p-3 mt-2" action="{{ route('home.login.do') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" autocomplete="off" name="username"
                    class="form-control form-control-user"  id="username" placeholder="Username"
                    value="{{ old('username') }}" >
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="password" class="form-control form-control-user" id="password"
                    placeholder="Password" value="{{ old('password') }}">
            </div>
            <button type="submit" class="btn mt-3">Login</button>
            <div class="text-center mt-4">
                <a class="small" href="{{ route('home') }}">Kembali ke Halaman Menu Utama</a>
            </div>
        </form>
    </div>
    @include('partials.assetJs')
</body>

</html>
