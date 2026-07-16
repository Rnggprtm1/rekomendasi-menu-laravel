<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $validUser = $request->username === env('ADMIN_USERNAME');
        $validPass = $request->password === env('ADMIN_PASSWORD');

        if ($validUser && $validPass) {
            session(['admin_logged_in' => true, 'admin_name' => env('ADMIN_USERNAME')]);
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali! 👋');
        }

        return back()->with('error', 'Username atau password salah.')->withInput(['username' => $request->username]);
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_name']);
        return redirect()->route('admin.login')->with('success', 'Berhasil logout.');
    }
}
