@extends('index')
@section('content')
    <!-- Hero Slider start -->
    <!-- Hero Content One Start -->
    <div class="container">
        <div class="row justify-content-center " style="margin-top:60px;">
            <div class="col-lg-9 col-md-8">
                <h1 class="text-center">Booking Ruang Rapat Kantor Cipayung.</h1>
                <p class="text-center">Selamat datang di web Booking Ruang Rapat Kantor Cipayung <strong>PT
                        Jasamarga Tollroad Maintenance</strong>. <br> Silahkan booking ruang sesuai dengan
                    kebutuhan unit kerja anda.</p>
            </div>
            <div class="row align-items-center" style="margin-top:60px;">
                @foreach ($ruangans as $ruangan)
                    <div class="col-md-3">
                        <div class="box mb-4">
                            <div class="our-services privacy">
                                <img src="{{ asset('storage/upload/'.$ruangan['gambar']) }}" width="90%"
                                    style="border-radius: 10px;margin-top:20px;margin-bottom: 10px;">
                                <h4>
                                    {{ $ruangan['nama_ruangan'] }}
                                </h4>
                                <p>Ruang rapat ini memiliki kapasitas {{ $ruangan['kapasitas'] }} Orang </p>
                                @if ($ruangan['status'] != 1)
                                <a href="" class="mb-4 btn btn-warning disabled"
                                role="button">Maintenance</a>
                                @else
                                    {{-- <a href="{{(Auth::user()->akses_level == 1) ? route('booking', ['id' => $ruangan->id]) : route('user.booking', ['id' => $ruangan->id]) }}" class="mb-4 btn btn-primary" role="button">Booking</a> --}}
                                    @if (Auth::check())
                                        @if (Auth::user()->akses_level == 1)
                                            <a href="{{ route('booking', ['id' => $ruangan->id]) }}"
                                                class="mb-4 btn btn-primary" role="button"><i class="fa-solid fa-users"></i> Booking</a>
                                        @else
                                            <a href="{{ route('user.booking', ['id' => $ruangan->id]) }}"
                                                class="mb-4 btn btn-primary" role="button" ><i class="fa-solid fa-users"></i> Booking</a>
                                        @endif
                                    @else
                                        <a href="{{ route('home.login') }}" class="mb-4 btn btn-primary"
                                            role="button"><i class="fa-solid fa-users"></i> Booking</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
