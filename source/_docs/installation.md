---
title: Installation
description: One small step for a man, one giant leap for mankind
extends: _layouts.documentation
section: content
---

# Installation

## Server Requirements

1. PHP >= 7.4
2. MySQL, MariaDB, PostgreSQL, atau SQLite untuk penyimpanan data
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

Laravolt membutuhkan [Composer](https://getcomposer.org/) dan koneksi internet untuk mendownload source code dari GitHub. Pastikan kamu mempunyai keduanya.

> Kamu tidak perlu ~~ganteng atau cantik~~ akun GitHub untuk mulai menggunakan Laravolt. Meskipun... Hari gini ngaku programmer tapi ga punya akun github?



**Laravolt platform** adalah sebuah package, oleh sebab itu kamu harus sudah punya aplikasi Laravel dulu sebelumnya. Instalasi Laravel bisa dibaca di [dokumentasi resminya](https://laravel.com/docs/master#installing-laravel).

Jika aplikasi Laravel sudah siap, jalankan perintah berikut untuk menambahkan Laravolt:

```bash
composer require laravolt/laravolt:dev-master
```

Beberapa file perlu digenerate dan disesuaikan agar Laravolt berjalan dengan baik. Cukup jalankan perintah di bawah ini, Laravolt akan melakukannya untukmu:

```bash
php artisan ui laravolt
```



Selanjutnya, jangan lupa menjalakan migration:

```bash
php artisan migrate
```


### Install dan compile Assets

Agar bisa digunakan, Laravolt perlu generated assets.

```bash
yarn install
yarn run dev
```

atau

```bash
npm install
npm run dev
```



### Login Admin

Untuk menambahkan user dengan role admin, bisa menjalankan perintah:

```bash
php artisan laravolt:admin <name> <email> <password>
```

Contoh:

```bash
php artisan laravolt:admin Admin admin@laravolt.dev secret
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
