<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanHilang extends Model
{
    use HasFactory;

    protected $table = 'laporan_hilang';
    protected $primaryKey = 'id_laporan_hilang';

    protected $fillable = [
        'id_pengguna',
        'nama_barang',
        'deskripsi',
        'lokasi_hilang',
        'tanggal_hilang',
        'foto',
        'kategori',
        'status',
    ];

    // ========================
    // 🔗 RELASI
    // ========================

    // Laporan hilang milik satu pengguna
    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id_pengguna');
    }

    // Satu laporan hilang bisa punya banyak pencocokan
    public function pencocokan()
    {
        return $this->hasMany(Pencocokan::class, 'id_laporan_hilang');
    }
}
