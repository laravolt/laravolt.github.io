---
title: Installation
description: One small step for a man, one giant leap for mankind
extends: _layouts.documentation
section: content
---

# Installation

## Server Requirements

1. PHP >= 8.2
1. Laravel >= 11.0
1. SQLite, MySQL, MariaDB, atau PostgreSQL
1. PHP Extensions:
   - BCMath - Untuk perhitungan matematika presisi tinggi
   - Ctype - Untuk validasi tipe karakter
   - cURL - Untuk membuat HTTP requests ke layanan eksternal
   - DOM - Untuk manipulasi dokumen XML/HTML
   - Exif - Untuk membaca metadata dari file gambar
   - Fileinfo - Untuk deteksi tipe MIME
   - Filter - Untuk sanitasi dan validasi data
   - GD - Untuk manipulasi gambar (diperlukan fitur media dan avatar)
   - Hash - Untuk hashing dan enkripsi
   - Iconv - Untuk konversi encoding karakter
   - JSON - Untuk pemrosesan data JSON
   - Libxml - Diperlukan untuk ekstensi DOM dan XML
   - Mbstring - Untuk penanganan string multibyte
   - OpenSSL - Untuk enkripsi dan fitur keamanan
   - PCRE - Untuk regular expressions
   - PDO - Untuk koneksi database
   - Session - Untuk manajemen session user
   - Tokenizer - Untuk pemrosesan PHP code
   - XML - Untuk pemrosesan data XML dan API responses
   - XMLWriter - Untuk menghasilkan file XML
   - Zip - Untuk kompresi dan dekompresi file
   - Zlib - Untuk kompresi data

### Cara Memeriksa PHP Extensions

Ada beberapa cara untuk memeriksa ekstensi PHP yang terinstal pada sistem kamu:

1. **Melalui Terminal/Command Line**:

   ```bash
   php -m
   ```

   Perintah ini akan menampilkan daftar semua ekstensi PHP yang terinstall.

2. **Melalui Script PHP**:
   Buat file bernama `phpinfo.php` dengan konten berikut:

   ```php
   <?php phpinfo(); ?>
   ```

   Letakkan file tersebut di direktori web server kamu dan akses melalui browser.

3. **Melalui Composer pada Project Laravolt**:
   ```bash
   composer check-platform-reqs
   ```
   Perintah ini akan memeriksa apakah sistem kamu memenuhi semua kebutuhan platform dari packages yang terinstall.

### Cara Menginstall PHP Extensions

Berikut cara instalasi ekstensi PHP yang umum digunakan pada berbagai sistem operasi:

#### Pada Ubuntu/Debian:

```bash
sudo apt-get update
sudo apt-get install php8.2-bcmath php8.2-curl php8.2-xml php8.2-gd php8.2-mbstring php8.2-zip
# Ganti 8.2 dengan versi PHP yang kamu gunakan
```

#### Pada CentOS/RHEL:

```bash
sudo yum install php-bcmath php-curl php-xml php-gd php-mbstring php-zip
```

#### Pada macOS (menggunakan Homebrew):

```bash
brew install php
# PHP dari Homebrew biasanya sudah menyertakan sebagian besar ekstensi yang dibutuhkan
```

#### Pada Windows (XAMPP/WAMP):

Sebagian besar ekstensi sudah diaktifkan secara default. Untuk mengaktifkan ekstensi tambahan:

1. Buka file `php.ini` (biasanya terletak di folder instalasi PHP)
2. Cari baris yang berisi nama ekstensi (contoh: `;extension=gd`)
3. Hapus tanda titik koma (`;`) di awal baris untuk mengaktifkan ekstensi tersebut
4. Restart web server

### Troubleshooting Umum

1. **Error "Call to undefined function"**:
   Pesan error ini biasanya menunjukkan bahwa ekstensi PHP yang dibutuhkan belum terinstall atau belum diaktifkan.

2. **Error saat instalasi Composer**:

   ```
   Problem 1
       - laravolt/laravolt requires ext-gd * -> the requested PHP extension gd is missing from your system.
   ```

   Solusi: Install ekstensi yang diminta menggunakan petunjuk di atas.

3. **Error pada gambar atau avatar**:
   Jika fitur manipulasi gambar tidak berfungsi, pastikan ekstensi GD terinstall dengan benar:

   ```bash
   php -m | grep gd
   ```

   Jika tidak ada output, artinya ekstensi GD belum terinstall.

4. **Mengecek versi PHP**:
   ```bash
   php --version
   ```
   Pastikan menggunakan PHP 8.2 atau lebih tinggi untuk Laravolt v6.

## Instalasi Laravolt

**Laravolt** adalah sebuah package, oleh sebab itu kamu harus sudah punya aplikasi Laravel dulu sebelumnya. Instalasi Laravel bisa dibaca di [dokumentasi resminya](https://laravel.com/docs/master#installing-laravel).
Pastikan konfigurasi sudah benar dan halaman default Laravel sudah bisa diakses di browser.

Jika aplikasi Laravel sudah siap, lanjutkan dengan langkah-langkah berikut:

### 1. Install Package

```bash
composer require laravolt/laravolt
```

### 2. Setup Laravolt

Beberapa file perlu digenerate dan disesuaikan agar Laravolt berjalan dengan baik. Cukup jalankan perintah di bawah ini:

```bash
php artisan laravolt:install
```

### 3. Migrasi Database

Selanjutnya, jangan lupa menjalakan migration:

```bash
php artisan migrate
```

### 4. Menambahkan Admin

Untuk menambahkan user dengan role admin, bisa menjalankan perintah interaktif:

```bash
php artisan laravolt:admin
```

Atau, cara yang lebih singkat tanpa perlu menjawab pertanyaan satu persatu:

```bash
php artisan laravolt:admin Administrator admin@laravolt.dev secret
```

### 5. Local Development

Sebagaimana diketahui, untuk menjalankan aplikasi PHP dibutuhkan sebuah **_web server_**. Berikut beberapa cara untuk menjalankan Laravolt di lingkungan pengembangan lokal:

#### Menggunakan PHP Built-in Server dari Laravel

Cara paling sederhana untuk menjalankan aplikasi Laravel adalah dengan server development via PHP built-in server. Jalankan perintah berikut:

```bash
php artisan serve
```

Aplikasi bisa diakses di http://localhost:8000.

#### Menggunakan Script Composer

Sejak Laravel 11, terdapat script `dev` yang bisa digunakan untuk menjalankan beberapa service sekaligus. Jika kamu menggunakan Laravel 11.28 ke atas, cukup jalankan:

```bash
composer dev
```

Script ini akan menjalankan beberapa service sekaligus (Vite, queue worker, logs, webserver) dalam satu terminal.

<!-- TODO: Serve menggunakan docker-compose.yml, akan dibuatkan di malescast.com -->

#### Alternatif Tool Pengembangan Lokal

Jika membutuhkan development server yang lebih lengkap, silakan mencoba beberapa alternatif berikut:

1. [Laravel Herd](https://herd.laravel.com/) - Official development server dari Laravel
1. [Laragon](https://laragon.org/) - Rekomendasi untuk Windows, semua kebutuhan sudah terintegrasi
1. [XAMPP](https://www.apachefriends.org/index.html) - Populer untuk pemula
1. [WampServer](http://www.wampserver.com/en) - Alternatif untuk Windows
1. [Laravel Valet](https://laravel.com/docs/master/valet) - Khusus untuk macOS
1. [Laradock](https://laradock.io/) - Solusi Docker lengkap untuk ekosistem Laravel

### 6. Login ke Aplikasi

Setelah server berjalan, akses aplikasi melalui browser dan login menggunakan kredensial admin yang telah dibuat sebelumnya:

- URL: http://localhost:8000/auth/login
- Email: email yang diinput saat menjalankan command `laravolt:admin` (default: admin@laravolt.dev)
- Password: password yang diinput saat menjalankan command `laravolt:admin` (default: secret)

Selamat, kamu berhasil meng-install dan menjalankan Laravolt!
