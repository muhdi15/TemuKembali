<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\LaporanHilang;
use App\Models\LaporanTemuan;
use App\Models\Pencocokan;
use App\Models\Notifikasi;
use App\Models\Verifikasi;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ========================
        // 1. BUAT USER (ADMIN + USER)
        // ========================
        $admin = User::create([
            'nama' => 'Admin Sistem',
            'email' => 'admin@temukembali.com',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $users = collect();
        for ($i = 1; $i <= 4; $i++) {
            $users->push(User::create([
                'nama' => 'User ' . $i,
                'email' => 'user' . $i . '@mail.com',
                'username' => 'user' . $i,
                'password' => Hash::make('password'),
                'role' => 'user',
            ]));
        }

        // ========================
        // 2. BUAT LAPORAN KEHILANGAN
        // ========================
        $kategori = ['Elektronik', 'Kendaraan', 'Dokumen', 'Tas', 'Kunci'];
        $laporanHilang = collect();

        foreach (range(1, 5) as $i) {
            $laporanHilang->push(LaporanHilang::create([
                'id_pengguna' => $users->random()->id_pengguna,
                'nama_barang' => "Barang Hilang $i",
                'deskripsi' => "Deskripsi barang hilang ke-$i",
                'lokasi_hilang' => "Lokasi Hilang $i",
                'tanggal_hilang' => now()->subDays(rand(1, 15)),
                'foto' => null,
                'kategori' => $kategori[array_rand($kategori)],
                'status' => 'pending',
            ]));
        }

        // ========================
        // 3. BUAT LAPORAN TEMUAN (3 dari 5)
        // ========================
        $laporanTemuan = collect();

        foreach (range(1, 3) as $i) {
            $laporanTemuan->push(LaporanTemuan::create([
                'id_pengguna' => $users->random()->id_pengguna,
                'nama_barang' => "Barang Ditemukan $i",
                'deskripsi' => "Barang ditemukan mirip dengan laporan kehilangan $i",
                'lokasi_temuan' => "Lokasi Temuan $i",
                'tanggal_temuan' => now()->subDays(rand(1, 10)),
                'foto' => null,
                'kategori' => $kategori[array_rand($kategori)],
                'status' => 'pending',
            ]));
        }

        // ========================
        // 4. PENCOCOKAN (3 data cocok)
        // ========================
        foreach ($laporanTemuan as $index => $temuan) {
            $laporanHilangTerkait = $laporanHilang[$index];

            Pencocokan::create([
                'id_laporan_hilang' => $laporanHilangTerkait->id_laporan_hilang,
                'id_laporan_temuan' => $temuan->id_laporan_temuan,
                'hasil_pencocokan' => 'cocok',
                'tanggal_pencocokan' => now(),
            ]);

            // Tambahkan notifikasi untuk pelapor kehilangan
            Notifikasi::create([
                'id_pengguna' => $laporanHilangTerkait->id_pengguna,
                'pesan' => "Barang '{$laporanHilangTerkait->nama_barang}' kemungkinan telah ditemukan di laporan '{$temuan->nama_barang}'.",
                'tanggal_kirim' => now(),
                'status_baca' => 'belum',
            ]);
        }

        // ========================
        // 5. VERIFIKASI OLEH ADMIN
        // ========================
        foreach ($laporanHilang as $hilang) {
            Verifikasi::create([
                'id_admin' => $admin->id_pengguna,
                'id_laporan' => $hilang->id_laporan_hilang,
                'jenis_laporan' => 'hilang',
                'hasil_verifikasi' => 'valid',
                'tanggal_verifikasi' => now(),
            ]);
        }

        foreach ($laporanTemuan as $temuan) {
            Verifikasi::create([
                'id_admin' => $admin->id_pengguna,
                'id_laporan' => $temuan->id_laporan_temuan,
                'jenis_laporan' => 'temuan',
                'hasil_verifikasi' => 'valid',
                'tanggal_verifikasi' => now(),
            ]);
        }

        // ========================
        // 6. NOTIFIKASI TAMBAHAN
        // ========================
        Notifikasi::create([
            'id_pengguna' => $admin->id_pengguna,
            'pesan' => 'Sistem berhasil melakukan seed data simulasi pelaporan.',
            'tanggal_kirim' => now(),
            'status_baca' => 'belum',
        ]);
    }
}
