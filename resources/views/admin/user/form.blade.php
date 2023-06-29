@extends('index')
@section('content')
    <div class="mb-5 p-4 bg-white mt-5"
        style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-radius:15px;">
        <h4 class="mt-2"><strong>FORM {{ isset($user) ? 'EDIT' : 'TAMBAH' }} USER</strong></h4>
        <hr style="border-top:1px solid black;margin-bottom:30px;">
        <form method="POST" action="{{ isset($user) ? route('admin.user.edit.do', ['id' => $user->id]) : route('admin.user.add.do') }}" >
            {{ csrf_field() }}
            <div class="mb-3">
                <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                    name="nama" value="{{ $user->nama ?? old('nama') }}">
                <div class="invalid-feedback"> @error('nama')
                        {{ $message }}
                    @enderror </div>

            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                    name="username" value="{{ $user->username ?? old('username') }}">
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password <span
                        class="text-danger">{{ isset($user) ? '' : '*' }}</span></label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password">
                <small class="form-text text-muted">
                    {{ isset($user) ? 'Biarkan kosong jika tidak ingin mengubah password.' : '' }}
                </small>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="unit" class="form-label">Unit <span class="text-danger">*</span></label>
                <select class="form-select @error('unit') is-invalid @enderror" id="unit" name="unit">
                    <option value="">-- Pilih Unit --</option>
                    <option value="HCGA"  {{ old('unit', isset($user) && $user->unit == 'HCGA' ? 'selected' : '') }}>HCGA</option>
                    <option value="AMTD" {{ old('unit', isset($user) && $user->unit == 'AMTD' ? 'selected' : '') }}>AMTD</option>
                    <option value="CPFTA" {{ old('unit', isset($user) && $user->unit == 'CPFTA' ? 'selected' : '') }}>CPFTA</option>
                    <option value="OPS 1" {{ old('unit', isset($user) && $user->unit == 'OPS 1' ? 'selected' : '') }}>OPS 1</option>
                    <option value="OPS 2" {{ old('unit', isset($user) && $user->unit == 'OPS 2' ? 'selected' : '') }}>OPS 2</option>
                    <option value="OPS 3" {{ old('unit', isset($user) && $user->unit == 'OPS 3' ? 'selected' : '') }}>OPS 3</option>
                    <option value="PROCUREMENT" {{ old('unit', isset($user) && $user->unit == 'PROCUREMENT' ? 'selected' : '') }}>PROCUREMENT</option>
                    <option value="AMBD" {{ old('unit', isset($user) && $user->unit == 'AMBD' ? 'selected' : '') }}>AMBD</option>
                </select>
                @error('unit')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <a href="{{ route('admin.user') }}" class="btn btn-secondary mr-2">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
