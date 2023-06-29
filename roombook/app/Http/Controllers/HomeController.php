<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use illuminate\support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        // $title = 'Home';
        $ruangans = Ruangan::all();
        return view('user.index', compact('ruangans'));
    }

    public function login()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->akses_level == 1) {
                return redirect()->route('home');
            } elseif ($user->akses_level == 2) {
                return redirect()->route('home');
            } 
        }
        return view('auth.login');
    }
    public function loginDo(Request $request)
    {
        request()->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->akses_level == 1) {
                return redirect()->route('admin')->withSuccess('Berhasil Login!');
            } elseif ($user->akses_level == 2) {
                return redirect()->route('user')->withSuccess('Berhasil Login!');
            } 
            return redirect()->route('home');
        }
        return redirect()->route('home.login')->with('error', "Username atau password salah");
    }

    public function logoutDo(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home.login')->with('error', "Berhasil Logout");
    }
}
