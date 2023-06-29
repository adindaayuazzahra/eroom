@extends('index')
@section('content')
    <div class="mb-5 p-4 bg-white mt-5"
        style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-radius:15px;">
        <h4 class="mt-2"><strong>FORM TAMBAH RUANGAN</strong></h4>
        <hr style="border-top:1px solid black;margin-bottom:30px;">
        <form method="POST" action="{{route('admin.ruangan.add.do')}}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="nama_ruangan">Nama Ruangan</label>
                <input type="text" class="form-control @error('nama_ruangan') is-invalid @enderror" id="nama_ruangan" name="nama_ruangan" value="{{ old('nama_ruangan') }}">
                @error('nama_ruangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="kapasitas">Kapasitas</label>
                <input type="number" class="form-control @error('kapasitas') is-invalid @enderror" id="kapasitas" name="kapasitas" value="{{ old('kapasitas') }}">
                @error('kapasitas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="gambar">Gambar</label>
                <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar">
                @error('gambar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="status">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="1" selected>Aktif</option>
                    <option value="2">Tidak Aktif</option>
                </select>
            </div>
            <a href="{{ route('admin.ruangan') }}" class="btn btn-secondary mr-2">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
