Berikut README.md yang lengkap, profesional, dan siap Anda pakai untuk project TemuKembali (Laravel).


---

Temu Kembali — Installation Guide

Dokumentasi ini berisi panduan lengkap untuk melakukan instalasi dan menjalankan project Temu Kembali berbasis Laravel dari GitHub.


---

1. Clone Repository

Pastikan Git sudah terpasang di komputer Anda.

git clone https://www.github.com/muhdi15/TemuKembali

Masuk ke folder project:

cd TemuKembali


---

2. Install Dependencies dengan Composer

Pastikan Composer sudah terpasang.

composer install


---

3. Salin File Environment

Laravel membutuhkan file .env untuk konfigurasi environment.

cp .env.example .env


---

4. Konfigurasi Database (.env)

Edit file .env dan ubah konfigurasi database agar menggunakan MySQL.

Contoh konfigurasi:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=temu_kembali
DB_USERNAME=root
DB_PASSWORD=

> Sesuaikan DB_DATABASE, DB_USERNAME, dan DB_PASSWORD dengan konfigurasi MySQL Anda.




---

5. Generate Application Key

php artisan key:generate


---

6. Jalankan Migrasi Database

php artisan migrate


---

7. Jalankan Seeder (Jika Ada Data Awal)

php artisan db:seed

Atau jika ingin menjalankan ulang semua data:

php artisan migrate:fresh --seed


---

8. Jalankan Server Laravel

php artisan serve

Akses aplikasi melalui:

http://127.0.0.1:8000


---

9. Selesai

Project Temu Kembali sekarang sudah berjalan dengan baik di environment lokal Anda.
Jika mengalami kendala instalasi, pastikan:

PHP minimal versi sesuai dengan requirement Laravel

Ekstensi PHP sudah lengkap (OpenSSL, PDO, Mbstring, dsb)

MySQL berjalan dengan baik



---

Jika Anda ingin, saya bisa menambahkan:

✅ Cara setup storage (php artisan storage:link)
✅ Cara konfigurasi queue / cron
✅ Cara menjalankan di hosting / VPS
✅ Cara install Node & Vite (jika project memakai)

Cukup beri tahu saja!

