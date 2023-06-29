<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Ruangan, Acara, User};
use Storage;
use Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // $title = 'Home';
        $ruangans = Ruangan::all();
        return view('user.index', compact('ruangans'));
    }
    public function bookPage()
    {
        $threeDaysAgo = Carbon::now()->subDays(3)->toDateString();
        $acaras = Acara::orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->where('id_user', auth()->user()->id)
            ->where('tanggal', '>', $threeDaysAgo)
            ->get();
        return view('admin.book', compact('acaras'));
    }

    public function user()
    {
        $users = User::all();
        return view('admin.user.user_add', compact('users'));
    }

    public function userAdd()
    {
        // $users = User::all();
        return view('admin.user.form');
    }

    public function userAddDo(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|alpha_num|min:5|max:100|unique:users',
            'password' => 'required|alpha_num|min:8|max:100',
            'unit' => 'required',
        ]);

        $user = new User();
        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->unit = $request->unit;
        $user->akses_level = 2;
        $user->save();

        return redirect()->route('admin.user')->withSuccess('Berhasil Menambah User!');
    }

    public function userEdit($id)
    {
        $user = User::find($id);
        if (!$user) {
            abort(404);
        }
        return view('admin.user.form', compact('user'));
    }

    public function userEditDo($id, Request $request)
    {
        $user = User::find($id);
        if (!$user) {
            abort(404);
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|alpha_num|min:5|max:100|unique:users,username,' . $user->id,
            'password' => 'nullable|alpha_num|min:8|max:100',
            'unit' => 'required',
        ]);
        if ($request->password) {
            $user->password = bcrypt($request->password);
        };
        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->unit = $request->unit;
        $user->save();
        return redirect()->route('admin.user')->withSuccess('Berhasil Mengubah Data!');
    }


    public function userDeleteDo($id)
    {
        // Alert::question('Question Title', 'Question Message');
        $user = User::find($id);
        $user->delete();
        // $request->session()->flash('message', 'Berhasil Menghapus Data');
        // $request->session()->flash('message-class', 'success');

        return redirect()->route('admin.user')->withSuccess('Berhasil Menghapus Data!');
    }

    public function booking($id)
    {
        
        // filter tanggal
        $now = Carbon::now()->toDateString();
        $end =  Carbon::now()->addDays(3)->toDateString();

        $ruangan = Ruangan::find($id);
        $acaras = Acara::orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->where('tanggal', '>', $now)
            ->where('tanggal', '>=', $end)
            ->where('id_ruangan', $id)
            ->get();
        return view('admin.form', compact('ruangan', 'acaras'));
    }

    public function bookingDo(Request $request, $id)
    {
        $ruangan = Ruangan::find($id);
        if (!$ruangan) {
            abort(404);
        }
        $validatedData = $request->validate([
            'nama_rapat' => 'required',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'jumlah_orang' => 'required',
            'undangan' => 'required|file|mimes:pdf|max:2048',
        ]);
        $namaRapat = $validatedData['nama_rapat'];
        $tanggalAcara = $validatedData['tanggal'];
        $jamMulai = $validatedData['jam_mulai'];
        $jamSelesai = $validatedData['jam_selesai'];
        $jumlahOrang = $validatedData['jumlah_orang'];
        $keterangan = $request->keterangan;
        $undangan = $request->file('undangan')->store('public/undangan');
        
        // Query untuk mencari acara yang sudah terjadwal pada waktu dan tanggal yang sama pada ruangan yang dipilih
        $isBookingExist = Acara::where('id_ruangan', $ruangan->id)
            ->where('tanggal', $tanggalAcara)
            ->where(function ($query) use ($jamMulai, $jamSelesai) {
                $query->whereBetween('jam_mulai', [$jamMulai, $jamSelesai])
                    ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai])
                    ->orWhere(function ($query) use ($jamMulai, $jamSelesai) {
                        $query->where('jam_mulai', '<=', $jamMulai)
                            ->where('jam_selesai', '>=', $jamSelesai);
                    });
            })
            ->exists();

        if ($jamMulai >= $jamSelesai) {
            $request->session()->flash('message', 'Pastikan anda memasukan jam mulai dan jam selesai dengan benar!');
            $request->session()->flash('message-class', 'danger');
            return redirect()->route('booking', ['id' => $ruangan->id]);
        }

        // if ($isBookingExist) {
        //     if ($isBookingExist2) {
        //         // Jika sudah ada acara yang terjadwal, maka kembali ke halaman sebelumnya dengan pesan error
        //         $request->session()->flash('message', 'Jam Sudah Terbooking Untuk Rapat Urgensi');
        //         $request->session()->flash('message-class', 'danger');
        //         return redirect()->route('booking', ['id' => $ruangan->id]);
        //     }
        //      // Jika sudah ada acara yang terjadwal, maka kembali ke halaman sebelumnya dengan pesan error
        //      $request->session()->flash('message', 'Jam Sudah Terbooking Oleh User Lain - Pastikan Booking Jam Mulai Minimal 15 Menit Setelah Acara Rapat Lain Selesai');
        //      $request->session()->flash('message-class', 'danger');
        //      return redirect()->route('booking', ['id' => $ruangan->id]);
        // }

        if ($isBookingExist) {
            // Jika sudah ada acara yang terjadwal, maka kembali ke halaman sebelumnya dengan pesan error
            $request->session()->flash('message', 'Jam Sudah Terbooking Oleh User Lain - Pastikan Booking Jam Mulai Minimal 30 Menit Setelah Acara Rapat Lain Selesai');
            $request->session()->flash('message-class', 'danger');
            return redirect()->route('booking', ['id' => $ruangan->id]);
        }

        $acara = new Acara();
        $acara->id_user = auth()->user()->id;
        $acara->id_ruangan = $ruangan->id;
        $acara->nama_rapat = $namaRapat;
        $acara->tanggal = $tanggalAcara;
        $acara->jam_mulai = $jamMulai;
        $acara->jam_selesai = $jamSelesai;
        $acara->jumlah_orang = $jumlahOrang;
        $acara->undangan = $undangan;
        $acara->tv = $request->tv;
        $acara->sound = $request->sound;
        $acara->snack_pagi = $request->snack_pagi;
        $acara->snack_siang = $request->snack_siang;
        $acara->makan_siang = $request->makan_siang;
        $acara->keterangan = $keterangan;
        $acara->pesan = '-';
        $acara->status = 0;
        $acara->save();
        // $request->session()->flash('message', 'Berhasil Menambahkan Jadwal');
        // $request->session()->flash('message-class', 'primary');
        return redirect()->route('admin.book.page')->withSuccess('Berhasil Membooking!');
        // $undangan = $request->file('undangan');
        // $undangan_path = $undangan->storeAs('private/uploads/undangan', 'proyek_kontrak_'.$acara->id.'.pdf');
        // $acara->undangan = basename($undangan_path);
        // $acara->save();

        // $acara = Acara::find($id);
        // // $waktu = new Waktu();
        // $acara->id_user = auth()->user()->id;
        // $acara->id_ruangan = $ruangan->id;
        // $acara->nama_rapat = $request->nama_rapat;
        // $acara->tanggal = $request->tanggal;
        // $acara->jam_mulai = $request->jam_mulai;
        // $acara->jam_selesai = $request->jam_selesai;
        // $acara->jumlah_peserta = $request->jumlah_peserta;
        // $acara->keterangan = $request->keterangan;
        // $acara->status = 0;
        // $acara->save();
        // return redirect()->route('admin');
    }

    public function acaraDeleteDo($id)
    {
        $acaras = Acara::find($id);
        // dd($acaras->undangan);
        if ($acaras->undangan) {
            Storage::delete($acaras->undangan);
        }
        $acaras->delete();
        // $request->session()->flash('message', 'Berhasil Menghapus Data');
        // $request->session()->flash('message-class', 'success');

        return redirect()->route('admin.book.page')->withSuccess('Berhasil Menghapus Data!');
    }

    public function booked()
    {
        $acaras = Acara::orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')->get();
        return view('admin.acara.booked', compact('acaras'));
    }

    public function bookedCancleDo(Request $request, $id)
    {
        // $pesan = $request->input('pesan');
        // dd($request);
        $acara = Acara::find($id);
        if (!$acara) {
            abort(404);
        }
        $request->validate([
            'pesan' => 'required',
        ]);
        $acara->status = 1;
        $acara->pesan = $request->pesan;
        $acara->save();
        return redirect()->route('admin.booked')->withSuccess('Berhasil Membatalkan!');
    }

    public function bookedCancleBatalDo($id)
    {
        $acara = Acara::find($id);
        if (!$acara) {
            abort(404);
        }
        $acara->status = 0;
        $acara->pesan = "-";
        $acara->save();
        return redirect()->route('admin.booked')->withSuccess('Berhasil Membatalkan!');
    }

    public function ruangan()
    {
        $ruangans = Ruangan::all();
        return view('admin.ruangan.ruangan', compact('ruangans'));
    }

    public function ruanganAdd()
    {
        return view('admin.ruangan.form');
    }


    public function ruanganAddDo(Request $request)
    {
        $validatedData = $request->validate([
            'nama_ruangan' => 'required',
            'kapasitas' => 'required|numeric',
            'gambar' => 'required|image|mimes:jpeg,png,jpg',
            'status' => 'required'
        ]);

        $gambar = $request->file('gambar');
        $gambarName = $gambar->getClientOriginalName();
        $gambar->move(public_path('storage/upload/'), $gambarName);

        $ruangan = new Ruangan;
        $ruangan->nama_ruangan = $validatedData['nama_ruangan'];
        $ruangan->kapasitas = $validatedData['kapasitas'];
        $ruangan->gambar = $gambarName;
        $ruangan->status = $validatedData['status'];
        $ruangan->save();

        return redirect()->route('admin.ruangan')->withSuccess('Berhasil Menambah Data!');
    }

    public function ruanganDeleteDo($id)
    {
        $ruangans = Ruangan::find($id);
        if ($ruangans->gambar) {

            Storage::delete('public/upload/' . $ruangans->gambar);
        }
        $ruangans->delete();
        return redirect()->route('admin.ruangan')->withSuccess('Berhasil Menghapus Data!');
    }

    public function ruanganMaintainDo($id)
    {
        $ruangan = Ruangan::find($id);
        $ruangan->status = 2;
        $ruangan->save();
        return redirect()->route('admin.ruangan')->withSuccess('Berhasil Mengubah Data!');
    }

    public function ruanganReadyDo($id)
    {
        $ruangan = Ruangan::find($id);
        $ruangan->status = 1;
        $ruangan->save();
        return redirect()->route('admin.ruangan')->withSuccess('Berhasil Mengubah Data!');
    }
}
