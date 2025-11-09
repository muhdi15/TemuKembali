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
use Illuminate\Support\Str;
use Carbon\Carbon;

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


    // =======================
    // MANajemen Laporan Temuan Barang
    // =======================

    public function laporanTemuan()
    {
        $laporan = LaporanTemuan::with('pengguna')->orderBy('created_at', 'desc')->get();
        return view('admin.laporan-temuan', compact('laporan'));
    }

    public function storeLaporanTemuan(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lokasi_temuan' => 'required|string|max:255',
            'tanggal_temuan' => 'required|date',
            'kategori' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('laporan_temuan', 'public');
        }

        LaporanTemuan::create([
            'id_pengguna' => auth()->user()->id_pengguna,
            'nama_barang' => $request->nama_barang,
            'deskripsi' => $request->deskripsi,
            'lokasi_temuan' => $request->lokasi_temuan,
            'tanggal_temuan' => $request->tanggal_temuan,
            'kategori' => $request->kategori,
            'foto' => $path,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Laporan temuan berhasil ditambahkan.');
    }

    public function updateLaporanTemuan(Request $request, $id)
    {
        $laporan = LaporanTemuan::findOrFail($id);

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lokasi_temuan' => 'required|string|max:255',
            'tanggal_temuan' => 'required|date',
            'kategori' => 'required|string',
            'status' => 'required|string|in:pending,terverifikasi,ditutup',
            'foto' => 'nullable|image|max:2048',
        ]);

        $path = $laporan->foto;
        if ($request->hasFile('foto')) {
            if ($path) Storage::disk('public')->delete($path);
            $path = $request->file('foto')->store('laporan_temuan', 'public');
        }

        $laporan->update([
            'nama_barang' => $request->nama_barang,
            'deskripsi' => $request->deskripsi,
            'lokasi_temuan' => $request->lokasi_temuan,
            'tanggal_temuan' => $request->tanggal_temuan,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'foto' => $path,
        ]);

        return redirect()->back()->with('success', 'Laporan temuan berhasil diperbarui.');
    }

    public function destroyLaporanTemuan($id)
    {
        $laporan = LaporanTemuan::findOrFail($id);
        if ($laporan->foto) Storage::disk('public')->delete($laporan->foto);
        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan temuan berhasil dihapus.');
    }


    public function pencocokanIndex()
    {
        $laporanHilang = LaporanHilang::all();
        $laporanTemuan = LaporanTemuan::all();
        $pencocokanManual = Pencocokan::with(['laporanHilang', 'laporanTemuan'])->latest()->get();

        // Pencocokan Otomatis
        $rekomendasi = [];
        foreach ($laporanHilang as $hilang) {
            foreach ($laporanTemuan as $temuan) {
                $skor = $this->hitungKecocokan($hilang, $temuan);
                if ($skor >= 60) {
                    $rekomendasi[] = [
                        'hilang' => $hilang,
                        'temuan' => $temuan,
                        'skor' => round($skor, 1)
                    ];
                }
            }
        }

        return view('admin.pencocokan.index', compact('rekomendasi', 'pencocokanManual', 'laporanHilang', 'laporanTemuan'));
    }

    private function hitungKecocokan($hilang, $temuan)
    {
        similar_text(strtolower($hilang->nama_barang), strtolower($temuan->nama_barang), $skorNama);
        $skorKategori = $hilang->kategori == $temuan->kategori ? 100 : 0;
        similar_text(strtolower($hilang->lokasi_hilang), strtolower($temuan->lokasi_temuan), $skorLokasi);
        $selisihHari = abs(strtotime($hilang->tanggal_hilang) - strtotime($temuan->tanggal_temuan)) / 86400;
        $skorTanggal = max(0, 100 - ($selisihHari * 10));

        return ($skorNama * 0.45) + ($skorKategori * 0.25) + ($skorLokasi * 0.2) + ($skorTanggal * 0.1);
    }

    public function pencocokanSimpan(Request $request)
    {
        $request->validate([
            'id_laporan_hilang' => 'required|exists:laporan_hilang,id_laporan_hilang',
            'id_laporan_temuan' => 'required|exists:laporan_temuan,id_laporan_temuan',
            'hasil_pencocokan' => 'required|in:cocok,tidak',
        ]);

        Pencocokan::updateOrCreate(
            [
                'id_laporan_hilang' => $request->id_laporan_hilang,
                'id_laporan_temuan' => $request->id_laporan_temuan,
            ],
            [
                'hasil_pencocokan' => $request->hasil_pencocokan,
                'status' => 'belum_dikonfirmasi',
                'tanggal_pencocokan' => Carbon::now(),
            ]
        );

        return back()->with('success', 'Data pencocokan berhasil disimpan!');
    }

    public function pencocokanDetail($idHilang, $idTemuan)
    {
        $hilang = LaporanHilang::findOrFail($idHilang);
        $temuan = LaporanTemuan::findOrFail($idTemuan);
        $skor = $this->hitungKecocokan($hilang, $temuan);

        $pencocokan = Pencocokan::where('id_laporan_hilang', $idHilang)
            ->where('id_laporan_temuan', $idTemuan)
            ->first();

        return view('admin.pencocokan.detail', compact('hilang', 'temuan', 'skor', 'pencocokan'));
    }

    public function pencocokanKonfirmasi($id)
    {
        $pencocokan = Pencocokan::findOrFail($id);
        $pencocokan->status = 'selesai';
        $pencocokan->save();

        return back()->with('success', 'Pencocokan telah dikonfirmasi sebagai selesai (barang dikembalikan ke pemilik).');
    }

    public function pencocokanHapus($id)
    {
        Pencocokan::findOrFail($id)->delete();
        return back()->with('success', 'Data pencocokan berhasil dihapus!');
    }
}
