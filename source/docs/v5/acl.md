---
title: ACL
description: Pengaturan hak akses
extends: _layouts.documentation
section: content
---

# ACL

## Istilah

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

