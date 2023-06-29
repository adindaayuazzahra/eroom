@extends('index')
@section('content')
    <div class="mb-5 p-4 bg-white mt-5"
        style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-radius:15px;">
        <div class="row-md-12 border border-danger p-2" style="border-radius:5px;">
            <cite title="Source Title"> <span style="color:red;">*</span> Catatan : Apabila ingin mengganti ruangan, tanggal, file Undangan
                serta waktu rapat, maka harus menghapus data booking ruang rapat dan membooking ulang.</cite>

        </div>
        @if (session('message'))
            <div class="alert alert-{{ Session::get('message-class', 'warning') }} alert-dismissible fade show  mt-3"
                role="alert">

                <div> <i class="fas fa-exclamation-triangle pr-2"></i>
                    {{ session('message') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>
        @endif
        <h4 class="mt-4"><strong>FORM EDIT BOOKING RUANGAN</strong></h4>
        <hr style="border-top:1px solid black;margin-bottom:30px;">
        <form action="{{ route('user.acara.edit.do', ['id' => $acara->id]) }}" method="POST" class="">
            {{ csrf_field() }}
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="nama_rapat">Nama Rapat <span
                        class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('nama_rapat') is-invalid @enderror" name="nama_rapat"
                        id="nama_rapat" placeholder="Nama Rapat" value="{{ $acara->nama_rapat }}">
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
                        value="{{ $acara->ruangan->nama_ruangan }}">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Tanggal Rapat <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input readonly disabled type="date" class="form-control  @error('tanggal') is-invalid @enderror"
                        id="tanggal" name="tanggal" placeholder="Tanggal rapat"
                        min="{{ Carbon::now()->addDays(3)->toDateString() }}" value="{{ $acara->tanggal }}">
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
                    <input readonly disabled type="time" class="form-control  @error('jam_mulai') is-invalid @enderror"
                        id="jam_mulai" name="jam_mulai" placeholder="Jam Mulai" value="{{ $acara->jam_mulai }}">
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
                    <input readonly disabled type="time" class="form-control  @error('jam_selesai') is-invalid @enderror"
                        id="jam_selesai" name="jam_selesai" placeholder="Jam Selesai" value="{{ $acara->jam_selesai }}">
                    @error('jam_selesai')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            {{-- <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Undangan</label>
                <div class="col-sm-10">
                    <input type="file" id="udangan" placeholder="undangan">
                </div>
            </div> --}}
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Jumlah Peserta <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="number" class="form-control @error('jumlah_orang') is-invalid @enderror" id="jumlah_orang"
                        name="jumlah_orang" placeholder="Jumlah Peserta" value="{{ $acara->jumlah_orang }}">
                    @error('jumlah_orang')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <small class="form-text fst-italic">
                        * Jumlah Peserta tidak boleh melebihi kapasitas ruangan (Max. {{ $acara->ruangan->kapasitas }} Person)
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Kelengkapan</label>
                <div class="pl-5 col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="sound" id="sound" value="1"
                            {{ $acara->sound == 1 ? 'checked' : '' }}>
                        <label class="form-check-label">
                            Sound
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="tv" id="tv" value="1"
                            {{ $acara->tv == 1 ? 'checked' : '' }}>
                        <label class="form-check-label">
                            Tv
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="makan_siang" id="makan_siang"
                            value="1" {{ $acara->makan_siang == 1 ? 'checked' : '' }}>
                        <label class="form-check-label">
                            Makan Siang
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="snack_siang" id="snack_siang"
                            value="1" {{ $acara->snack_siang == 1 ? 'checked' : '' }}>
                        <label class="form-check-label">
                            Snack Siang
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="snack_pagi" id="snack_pagi"
                            value="1" {{ $acara->snack_pagi == 1 ? 'checked' : '' }}>
                        <label class="form-check-label">
                            Snack Pagi
                        </label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label ">Tambahan Lainnya</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="keterangan" id="keterangan">{{ $acara->keterangan }}</textarea>
                </div>
            </div>
            <hr style="border-top:1px solid black;margin-top:30px;">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('user.book.page') }}" class="btn btn-secondary mr-2">Kembali</a>
                <button type="submit" class="btn btn-warning">Booking</button>
            </div>
        </form>
    </div>
    <script>
        const inputMulai = document.getElementById("jam_mulai");
        const inputSelesai = document.getElementById("jam_selesai");
            var y = document.getElementById("jam_mulai").value;
            const jamMulai = parseFloat(y);
            if (jamMulai >= 13.30) {
                document.getElementById("makan_siang").disabled = true;
            }else{
                document.getElementById("makan_siang").disabled = false;
            }

            if (jamMulai >= 11.00) {
                document.getElementById("snack_pagi").disabled = true;
            }else{
                document.getElementById("snack_pagi").disabled = false;
            }

            var x = document.getElementById("jam_selesai").value;
            const jamSelesai = parseFloat(x);
            if (jamSelesai <= 11.00) {
                document.getElementById("makan_siang").disabled = true;
                document.getElementById("snack_siang").disabled = true;
            }else{
                document.getElementById("makan_siang").disabled = false;
                document.getElementById("snack_siang").disabled = false;
            }
    </script>
@endsection
