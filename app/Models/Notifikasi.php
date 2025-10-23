<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';

    protected $fillable = [
        'id_pengguna',
        'pesan',
        'tanggal_kirim',
        'status_baca',
    ];

    // ========================
    // 🔗 RELASI
    // ========================

    // Setiap notifikasi dimiliki oleh satu pengguna
    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id_pengguna');
    }
}
