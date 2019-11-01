---
title: Installation
description: One small step for a man, one giat leap for mankind
extends: _layouts.documentation
section: content
---

# Installation

## Server Requirements

1. PHP >= 7.3
2. BCMath PHP Extension
3. Ctype PHP Extension
4. GD PHP Extension
5. JSON PHP Extension
6. Mbstring PHP Extension
7. OpenSSL PHP Extension
8. PDO PHP Extension
9. Tokenizer PHP Extension
10. XML PHP Extension

## Instalasi Laravolt

Laravolt membutuhkan [Composer](https://getcomposer.org/) dan koneksi internet untuk mendownload source code dari GitHub. Pastikan kamu mempunyai keduanya.

> Kamu tidak memerlukan akun GitHub untuk mulai menggunakan Laravolt.



### Aplikasi Baru

Jika kamu baru pertama kali memulai, jalankan perintah berikut untuk mengunduh source code Laravolt versi terbaru lengkap dengan semua modulnya:

```bash
composer create-project laravolt/laravolt
```



### Aplikasi Existing 

Jika kamu sudah meng-install Laravel sebelumnya, jalankan perintah berikut:

```bash
composer require laravolt/platform
```

Selanjutnya, perlu ada penyesuaian terhadap di level aplikasi. Kamu bisa melakukannya secara otomatis dengan menjalankan perintah:

```bash
php artisan preset laravolt
```

Metode instalasi ini hanya akan mengunduh *core* Laravolt saja. Jika kamu membutuhkan modul-modul lain, maka harus di-*install* lagi secara manual.

### Login Admin

Untuk menambahkan user dengan role admin, bisa menjalankan perintah:

```bash
php artisan laravolt:admin <name> <email> <password>
```



### Local Development

Sebagaimana diketahui, untuk menjalankan aplikasi PHP dibutuhkan sebuah ***web server***. Jika kamu sudah meng-install PHP, maka kamu bisa memanfaatkan server bawaan PHP. Cukup jalankan perintah:

```bash
php artisan serve
```

Selanjutkan aplikasimu bisa diakses di http://localhost:8000.

Jika membutuhkan development server yang lebih lengkap dan bisa diutak-atik, silakan mencoba beberapa alternatif berikut ini:

1. [Laragon](https://laragon.org/)
2. [XAMPP](https://www.apachefriends.org/index.html)
3. [WampServer](http://www.wampserver.com/en)
4. [Laravel Homestead](https://laravel.com/docs/5.8/homestead)
5. [Laravel Valet](https://laravel.com/docs/5.8/valet)
6. [Vessel (Docker for Laravel)](https://vessel.shippingdocker.com/)