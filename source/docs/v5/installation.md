---
title: Installation
description: One small step for a man, one giant leap for mankind
extends: _layouts.documentation
section: content
---

# Installation

## Server Requirements

1. PHP >= 8.0
1. Laravel >= 8.0
2. MySQL, MariaDB, PostgreSQL, atau SQLite
3. BCMath PHP Extension
4. Ctype PHP Extension
5. GD PHP Extension
6. JSON PHP Extension
7. Mbstring PHP Extension
8. OpenSSL PHP Extension
9. PDO PHP Extension
10. Tokenizer PHP Extension
11. XML PHP Extension

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

Sebagaimana diketahui, untuk menjalankan aplikasi PHP dibutuhkan sebuah ***web server***. Jika kamu sudah meng-install PHP, maka kamu bisa memanfaatkan server bawaan PHP. Cukup jalankan perintah:

```bash
php artisan serve
```

Selanjutkan aplikasimu bisa diakses di http://localhost:8000. Login dengan user admin yang sudah dibuat sebelumnya.

Selamat, kamu berhasil meng-install Laravolt!

Jika membutuhkan development server yang lebih lengkap dan bisa diutak-atik, silakan mencoba beberapa alternatif berikut ini:

1. [Laragon](https://laragon.org/)
2. [XAMPP](https://www.apachefriends.org/index.html)
3. [WampServer](http://www.wampserver.com/en)
4. [Laravel Homestead](https://laravel.com/docs/8.x/homestead)
5. [Laravel Valet](https://laravel.com/docs/8.x/valet)
6. [Vessel (Docker for Laravel)](https://vessel.shippingdocker.com/)
6. [Laradock)](https://laradock.io/)
