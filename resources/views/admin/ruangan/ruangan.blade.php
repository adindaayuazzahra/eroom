@extends('index')
@section('content')
    <div class="mb-5 p-4 bg-white mt-5"
        style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-radius:15px;">
        <div class="d-flex justify-content-between">
            <div>
                <h4 class="mt-2"><strong>DAFTAR RUANGAN</strong>
            </div>
            <div>
                {{-- <button type="button" class="btn btn-outline-primary" style="border-radius:7px;" data-bs-toggle="modal"
                    data-bs-target="#ruanganAdd">
                    <i class="fas fa-plus"></i><strong> Tambah Ruangan</strong>
                </button> --}}
                <a href="{{ route('admin.ruangan.add') }}" class="btn btn-outline-primary" style="border-radius:7px;"><i
                        class="fas fa-plus"></i><strong> Tambah Ruangan</strong></a>
            </div>
        </div>
        </h4>
        <hr style="border-top:1px solid black;margin-bottom:30px;">
        <table id="table_id" class="table table-hover dt-responsive" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Ruangan</th>
                    <th scope="col">Kapasitas</th>
                    <th style="width:10%;" scope="col">Gambar</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($ruangans as $ruangan)
                    <tr>
                        <td>{{ $i }}</td> @php $i++ @endphp
                        <td>{{ $ruangan['nama_ruangan'] }}</td>
                        <td>{{ $ruangan['kapasitas'] }}</td>
                        <td>
                            <img src="{{ asset('storage/upload/'. $ruangan['gambar']) }}" width="100"></td>
                        <td>
                            @if ($ruangan['status'] == 1)
                                <span class="badge rounded-pill text-bg-success">Available</span>
                            @else
                                <span class="badge rounded-pill text-bg-warning">Maintenance</span>
                            @endif
                        </td>
                        <td>
                            @if ($ruangan['status']== 1)
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#maintenance{{ $ruangan['id'] }}">
                                    <i class="fas fa-wrench"></i>
                                </button>
                            @else
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#ready{{ $ruangan['id'] }}">
                                    <i class="fas fa-check"></i></i>
                                </button>
                            @endif
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#confirmDelete{{ $ruangan['id'] }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- modal hapus --}}
    @foreach ($ruangans as $ruangan)
        <div class="modal fade" id="confirmDelete{{ $ruangan['id'] }}" tabindex="-1" role="dialog"
            aria-labelledby="confirmDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="confirmDeleteLabel"><strong>Hapus Ruangan</strong></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus ruangan ini? <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        <form action="{{ route('admin.ruangan.delete.do', ['id' => $ruangan->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- modal maintenance --}}
    @foreach ($ruangans as $ruangan)
        <div class="modal fade" id="maintenance{{ $ruangan['id'] }}" tabindex="-1" role="dialog"
            aria-labelledby="confirmDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="confirmDeleteLabel"><strong>Non-Aktifkan Ruangan</strong></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menonaktifkan ruangan ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        <form action="{{ route('admin.ruangan.maintain.do', ['id' => $ruangan->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning">Maintenance</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- modal ready --}}
    @foreach ($ruangans as $ruangan)
        <div class="modal fade" id="ready{{ $ruangan['id'] }}" tabindex="-1" role="dialog"
            aria-labelledby="confirmDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="confirmDeleteLabel"><strong>Mengaktifkan Ruangan</strong></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ruangan ini sudah bisa digunakan?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        <form action="{{ route('admin.ruangan.ready.do', ['id' => $ruangan->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Ready</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
