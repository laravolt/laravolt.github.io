---
title: ACL
description: Pengaturan hak akses
extends: _layouts.documentation
section: content
---

# ACL

## Konsep

Sebelum masuk ke pembahasan teknis, kita perlu memahami konsep dan cara kerja ACL secara umum.

### User

User adalah pengguna yang memiliki akun dan bisa login ke aplikasi.

### Role

Role, atau sering juga disebut dengan istilah *user group*, adalah istilah yang dipakai untuk mengelompokkan User yang sejenis agar lebih mudah diatur hak aksesnya.

Contoh Role dalam aplikasi nyata:

#### Sistem Informasi Rumah Sakit

- Administrator
- Dokter
- Perawat

#### Sistem Informasi Akademik

- Dosen
- Mahasiswa
- TU

#### Toko Online

- Pemilik Toko
- Kasir
- Customer Service

Seorang User bisa memiliki satu atau lebih Role. Laravolt mendefinisikan User dan Role dalam relasi Many to Many. 

### Permission

Permission, atau sering disebut dengan *ability*, adalah istilah yang dipakai untuk mendefinisikan kemampuan yang harus dimiliki oleh seorang User sebelum bisa mengakses sebuah fitur.

Contoh Permission dalam aplikasi nyata:

#### Sistem Informasi Rumah Sakit

- Bisa input pasien
- Bisa melihat rekam medis
- Bisa melihat dashboard keuangan

  

#### Sistem Informasi Akademik

- Bisa input KRS
- Bisa melihat profil mahasiswa
- Bisa membuat jadwal



Laravolt mendefinisikan relasi Many to Many antara Permission dan Role. **Jadi, Permission itu menempel ke Role, bukan ke User.** 

## ERD

<iframe width="100%" height="300" src='https://dbdiagram.io/embed/5fbb7d653a78976d7b7d0427'> </iframe>

## Pengecekan Hak Akses

Ada 2 metode pengecekan hak akses yang biasa dilakukan ketika koding dengan Laravel:

1. Mengecek Role
2. Mengecek Permission



Di bawah ini kita akan coba membandingkan cara kodingnya masing-masing.

###### MENGECEK ROLE

```php
// Method "hasRole" merupakan fungsi bawaan Laravolt.
if (auth()->user()->hasRole(['Administrator'])) {
  // allow to access dashboard
}
```



###### MENGECEK PERMISSION

```php
if (auth()->user()->can('see_dashboard')) {
    // allow to access dashboard
}
```



Untuk aplikasi skala kecil, pengecekan berdasar Role biasanya lebih disukai karena lebih mudah dibaca dan lebih konsisten dengan proses bisnis aplikasi. Klien biasanya bilang, "fitur A cuma bisa diakses admin". Jika diterjemahkan dalam bentuk kode, maka contoh pertama lebih dekat dengan *requirements*.

Namun, pengecekan berdasar Role memiliki kekurangan, yaitu **kode lebih rentan terhadap perubahan**. Contoh, terjadi perubahan requirement dimana selain Administrator, Direktur RS juga bisa melihat dashboard.



###### MENGECEK ROLE

```php
// OK, kita perlu menambahkan Role Direktur RS kesini
if (auth()->user()->hasRole(['Administrator', 'Direktur RS'])) {
  // allow to access dashboard
}
```



###### MENGECEK PERMISSION

```php
// Tidak ada yang perlu diubah disini
if (auth()->user()->can('see_dashboard')) {
    // allow to access  dashboard
}
```

Anda bisa melihat, tidak ada perubahan kode jika kita melakukan pengecekan dengan Permission.

Kenapa bisa begitu?

## Fixed Permission, Dynamic Role

Jika pengecekan dilakukan terhadap Permission, maka ketika ada perubahan requirement terkait hak akses, yang perlu dilakukan hanyalah mengubah permissions dari Role yang bersangkutan. Dan hal tersebut bisa dilakukan admin sistem lewat admin panel yang telah disediakan.

![image-20201123162908033](https://cdn.statically.io/gh/laravolt/storage/master/2021/10/preview-edit-role-NEpOD3.png)

Sebaliknya, jika pengecekan dilakukan terhadap Role, setiap kali ada perubahan kondisi maka kode aplikasi juga harus disesuaikan. Tentu hal ini tidak cukup efektif. Selain itu, bisa jadi nama Role ini berubah. Apa yang terjadi jika "Direktur RS" diubah menjadi "Direktur Utama RS"?



> **Fixed Permissions, Dynamic Roles**
>
> Permission itu fix jumlah dan namanya, sesuai definisi fitur aplikasi. Role itu dinamis, Admin bisa menambah atau mengurangi sesuai kebutuhan. Ketika ada perubahan requirement terkait hak akses, maka yang perlu dilakukan hanyalah mengubah mapping role-permission.

## Mendaftarkan Permission

Karena Permission itu *fixed*, maka kita harus mendefinisikannya di satu tempat agar mudah dijadikan rujukan sekaligus sebagai dokumentasi (***single source of truth***).

### 1. Mendaftarkan Enum

Starter kit Laravolt sudah menyediakan sebuah [kelas Enum](https://github.com/BenSampo/laravel-enum) untuk mendaftarkan Permission, yaitu `app\Enums\Permission.php`. Jika karena suatu hal kelas ini belum ada, silakan ditambahkan sendiri.

###### app\Enums\Permission.php

```php
<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Permission extends Enum
{
    const DASHBOARD_VIEW = 'dashboard.view';

    const POST_VIEW = 'post.view';
    
    const POST_DELETE = 'post.delete';    
}

```

### 2. Sinkronisasi Enum dan Tabel Permission

Karena relasi user-role-permission disimpan di *database*, maka kita perlu melakukan sinkronisasi agar isi tabel `acl_permissions` sesuai dengan enum yang didefinisikan. Perintah yang perlu dijalankan adalah:

```bash
php artisan laravolt:sync-permission
```



Setelah didaftarkan, kita bisa menggunakan *constant* tersebut untuk melakukan pengecekan:

```php
if (auth()->user()->can(\App\Enums\Permission::POST_DELETE)) {
    
}
```

Menggunakan *constant* lebih direkomendasikan dibanding *string* biasa, karena:

1. Mendukung *autocomplete*. 
1. Menghindari *typo*.
1. Lebih mudah di-*refactor*.

### 3. Mendaftarkan Permission ke Role Melalui Admin Panel

Setelah Permission terdaftar di *database*, Administrator aplikasi bisa melakukan pengaturan Role mana saja yang berhak memiliki permission tersebut melalui menu "System -> Roles". 

![image-20211006065105036](https://cdn.statically.io/gh/laravolt/storage/master/2021/10/image-20211006065105036-LkFi8U.png)

Karena Role bersifat dinamis, maka jika suatu ketika ada perubahan aturan hak akses, Administrator bisa melakukannya secara mandiri tanpa perlu meminta Programmer untuk mengubah kodingan.

## Wildcard Permission

Ada satu *wildcard* Permission, yang diberi label **"*"**, dimana Role yang memiliki Permission tersebut bisa mengakses semua fitur aplikasi. 

*By default*, Permission tersebut akan ditambahkan ketika kamu menjalankan perintah `php artisan laravolt:admin`.

**Pastikan hanya Role superadmin yang mendapat Permission tersebut**.
