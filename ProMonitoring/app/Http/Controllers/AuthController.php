<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Menampilkan halaman landing
    public function landing()
    {
        return view('landing');  // Pastikan Anda memiliki file landing.blade.php
    }

    // Menampilkan halaman login
    public function login()
    {
        return view('login');  // Pastikan Anda memiliki file login.blade.php
    }

    // Proses login
    public function postLogin(Request $request)
    {
        // Validasi input login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Cek kredensial login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Jika login berhasil, arahkan ke dashboard
            return redirect()->route('dashboard');
        }

        // Jika gagal login, kembali dengan pesan error
        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    // Menampilkan halaman register
    public function register()
    {
        return view('register');  // Pastikan Anda memiliki file register.blade.php
    }

    // Proses registrasi
    public function postRegister(Request $request)
    {
        // Validasi input registrasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Menyimpan data user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Login otomatis setelah registrasi
        Auth::login($user);

        // Setelah berhasil registrasi, arahkan ke dashboard
        return redirect()->route('dashboard');
    }

    // Logout pengguna
    public function logout()
    {
        Auth::logout();
        return redirect()->route('landing'); // Redirect ke halaman landing setelah logout
    }
}
