<!DOCTYPE html>
<html lang="id">

<head>
    @include('partials.header')
</head>

<body
    style="background-image: url({{ asset('assets/images/slider/slider-04.png') }}); background-position: center center;
background-repeat: no-repeat;
background-size: cover; background-attachment: fixed;">
    @include('sweetalert::alert')
    {{-- <div class="container"> --}}
        <nav class="navbar navbar-light navbar-expand-lg sticky-top px-2 container"
            style="background-color:#29b9f2;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-radius:0px 0px 15px 15px;">
            <div class="container-fluid">
                <img src="{{ asset('assets/img-jmtm/jmtmpng.png') }}" class="navbar-brand" width="200px">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="fas fa-caret-down" style="color:#ffff; font-size:24px;border:none;outline: none;">
                    </span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo02">
                    <ul class="nav ">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('home') }}">Home</a>
                        </li>
                        @if (Auth::check())
                            @if (Auth::user()->akses_level == 1)
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('admin.book.page') }}">Book</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('user.book.page') }}">Book</a>
                                </li>
                            @endif
                            @if (Auth::user()->akses_level == 1)
                                <li class="nav-item dropdown">
                                    <a class="nav-link text-white dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Mengelola Data
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('admin.user') }}">Data User</a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('admin.booked') }}">Data Booking</a></li>
                                        <li><a class="dropdown-item" href="{{route('admin.ruangan')}}">Data Ruangan</a></li>
                                    </ul>
                                </li>
                            @endif
                            <li class="nav-item ml-3">
                                <a class="btn btn-danger text-white d-inline-block align-text-top"
                                    style="border-radius:7px;" href="{{ route('home.logout.do') }}">Logout</a>
                            </li>
                        @else
                            <li class="nav-item ml-3">
                                <a class="btn btn-dark d-inline-block align-text-top" style="border-radius:7px;"
                                    href="{{ route('home.login') }}">Login</a>
                            </li>
                        @endif
                    </ul>

                </div>
            </div>
        </nav>
    {{-- </div> --}}

    <div class="container">
        @yield('content')
    </div>
    @include('partials.assetJs')
</body>

</html>
