<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Ruangan, Acara, User};
use Carbon;
use Storage;

class UserController extends Controller
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
        return view('user.user_book', compact('acaras'));
    }

    public function booking($id)
    {
        $now = Carbon::now()->toDateString();
        $end =  Carbon::now()->addDays(3)->toDateString();

        $ruangan = Ruangan::find($id);
        $acaras = Acara::orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->where('tanggal', '>', $now)
            ->where('tanggal', '>=', $end)
            ->where('id_ruangan', $id)
            ->get();
        return view('user.form', compact('ruangan', 'acaras'));
    }

    public function bookingDo(Request $request, $id)
    {
        $ruangan = Ruangan::find($id);
        if (!$ruangan) {
            abort(404);
        }
        // if ($ruangan->id_user != auth()->user()->id){
        //     abort(403);
        // }
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
        // $isBookingExist2 = Acara::where('status','=',1)->exists();

        if ($jamMulai >= $jamSelesai) {
            $request->session()->flash('message', 'Pastikan anda memasukan jam mulai dan jam selesai dengan benar!');
            $request->session()->flash('message-class', 'danger');
            return redirect()->route('user.booking', ['id' => $ruangan->id]);
        }

        // if ($isBookingExist) {
        //     if ($isBookingExist2) {
        //         // Jika sudah ada acara yang terjadwal, maka kembali ke halaman sebelumnya dengan pesan error
        //         $request->session()->flash('message', 'Jam Sudah Terbooking Untuk Rapat Urgensi');
        //         $request->session()->flash('message-class', 'danger');
        //         return redirect()->route('admin.booking', ['id' => $ruangan->id]);
        //     }
        //      // Jika sudah ada acara yang terjadwal, maka kembali ke halaman sebelumnya dengan pesan error
        //      $request->session()->flash('message', 'Jam Sudah Terbooking Oleh User Lain - Pastikan Booking Jam Mulai Minimal 15 Menit Setelah Acara Rapat Lain Selesai');
        //      $request->session()->flash('message-class', 'danger');
        //      return redirect()->route('admin.booking', ['id' => $ruangan->id]);
        // }

        if ($isBookingExist) {
            // Jika sudah ada acara yang terjadwal, maka kembali ke halaman sebelumnya dengan pesan error
            $request->session()->flash('message', 'Jam Sudah Terbooking Oleh User Lain - Pastikan Booking Jam Mulai Minimal 30 Menit Setelah Acara Rapat Lain Selesai');
            $request->session()->flash('message-class', 'danger');
            return redirect()->route('user.booking', ['id' => $ruangan->id]);
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
        return redirect()->route('user.book.page')->withSuccess('Berhasil Membooking!');
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

    public function acaraEdit($id)
    {
        $acara = Acara::find($id);
        if (!$acara) {
            abort(404);
        }
        return view('user.edit_acara', compact('acara'));
    }

    public function acaraEditDo(Request $request, $id)
    {
        $acara = Acara::find($id);
        if (!$acara) {
            abort(404);
        }
        $validatedData = $request->validate([
            'nama_rapat' => 'required',
            'tanggal' => 'nullable|date',
            'jam_mulai' => 'nullable',
            'jam_selesai' => 'nullable',
            'jumlah_orang' => 'required',
        ]);
        $namaRapat = $validatedData['nama_rapat'];
        $jumlahOrang = $validatedData['jumlah_orang'];
        $keterangan = $request->keterangan;

        $acara->id_user = auth()->user()->id;
        $acara->id_ruangan = $acara->ruangan->id;
        $acara->nama_rapat = $namaRapat;
        $acara->jumlah_orang = $jumlahOrang;
        $acara->tv = $request->tv;
        $acara->sound = $request->sound;
        $acara->snack_pagi = $request->snack_pagi;
        $acara->snack_siang = $request->snack_siang;
        $acara->makan_siang = $request->makan_siang;
        $acara->keterangan = $keterangan;
        $acara->save();
        // $request->session()->flash('message', 'Berhasil Menambahkan Jadwal');
        // $request->session()->flash('message-class', 'primary');
        return redirect()->route('user.book.page')->withSuccess('Berhasil Mengubah Data!');
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

        return redirect()->route('user.book.page')->withSuccess('Berhasil Menghapus Data!');
    }
}
