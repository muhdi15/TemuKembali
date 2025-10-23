<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pencocokan extends Model
{
    use HasFactory;

    protected $table = 'pencocokan';
    protected $primaryKey = 'id_pencocokan';

    protected $fillable = [
        'id_laporan_hilang',
        'id_laporan_temuan',
        'hasil_pencocokan',
        'tanggal_pencocokan',
    ];

    // ========================
    // 🔗 RELASI
    // ========================

    // Setiap pencocokan terkait dengan 1 laporan hilang
    public function laporanHilang()
    {
        return $this->belongsTo(LaporanHilang::class, 'id_laporan_hilang', 'id_laporan_hilang');
    }

    // Setiap pencocokan terkait dengan 1 laporan temuan
    public function laporanTemuan()
    {
        return $this->belongsTo(LaporanTemuan::class, 'id_laporan_temuan', 'id_laporan_temuan');
    }
}
