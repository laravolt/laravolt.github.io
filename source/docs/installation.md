---
title: Installation
description: One small step for a man, one giat leap for mankind
extends: _layouts.documentation
section: content
---

# Installation

## Server Requirements

1. PHP >= 7.1.3
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

Laravolt membutuhkan [Composer](https://getcomposer.org/) dan koneksi internet untuk mendownload source code dari GitHub. Pastikan kamu mempunya keduanya.

> Kamu tidak memerlukan akun GitHub untuk mulai menggunakan Laravolt.



### Aplikasi Existing 

Jika kamu sudah meng-install Laravel sebelumnya, jalankan perintah berikut:

```bash
composer require laravolt/platform
```

Selanjutnya, perlu ada penyesuaian terhadap di level aplikasi. Kamu bisa melakukannya secara otomatis dengan menjalankan perintah:

```bash
php artisan preset laravolt
```

Atau, kamu bisa melakukannya secara manual dengan mengikuti langkah-langkah di bagian selanjutnya.

#### Menyesuaikan Skeleton Aplikasi

Ada beberapa kode yang perlu diubah dan ditambahkan di level aplikasi agar Laravolt dapat berjalan dengan optimal.

##### 1. Symlink Assets (CSS, JS, dan Aset Lainnya)

Jalankan perintah:

```bash
php artisan laravolt:link-assets
```

Langkah ini perlu dilakukan agar aset-aset yang dibutuhkan untuk menampilkan halaman admin bisa diakses oleh publik. Dibalik layar, perintah ini akan melakukan proses `copy` atau `symlinks` dari folder `laravolt/ui/public` ke folder `public/laravolt`.

##### 2. Ubah Redirect Route
Langkah ini diperlukan untuk mengubah kemana User akan diredirect ketika mengakses halaman yang butuh autentikasi.

Tambahkan potongan kode berikut ke file `app/Exceptions/Handler.php`:


```php
    protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception)
    {
        return $request->expectsJson()
                    ? response()->json(['message' => $exception->getMessage()], 401)
                    : redirect()->guest(route('auth::login'));
    }

    public function render($request, Exception $exception)
    {
        if ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
            return redirect()->back(302, [], route('home'))->withError(
                __('You are not authorized to access :url', ['url' => $request->fullUrl()])
            );
        }

        return parent::render($request, $exception);
    }
```


> Abaikan langkah ini jika kamu memakai fitur autentikasi bawaan Laravel atau membuat autentikasi sendiri.

### Aplikasi Baru

Jika kamu baru pertama kali memulai, jalankan perintah berikut untuk mengunduh source code Laravolt versi terbaru lengkap dengan semua modulnya:

```bash
composer create-project laravolt/project
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