<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verifikasi extends Model
{
    use HasFactory;

    protected $table = 'verifikasi';
    protected $primaryKey = 'id_verifikasi';

    protected $fillable = [
        'id_admin',
        'id_laporan',
        'jenis_laporan',
        'hasil_verifikasi',
        'tanggal_verifikasi',
    ];

    // ========================
    // 🔗 RELASI
    // ========================

    // Verifikasi dilakukan oleh satu admin (user)
    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin', 'id_pengguna');
    }

    // Relasi dinamis (laporan bisa hilang atau temuan)
    public function laporan()
    {
        if ($this->jenis_laporan === 'hilang') {
            return $this->belongsTo(LaporanHilang::class, 'id_laporan', 'id_laporan_hilang');
        } else {
            return $this->belongsTo(LaporanTemuan::class, 'id_laporan', 'id_laporan_temuan');
        }
    }
}
