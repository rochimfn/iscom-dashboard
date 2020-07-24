## ISCOM Dashboard

**ISCOM**, Information System Competition, merupakan kompetisi internal pada jurusan sistem informasi ITS. Dalam rangka mempermudah dalam manajemen peserta, juri dan submisi dibuatlah web ini. Web ini dibuat dengan menggunakan [laravel 7](laravel.com) dan admin panel [AdminLTE](https://github.com/jeroennoten/Laravel-AdminLTE/blob/master/README.md).

## Instalasi

Sebelum instalasi pastikan sistem operasi yang digunakan sudah memenuhi [System Requirement](https://laravel.com/docs/7.x#server-requirements) Laravel, memiliki DBMS yang didukung oleh Laravel serta telah terpasang [Composer](https://laravel.com/docs/7.x#server-requirements) dan Git.

Gunakan perintah berikut untuk mengunduh kode sumber dan memasang dependensi.

```
git clone https://github.com/rochimfn/iscom-dashboard.git
cd iscom-dashboard
composer install
composer dump
```

Salin `.env.example` menjadi `.env`
```
cp .env.example .env //Pada sistem operasi *nix
copy .env.example .env //Pada sistem operasi Windows
```

Konfigurasi yang wajib diatur meliputi *APP_\**, *DB_\**, dan *MAIL_\**. APP_KEY dapat digenerate dengan perintah berikut.
```
php artisan key:generate
```

Konfigurasi selesai. Gunakan perintah berikut untuk memigrasi database dan melakukan seeding.
```
php artisan migrate --seed
```

Pada tahap ini instalasi telah selesai dan secara default akan terdapat satu akun administrator dengan username `adminnich` dan password `password` yang dapat diganti setelah login.