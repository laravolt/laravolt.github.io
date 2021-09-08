---
title: Starter Kit
description: Application Starter Kit
extends: _layouts.documentation
section: content
---

# Starter Kit

Ketika proses instalasi, Laravolt secara otomatis akan melakukan beberapa hal agar aplikasi bisa langsung digunakan. Penting untuk tahu apa saja yang di-*generate* di awal agar lebih memahami cara kerja aplikasi. Selain itu, karena kode-kode yang di-*generate* ini fungsinya sebagai "starter kit", maka kita bisa dan bebas melakukan modifikasi setelahnya, sesuai kebutuhan.

### Symlink Aset

Laravolt memiliki seperangkat aset berupa CSS, Javascript, dan gambar yang dibutuhkan agar aplikasi berjalan baik. Secara teknis, aset-aset ini akan "disalin" ke folder `public` menggunakan mekanisme *symlink*. 

Lokasinya ada di `/public/laravolt`.

Jika karena suatu hal aset di folder tersebut gagal diakses dari web, silakan hapus folder `/public/laravolt` lalu ulangi proses *symlink* dengan menjalankan perintah `php artisan laravolt:link`.

Karena alasan *symlink* ini jugalah maka secara otomatis folder `/public/laravolt` juga akan didaftarkan ke entri `.gitignore`.

### Migration Script

Ada beberapa *migration script* yang akan digenerate untuk menambahkan tabel dan kolom yang diperlukan oleh Laravolt. Semuanya berkaitan dengan *authentication* dan *authorization*.

Hasil dari *migration script* tersebut bisa dilihat dalam bentuk ERD berikut ini:

<iframe width="100%" height="300" src='https://dbdiagram.io/embed/5fbb7d653a78976d7b7d0427'> </iframe>

Sebelum menjalankan `php artisan migrate`, kita bebas melakukan modifikasi terhadap *migration script* bawaan Laravolt sesuai kebutuhan.

### Skeleton Code

Setup awal aplikasi biasanya menjadi aktivitas yang cukup membosankan. Laravolt sangat memahami hal tersebut. Oleh sebab itu, kami mencoba menyediakan fitur umum yang sering dijumpai dalam sebuah sistem informasi.

#### Authentication

Fitur terkait *authentication* yang di-*generate* di awal meliputi:

1. Login
1. Logout
1. Lupa password
1. Registrasi
1. Verifikasi email

#### Edit My Profile

Berisi halaman untuk mengatur profil dan password dari pengguna yang sedang login.

#### Error Handling

Laravolt menambahkan beberapa *global handler* terkait aplikasi, yaitu:

1. `TokenMismatchException` atau error ketika form baru disubmit setelah jangka waktu yang lama sehingga token sudah kadaluwarsa.
1. `AuthorizationException` atau error ketika user mencoba mengakses URL yang tidak diperbolehkan.
1. Otomatis melaporkan error ke [Sentry](https://sentry.io/), jika terpasang.

#### Webpack

Kerangka konfigurasi webpack dengan [Tailwindcss](https://tailwindcss.com/).

#### Readme

Menambahkan *requirements*, cara setup dan instalasi pertama kali.
