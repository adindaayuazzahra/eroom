@extends('index')
@section('content')
    <div class="mb-5 p-4 bg-white mt-5"
        style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-radius:15px;">
        <h4 class="mt-2"><strong>JADWAL RUANG {{ strtoupper($ruangan['nama_ruangan']) }} YANG SUDAH DI PESAN OLEH
                UNIT</strong>
        </h4>
        <hr style="border-top:1px solid black;margin-bottom:30px;">
        <table id="table_id" class="table table-hover dt-responsive" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Rapat</th>
                    <th style="width:11%" scope="col">Tanggal</th>
                    <th style="width:11%" scope="col">Jam Mulai</th>
                    <th style="width:11%" scope="col">Jam Selesai</th>
                    <th style="width:15%" scope="col">Unit</th>
                    <th scope="col">Status</th>
                    <th style="width:20%" scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($acaras as $acara)
                    <tr>
                        <td>{{ $i }}</td> @php $i++ @endphp
                        <td>{{ $acara['nama_rapat'] }}</td>
                        <td>{{ Carbon::parse($acara['tanggal'])->format('d/m/Y') }}</td>
                        <td>{{ date('H:i', strtotime($acara['jam_mulai'])) }}</td>
                        <td>{{ date('H:i', strtotime($acara['jam_selesai'])) }}</td>
                        <td>{{ $acara->user->unit }}</td>
                        @if ($acara['status'] == 0)
                            <td><span class="badge bg-success text-white">Book</span></td>
                            <td>
                                <p>-</p>
                            </td>
                        @else
                            <td><span class="badge bg-danger text-white">Cancel</span></td>
                            <td>{{ $acara['pesan'] }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if (session('message'))
            <div class="alert alert-{{ Session::get('message-class', 'warning') }} alert-dismissible fade show  mt-3"
                role="alert">
                <div> <i class="fas fa-exclamation-triangle pr-2"></i>
                    {{ session('message') }}
                </div>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button> --}}
            </div>
        @endif
        <h4 class="mt-4"><strong>FORM BOOKING RUANGAN</strong></h4>
        <hr style="border-top:1px solid black;margin-bottom:30px;">

        <form action="{{ route('booking.do', ['id' => $ruangan->id]) }}" method="POST" class="" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="nama_rapat">Nama Rapat <span
                        class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('nama_rapat') is-invalid @enderror" name="nama_rapat"
                        id="nama_rapat" placeholder="Nama Rapat" value="{{ old('nama_rapat') }}">
                    @error('nama_rapat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label for="nama_ruangan" class="col-sm-2 col-form-label">Ruangan</label>
                <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="nama_ruangan"
                        value="{{ $ruangan['nama_ruangan'] }}">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Tanggal Rapat <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="date" class="form-control  @error('tanggal') is-invalid @enderror" id="tanggal"
                        name="tanggal" placeholder="Tanggal rapat" min="{{ Carbon::now()->addDays(3)->toDateString() }}"
                        value="{{ old('tanggal') }}">
                    @error('tanggal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Jam Mulai <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="time" class="form-control  @error('jam_mulai') is-invalid @enderror" min="08:00"
                        max="17:00" step="1800" id="jam_mulai" name="jam_mulai" placeholder="Jam Mulai"
                        value="">
                    @error('jam_mulai')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Jam Selesai <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="time" class="form-control  @error('jam_selesai') is-invalid @enderror" id="jam_selesai"
                        min="08:00" max="17:00" step="1800" name="jam_selesai" placeholder="Jam Selesai"
                        value="">
                    @error('jam_selesai')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Undangan <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="file" class="form-control-file  @error('undangan') is-invalid @enderror" id="undangan"
                        name="undangan"><br>
                    <small class="form-text fst-italic">
                        * Format PDF (Max. 2 Mb)
                    </small>
                    @error('undangan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Jumlah Peserta <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="number" class="form-control @error('jumlah_orang') is-invalid @enderror"
                        id="jumlah_orang" name="jumlah_orang" placeholder="Jumlah Peserta"
                        value="{{ old('jumlah_orang') }}" max="{{ $ruangan['kapasitas'] }}">
                    <small class="form-text fst-italic">
                        * Jumlah Peserta tidak boleh melebihi kapasitas ruangan (Max. {{ $ruangan['kapasitas'] }} Person)
                    </small>
                    @error('jumlah_orang')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Kelengkapan</label>
                <div class="pl-5 col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="sound" id="sound" value="1">
                        <label class="form-check-label">
                            Sound
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="tv" id="tv" value="1">
                        <label class="form-check-label">
                            Tv
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="makan_siang" id="makan_siang"
                            value="1">
                        <label class="form-check-label">
                            Makan Siang
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="snack_siang" id="snack_siang"
                            value="1">
                        <label class="form-check-label">
                            Snack Siang
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="snack_pagi" id="snack_pagi"
                            value="1">
                        <label class="form-check-label">
                            Snack Pagi
                        </label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label ">Tambahan Lainnya</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="keterangan" id="keterangan">{{ old('keterangan') }}</textarea>
                </div>
            </div>
            <hr style="border-top:1px solid black;margin-top:30px;">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('home') }}" class="btn btn-secondary mr-2">Kembali</a>
                <button type="submit" class="btn btn-warning booking">Booking</button>
            </div>
        </form>
    </div>
    {{-- <script>
        const inputMulai = document.getElementById("jam_mulai");
        const inputSelesai = document.getElementById("jam_selesai");
        const makanSiang = document.getElementById("makan_siang");
        const snackPagi = document.getElementById("snack_pagi");
        const snackSiang = document.getElementById("snack_siang");

        inputMulai.addEventListener("blur", function() {
            var jamMulai = parseFloat(inputMulai.value);
            var jamSelesai = parseFloat(inputSelesai.value);

            if (jamMulai >= 08.00 && jamSelesai <= 11.00) {
                snackPagi.disabled = false;
            } else {
                snackPagi.disabled = true;
            }

            if (jamMulai >= 11.00 && jamSelesai <= 13.30) {
                makanSiang.disabled = false;
            } else {
                makanSiang.disabled = true;
            }

            if (jamMulai >= 14.00 && jamSelesai <= 17.00) {
                snackSiang.disabled = false;
            } else {
                snackSiang.disabled = true;
            }

            if (jamMulai >= 08.00 && jamSelesai <= 16.00) {
                snackPagi.disabled = false;
                makanSiang.disabled = false;
                snackSiang.disabled = false;
            }
        });

        inputSelesai.addEventListener("blur", function() {
            var jamMulai = parseFloat(inputMulai.value);
            var jamSelesai = parseFloat(inputSelesai.value);

            if (jamSelesai <= 11.00) {
                makanSiang.disabled = true;
                snackSiang.disabled = true;
            } else {
                makanSiang.disabled = false;
                snackSiang.disabled = false;
            }

            if (jamSelesai <= 08.00 || jamMulai >= 16.00) {
                snackPagi.disabled = true;
                makanSiang.disabled = true;
                snackSiang.disabled = true;
            }
        });
    </script> --}}
    <script>
        const inputMulai = document.getElementById("jam_mulai");
        const inputSelesai = document.getElementById("jam_selesai");

        inputMulai.addEventListener("blur", function() {
            var y = document.getElementById("jam_mulai").value;
            const jamMulai = parseFloat(y);
            if (jamMulai >= 13.30) {
                document.getElementById("makan_siang").disabled = true;
                // document.getElementById("snack_pagi").disabled = true;
            } else {
                document.getElementById("makan_siang").disabled = false;
                // document.getElementById("snack_pagi").disabled = false;
            }

            if (jamMulai >= 11.00) {
                // document.getElementById("makan_siang").disabled = true;
                document.getElementById("snack_pagi").disabled = true;
            } else {
                // document.getElementById("makan_siang").disabled = false;
                document.getElementById("snack_pagi").disabled = false;
            }

        });

        inputSelesai.addEventListener("blur", function() {
            var x = document.getElementById("jam_selesai").value;
            const jamSelesai = parseFloat(x);
            if (jamSelesai <= 11.00) {
                document.getElementById("makan_siang").disabled = true;
                document.getElementById("snack_siang").disabled = true;
                // document.getElementById("snack_pagi").disabled = false;
            } else {
                document.getElementById("makan_siang").disabled = false;
                document.getElementById("snack_siang").disabled = false;
                // document.getElementById("snack_pagi").disabled = true;
            }

            // if (jamSelesai >= 13.30) {
            //     document.getElementById("makan_siang").disabled = true;
            //     // document.getElementById("snack_pagi").disabled = true;
            // }else{
            //     document.getElementById("makan_siang").disabled = false;
            //     // document.getElementById("snack_pagi").disabled = false;
            // }

        });
    </script>
    {{-- <script>
        // $(document).ready(function() {
        //     const now = dayjs();
        //     time=(now.format('HH:mm'));

        //     $('.booking').click(function() {
        //         // var jam_batas = moment().hours();
        //         var jam_awal = $('#jam_mulai').val()
        //         alert('ini inputan :' + jam_awal)
        //         alert('ini logic :' + time )
        //         // var jam_awal_check=$('#jam_awal_check').val('14.00')

        //         //    console.log();
        //     });
        // })
        const inputMulai = document.getElementById("jam_mulai");
        const inputSelesai = document.getElementById("jam_selesai");

        inputMulai.addEventListener("blur", function() {
            // Saat kursor keluar dari input, tampilkan modal
            // const now = dayjs();
            var y = document.getElementById("jam_mulai").value;
            const jamMulai = parseFloat(y);

            // var y = document.getElementById("jam_mulai").value;
            // const jamMulai = parseInt(y);
            // const jam = new Date();
            // jam.setHours(11);
            // jam.setMinutes(30);
            // const jamSebelas = new Date();
            // jamSebelas.setHours(11, 0, 0, 0);
            // time= dayjs().hour(11).minute(0)
            if (jamMulai >= 14.00) {
                // const checkboxMakanSiang = document.getElementById("makan_siang");
                // checkboxMakanSiang.style.display = "none";
                document.getElementById("makan_siang").disabled = true;
                document.getElementById("snack_pagi").disabled = true;
            }else{
                document.getElementById("makan_siang").disabled = false;
                document.getElementById("snack_pagi").disabled = false;
            }

            // if (jamMulai >= 14.00) {
            //     // const checkboxMakanSiang = document.getElementById("makan_siang");
            //     // checkboxMakanSiang.style.display = "none";
            //     document.getElementById("makan_siang").disabled = true;
            // }else{

            //     document.getElementById("makan_siang").disabled = false;
            // }
            // if (jamSelesai >= 11.00) {
            // }

        });

        inputSelesai.addEventListener("blur", function() {
            // Saat kursor keluar dari input, tampilkan modal
            // const now = dayjs();
            var x = document.getElementById("jam_selesai").value;
            const jamSelesai = parseFloat(x);

            // var y = document.getElementById("jam_mulai").value;
            // const jamMulai = parseInt(y);
            // const jam = new Date();
            // jam.setHours(11);
            // jam.setMinutes(30);
            // const jamSebelas = new Date();
            // jamSebelas.setHours(11, 0, 0, 0);
            // time= dayjs().hour(11).minute(0)
            if (jamSelesai <= 11.00) {
                // const checkboxMakanSiang = document.getElementById("makan_siang");
                // checkboxMakanSiang.style.display = "none";
                document.getElementById("makan_siang").disabled = true;
                document.getElementById("snack_siang").disabled = true;
            }else{
                document.getElementById("makan_siang").disabled = false;
                document.getElementById("snack_siang").disabled = false;
            }

            // if (jamMulai >= 14.00) {
            //     // const checkboxMakanSiang = document.getElementById("makan_siang");
            //     // checkboxMakanSiang.style.display = "none";
            //     document.getElementById("makan_siang").disabled = true;
            // }else{

            //     document.getElementById("makan_siang").disabled = false;
            // }
            // if (jamSelesai >= 11.00) {
            // }

        });
      
    </script> --}}
@endsection
