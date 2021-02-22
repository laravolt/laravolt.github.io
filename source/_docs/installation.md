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



### 1. Install package

```bash
composer require laravolt/laravolt:dev-master
```



### 2. Install dan compile assets

Agar bisa digunakan, Laravolt perlu generated assets.


#### Untuk npm user

```bash
npm install && npm run dev
```


#### Untuk yarn user

```bash
yarn add vue-template-compiler --dev --production=false && yarn run dev
```

> Tambah dependency `vue-template-compiler` dan compile assets yang diperlukan.
> Agar ketika running `yarn` tidak pindah ke `npm` untuk menambah dependency yang kurang.



### 3. Setup laravolt

Beberapa file perlu digenerate dan disesuaikan agar Laravolt berjalan dengan baik. Cukup jalankan perintah di bawah ini, Laravolt akan melakukannya untukmu:

```bash
php artisan ui laravolt
```


Selanjutnya, jangan lupa menjalakan migration:

```bash
php artisan migrate
```

#### Tambahkan disks

Agar semua menu di Laravolt bisa diakses tanpa ada masalah,
kita perlu menambahkan `disks` baru di `config/filesystems.php`.

Buat folder backup di storage
```bash
mkdir storage/backup
```

```php
<?php

return [
    ...
    'disks' => [

        'local-backup' => [
            # karena masih development kita pakai driver local
            'driver' => 'local',
            'root' => storage_path('backup'),
        ],
        ...
    ];
];

```


### 4. Administrator

Untuk menambahkan user dengan role admin, bisa menjalankan perintah:

```bash
php artisan laravolt:admin <name> <email> <password>
```

Contoh:

```bash
php artisan laravolt:admin Admin admin@laravolt.dev secret
```



### 5. Local Development

Sebagaimana diketahui, untuk menjalankan aplikasi PHP dibutuhkan sebuah ***web server***. Jika kamu sudah meng-install PHP, maka kamu bisa memanfaatkan server bawaan PHP. Cukup jalankan perintah:

```bash
php artisan serve
```

Selanjutkan aplikasimu bisa diakses di http://localhost:8000.

Jika membutuhkan development server yang lebih lengkap dan bisa diutak-atik, silakan mencoba beberapa alternatif berikut ini:

1. [Laragon](https://laragon.org/)
2. [XAMPP](https://www.apachefriends.org/index.html)
3. [WampServer](http://www.wampserver.com/en)
4. [Laravel Homestead](https://laravel.com/docs/8.x/homestead)
5. [Laravel Valet](https://laravel.com/docs/8.x/valet)
6. [Vessel (Docker for Laravel)](https://vessel.shippingdocker.com/)
6. [Laradock)](https://laradock.io/)
