<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LaporanHilang;
use App\Models\LaporanTemuan;
use App\Models\Pencocokan;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Data ringkasan (statistik)
        $jumlahUser = User::count();
        $jumlahHilang = LaporanHilang::count();
        $jumlahTemuan = LaporanTemuan::count();
        $jumlahPencocokan = Pencocokan::count();

        // Ambil laporan terbaru
        $laporanTerbaru = LaporanHilang::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'jumlahUser',
            'jumlahHilang',
            'jumlahTemuan',
            'jumlahPencocokan',
            'laporanTerbaru'
        ));
    }

    public function pengguna()
    {
        $pengguna = User::orderBy('created_at', 'desc')->get();
        return view('admin.pengguna', compact('pengguna'));
    }

    // Tambah pengguna baru
    public function storePengguna(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|max:50|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,user',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan.');
    }

    // Update data pengguna
    public function updatePengguna(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id_pengguna . ',id_pengguna',
            'username' => 'required|string|max:50|unique:users,username,' . $user->id_pengguna . ',id_pengguna',
            'role' => 'required|in:admin,user',
        ]);

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'username' => $request->username,
            'role' => $request->role,
        ]);

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->back()->with('success', 'Data pengguna berhasil diperbarui.');
    }

    // Hapus pengguna
    public function destroyPengguna($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
    }


    public function laporanHilang()
    {
        $laporan = LaporanHilang::with('pengguna')->orderBy('created_at', 'desc')->get();
        return view('admin.laporan-hilang', compact('laporan'));
    }

    public function storeLaporanHilang(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lokasi_hilang' => 'required|string|max:255',
            'tanggal_hilang' => 'required|date',
            'kategori' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('laporan_hilang', 'public');
        }

        LaporanHilang::create([
            'id_pengguna' => auth()->user()->id_pengguna,
            'nama_barang' => $request->nama_barang,     
            'deskripsi' => $request->deskripsi,
            'lokasi_hilang' => $request->lokasi_hilang,
            'tanggal_hilang' => $request->tanggal_hilang,
            'kategori' => $request->kategori,
            'foto' => $path,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Laporan kehilangan berhasil ditambahkan.');
    }

    public function updateLaporanHilang(Request $request, $id)
    {
        $laporan = LaporanHilang::findOrFail($id);

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lokasi_hilang' => 'required|string|max:255',
            'tanggal_hilang' => 'required|date',
            'kategori' => 'required|string',
            'status' => 'required|string|in:pending,terverifikasi,ditutup',
            'foto' => 'nullable|image|max:2048',
        ]);

        $path = $laporan->foto;
        if ($request->hasFile('foto')) {
            if ($path) Storage::disk('public')->delete($path);
            $path = $request->file('foto')->store('laporan_hilang', 'public');
        }

        $laporan->update([
            'nama_barang' => $request->nama_barang,
            'deskripsi' => $request->deskripsi,
            'lokasi_hilang' => $request->lokasi_hilang,
            'tanggal_hilang' => $request->tanggal_hilang,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'foto' => $path,
        ]);

        return redirect()->back()->with('success', 'Laporan kehilangan berhasil diperbarui.');
    }

    public function destroyLaporanHilang($id)
    {
        $laporan = LaporanHilang::findOrFail($id);
        if ($laporan->foto) Storage::disk('public')->delete($laporan->foto);
        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan kehilangan berhasil dihapus.');
    }
}
