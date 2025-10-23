<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Menampilkan form registrasi
     */
    public function showForm()
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi user baru
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'required' => ':attribute wajib diisi.',
            'email' => 'Format email tidak valid.',
            'unique' => ':attribute sudah terdaftar.',
            'confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect()->route('register.form')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
