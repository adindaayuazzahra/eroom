@extends('index')
@section('content')
    <div class="mb-5 p-4 bg-white mt-5"
        style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-radius:15px;">
        {{-- @if (session('message'))
    <div class="alert alert-{{ Session::get('message-class', 'warning') }} d-flex align-items-center mb-3"
        role="alert">
        <i class="fas fa-check-circle pr-2"></i>
        <div>
            {{ session('message') }}
        </div>
    </div>
@endif --}}
        <div>
            <h4 class="mt-2"><strong>DAFTAR BOOKING RUANGAN</strong>
            </h4>
        </div>
        <div>
            {{-- <div class="text-end">
                <button class="btn btn-primary" id="btn-print">Print</button>
            </div>             --}}
            {{-- <button type="button" class="btn btn-outline-primary" style="border-radius:7px;" data-bs-toggle="modal"
        data-bs-target="#exampleModal">
        <i class="fas fa-plus"></i><strong> Tambah User</strong>
    </button> --}}
            {{-- <a href="{{ route('admin.user.add') }}" class="btn btn-outline-primary" style="border-radius:7px;"><i
                    class="fas fa-plus"></i><strong> Tambah User</strong></a> --}}
        </div>

        <hr style="border-top:1px solid black;margin-bottom:30px;">
        <table id="table_id" class="table table-hover" cellspacing="0" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Rapat</th>
                    <th scope="col">Ruangan</th>
                    <th style="width:12%" scope="col">Tanggal</th>
                    <th style="width:11%" scope="col">Jam Mulai</th>
                    <th style="width:11%" scope="col">Jam Selesai</th>
                    <th style="width:11%" scope="col">Unit</th>
                    <th scope="col">Status</th>
                    <th scope="col">Keterangan</th>
                    <th style="width:11%" scope="col">Aksi</th>
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
                        <td>{{ $acara->ruangan->nama_ruangan }}</td>
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
                        <td>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal{{ $acara['id'] }}">
                                <i class="fas fa-eye"></i>
                            </button>

                            @if ($acara['status'] == 0)
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#confirmDelete{{ $acara['id'] }}">
                                    <i class="fas fa-times fs-5"></i>
                                </button>
                            @else
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#canclePembatalan{{ $acara['id'] }}">
                                    <i class="fas fa-check"></i>
                                </button>
                            @endif

                            {{-- <a href="{{route('admin.booked.cancle',['id'=>$acara->id])}}" class="btn btn-danger btn-sm {{ $acara['tanggal'] <=Carbon::now()->addDays(1)->toDateString() || $acara['status'] == 1? 'disabled': '' }}">
                                <i class="fas fa-window-close"></i>
                            </a> --}}

                            {{-- <a href="{{ route('admin.acara.delete.do', ['id'=> $acara->id]) }}">D</a> --}}

                            {{-- sweetalert tp ga bisa buset dah --}}
                            {{-- <button type="submit"
                        class="btn btn-sm btn-danger {{ $acara['tanggal'] <= Carbon::now()->toDateString() || $acara['status'] == 1 ? 'disabled' : '' }}"
                        onclick="deleteData({{ route('acara.delete.do', ['id' => $acara['id']]) }})"><i
                            class="fas fa-trash-alt"></i></button> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @foreach ($acaras as $acara)
        <div class="modal fade" id="exampleModal{{ $acara['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title fs-5" id="exampleModalLabel"><strong>Kelengkapan Rapat</strong></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label class="col-sm-4">TV</label>
                            <div class="col">
                                @if ($acara['tv'] == 1)
                                    <td><i class="fas fa-check-circle"></i></td>
                                @else
                                    <td>
                                        <p>-</p>
                                    </td>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4">Sound</label>
                            <div class="col">
                                @if ($acara['sound'] == 1)
                                    <td><i class="fas fa-check-circle"></i></td>
                                @else
                                    <td>
                                        <p>-</p>
                                    </td>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4">Snack Pagi</label>
                            <div class="col">
                                @if ($acara['snack_pagi'] == 1)
                                    <td><i class="fas fa-check-circle"></i></td>
                                @else
                                    <td>
                                        <p>-</p>
                                    </td>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4">Snack Siang</label>
                            <div class="col">
                                @if ($acara['snack_siang'] == 1)
                                    <td><i class="fas fa-check-circle"></i></td>
                                @else
                                    <td>
                                        <p>-</p>
                                    </td>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4">Makan Siang</label>
                            <div class="col">
                                @if ($acara['makan_siang'] == 1)
                                    <td><i class="fas fa-check-circle"></i></td>
                                @else
                                    <td>
                                        <p>-</p>
                                    </td>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4">Jumlah Peserta</label>
                            <div class="col">
                                <td><strong>{{ $acara['jumlah_orang'] }}</strong> Orang</td>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4">Tambahan Lainnya</label>
                            <div class="col">
                                @if ($acara['keterangan'] != null)
                                    <td><strong>{{ $acara['keterangan'] }}</strong></td>
                                @else
                                    <td>
                                        <p>-</p>
                                    </td>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4">Undangan</label>
                            <div class="col">
                                <td>
                                    <a href="{{ route('pdf', ['filename' => basename($acara->undangan)]) }}" target="_blank" class="text-primary">Lihat undangan <i class="fa-solid fa-up-right-from-square"></i></i></a>
                                </td>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <td>
                                <object data="{{ Storage::url($acara->undangan) }}" type="application/pdf"
                                    width="100%" height="600px">
                                    <embed src="{{ Storage::url($acara->undangan) }}" type="application/pdf" />
                                </object>
                            </td>
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @foreach ($acaras as $acara)
        <div class="modal fade" id="confirmDelete{{ $acara['id'] }}" tabindex="-1" role="dialog"
            aria-labelledby="confirmDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="confirmDeleteLabel"><strong>Batalkan Booking</strong></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.booked.cancle.do', ['id' => $acara->id]) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Dibatalkan karena apa min ? <span
                                        class="text-danger">*</span></label>
                                <input type="hidden" value="{{ $acara['id'] }}">
                                <textarea class="form-control @error('pesan') is-invalid @enderror" id="pesan" rows="3" name="pesan"></textarea>
                                @error('pesan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            {{-- <a href="{{ route('admin.acara.delete.do', ['id' => $acara->id]) }}"
                                class="btn btn-danger">Hapus</a> --}}

                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @foreach ($acaras as $acara)
        <div class="modal fade" id="canclePembatalan{{ $acara['id'] }}" tabindex="-1" role="dialog"
            aria-labelledby="confirmDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="confirmDeleteLabel"><strong>Batalkan Cancle</strong></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin akan membatalkan cancle acara ini ? <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        <form action="{{ route('admin.booked.cancle.batal.do', ['id' => $acara->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
