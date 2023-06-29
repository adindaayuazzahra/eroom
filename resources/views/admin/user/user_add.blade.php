@extends('index')
@section('content')
    <div class="mb-5 p-4 bg-white mt-5"
        style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-radius:15px;">
        <div class="d-flex justify-content-between">
            <div>
                <h4 class="mt-2"><strong>DAFTAR USER</strong>
            </div>
            <div>
                {{-- <button type="button" class="btn btn-outline-primary" style="border-radius:7px;" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    <i class="fas fa-plus"></i><strong> Tambah User</strong>
                </button> --}}
                <a href="{{ route('admin.user.add') }}" class="btn btn-outline-primary" style="border-radius:7px;"><i
                        class="fas fa-plus"></i><strong> Tambah User</strong></a>
            </div>
        </div>
        </h4>
        <hr style="border-top:1px solid black;margin-bottom:30px;">
        <table id="table_id" class="table table-hover dt-responsive" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Username</th>
                    <th scope="col">Password</th>
                    <th scope="col">Unit Kerja</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $i }}</td> @php $i++ @endphp
                        <td>{{ $user['nama'] }}</td>
                        <td>{{ $user['username'] }}</td>
                        <td><span class="text-info font-italic">Encrypted</span></td>
                        <td>{{ $user['unit'] }}</td>
                        <td>
                            @if ($user->akses_level != 1)
                                <a href="{{ route('admin.user.edit', ['id' => $user->id]) }}"
                                    class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <button type="button" id="btn-hapus" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#confirmDelete{{$user['id']}}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            @else
                                <span>-</span>
                                {{-- <a href="{{ route('admin.user.edit', ['id' => $user->id]) }}"
                                    class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> --}}
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- modal tambah --}}
    @foreach($users as $user)
    <div class="modal fade" id="confirmDelete{{$user['id']}}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="confirmDeleteLabel"><strong>Hapus Akun</strong></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin akan menghapus Akun ini? <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <form action="{{ route('admin.user.delete.do', ['id' => $user->id]) }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection
