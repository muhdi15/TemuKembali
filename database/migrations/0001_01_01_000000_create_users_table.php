<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ========================
        // 1. USERS (PENGGUNA)
        // ========================
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_pengguna'); // pakai id_pengguna sebagai PK
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->rememberToken();
            $table->timestamps();
        });

        // ========================
        // 2. LAPORAN HILANG
        // ========================
        Schema::create('laporan_hilang', function (Blueprint $table) {
            $table->id('id_laporan_hilang');
            $table->unsignedBigInteger('id_pengguna');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('users')->onDelete('cascade');
            $table->string('nama_barang');
            $table->text('deskripsi')->nullable();
            $table->string('lokasi_hilang');
            $table->date('tanggal_hilang');
            $table->string('foto')->nullable();
            $table->enum('kategori', ['Elektronik', 'Kendaraan', 'Dokumen', 'Pakaian', 'Tas', 'Kunci', 'Lainnya'])->default('Lainnya');
            $table->enum('status', ['pending', 'terverifikasi', 'ditutup'])->default('pending');
            $table->timestamps();
        });

        // ========================
        // 3. LAPORAN TEMUAN
        // ========================
        Schema::create('laporan_temuan', function (Blueprint $table) {
            $table->id('id_laporan_temuan');
            $table->unsignedBigInteger('id_pengguna');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('users')->onDelete('cascade');
            $table->string('nama_barang');
            $table->text('deskripsi')->nullable();
            $table->string('lokasi_temuan');
            $table->date('tanggal_temuan');
            $table->string('foto')->nullable();
            $table->enum('kategori', ['Elektronik', 'Kendaraan', 'Dokumen', 'Pakaian', 'Tas', 'Kunci', 'Lainnya'])->default('Lainnya');
            $table->enum('status', ['pending', 'terverifikasi', 'ditutup'])->default('pending');
            $table->timestamps();
        });

        // ========================
        // 4. PENCOCOKAN
        // ========================
        Schema::create('pencocokan', function (Blueprint $table) {
            $table->id('id_pencocokan');
            $table->unsignedBigInteger('id_laporan_hilang');
            $table->unsignedBigInteger('id_laporan_temuan');
            $table->foreign('id_laporan_hilang')->references('id_laporan_hilang')->on('laporan_hilang')->onDelete('cascade');
            $table->foreign('id_laporan_temuan')->references('id_laporan_temuan')->on('laporan_temuan')->onDelete('cascade');
            $table->enum('hasil_pencocokan', ['cocok', 'tidak'])->default('tidak');
            $table->enum('status', ['belum_dikonfirmasi', 'selesai'])->default('belum_dikonfirmasi');
            $table->date('tanggal_pencocokan')->useCurrent();
            $table->timestamps();
        });

        // ========================
        // 5. NOTIFIKASI
        // ========================
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->unsignedBigInteger('id_pengguna');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('users')->onDelete('cascade');
            $table->text('pesan');
            $table->date('tanggal_kirim')->useCurrent();
            $table->enum('status_baca', ['belum', 'dibaca'])->default('belum');
            $table->timestamps();
        });

        // ========================
        // 6. VERIFIKASI / PUBLIKASI
        // ========================
        Schema::create('verifikasi', function (Blueprint $table) {
            $table->id('id_verifikasi');
            $table->unsignedBigInteger('id_admin');
            $table->foreign('id_admin')->references('id_pengguna')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_laporan');
            $table->enum('jenis_laporan', ['hilang', 'temuan']);
            $table->enum('hasil_verifikasi', ['valid', 'invalid'])->default('valid');
            $table->date('tanggal_verifikasi')->useCurrent();
            $table->timestamps();
        });

        // ========================
        // 7. PASSWORD RESET TOKENS
        // ========================
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // ========================
        // 8. SESSIONS
        // ========================
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verifikasi');
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('pencocokan');
        Schema::dropIfExists('laporan_temuan');
        Schema::dropIfExists('laporan_hilang');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
