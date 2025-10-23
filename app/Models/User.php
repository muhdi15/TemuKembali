<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_pengguna';

    protected $fillable = [
        'nama',
        'email',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ========================
    // 🔗 RELASI
    // ========================

    // 1 user memiliki banyak laporan kehilangan
    public function laporanHilang()
    {
        return $this->hasMany(LaporanHilang::class, 'id_pengguna');
    }

    // 1 user memiliki banyak laporan temuan
    public function laporanTemuan()
    {
        return $this->hasMany(LaporanTemuan::class, 'id_pengguna');
    }

    // 1 user memiliki banyak notifikasi
    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'id_pengguna');
    }

    // 1 admin (user) melakukan banyak verifikasi
    public function verifikasiDibuat()
    {
        return $this->hasMany(Verifikasi::class, 'id_admin');
    }
}
