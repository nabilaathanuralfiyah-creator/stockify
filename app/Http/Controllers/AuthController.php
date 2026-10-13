<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Tampilkan Halaman Login
     */
    public function showLogin()
    {
        // Jika sudah login, langsung arahkan ke dashboard
        if (Session::has('user')) {
            return redirect()->route('products.index');
        }
        
        return view('auth.login');
    }

    /**
     * Proses Login dengan Validasi Email & Password (12345678)
     */
    public function login(Request $request)
    {
        $email = trim($request->input('email'));
        $password = $request->input('password');

        // Daftar akun yang diizinkan beserta rolenya
        $usersMap = [
            'admin@stockify.com' => [
                'name' => 'Administrator', 
                'role' => 'admin', 
                'email' => 'admin@stockify.com'
            ],
            'manager@stockify.com' => [
                'name' => 'Manager Stock', 
                'role' => 'manager', 
                'email' => 'manager@stockify.com'
            ],
            'staff@stockify.com' => [
                'name' => 'Staff Gudang', 
                'role' => 'staff', 
                'email' => 'staff@stockify.com'
            ],
        ];

        // Cek apakah email terdaftar DAN password-nya harus benar (12345678)
        if (array_key_exists($email, $usersMap) && $password === '12345678') {
            $userData = $usersMap[$email];

            // Simpan data ke dalam session login
            Session::put('user', $userData);

            return redirect()->route('products.index')
                             ->with('success', 'Selamat datang kembali, ' . $userData['name']);
        }

        // Jika email atau password salah, kembalikan ke halaman login dengan pesan eror
        return back()->withInput($request->only('email'))
                     ->withErrors([
                         'email' => 'Email atau password salah / tidak terdaftar.'
                     ]);
    }

    /**
     * Proses Logout / Keluar Akun
     */
    public function logout(Request $request)
    {
        // Hapus sesi pengguna
        Session::forget('user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
                         ->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}