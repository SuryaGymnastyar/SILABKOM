<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek input apakah berupa email atau npm?
        $fieldType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'npm';

        $remember = $request->has('remember');

        if (Auth::attempt([$fieldType => $credentials['login'], 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();

            // Dashboard tergantung role
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/dashboard')->with('success', 'Selamat datang kembali, Admin!');
            }

            return redirect()->intended('/dashboard')->with('success', 'Selamat datang di SILABKOM!');
        }

        return back()->withErrors([
            'login' => 'NPM/Email atau kata sandi yang dimasukkan salah.',
        ])->onlyInput('login');
    }

    // Halaman register mahasiswa
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Pendaftaran akun mahasiswa baru
    public function register(Request $request)
    {
        $validated = $request->validate([
            'npm'      => ['required', 'numeric', 'digits_between:8,15', 'unique:users,npm'],
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'npm.numeric'        => 'NPM harus berupa angka.',
            'npm.digits_between' => 'Panjang NPM harus antara 8 sampai 15 digit.',
            'npm.unique'         => 'NPM sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        User::create([
            'name'     => $validated['name'],
            'npm'      => $validated['npm'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'mahasiswa',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan masuk menggunakan NPM atau Email Anda.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}