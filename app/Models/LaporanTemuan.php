<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanTemuan extends Model
{
    use HasFactory;

    protected $table = 'laporan_temuan';
    protected $primaryKey = 'id_laporan_temuan';

    protected $fillable = [
        'id_pengguna',
        'nama_barang',
        'deskripsi',
        'lokasi_temuan',
        'tanggal_temuan',
        'foto',
        'kategori',
        'status',
    ];

    // ========================
    // 🔗 RELASI
    // ========================

    // Laporan temuan milik satu pengguna
    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id_pengguna');
    }

    // Satu laporan temuan bisa punya banyak pencocokan
    public function pencocokan()
    {
        return $this->hasMany(Pencocokan::class, 'id_laporan_temuan');
    }
}
