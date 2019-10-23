---
title: Thunderclap
description: CRUD generator untuk Laravolt
extends: _layouts.documentation
section: content
---

# Thunderclap

Thunderclap adalah sebuah *code generator*. Thunderclap membaca skema database dan menghasilkan sekumpulan kode berdasarkan ***template*** yang telah didefinisikan sebelumnya.

Thunderclap bertujuan menggantikan proses copy paste kode ketika membuat fitur CRUD, yang biasanya cukup monoton. Dengan thunderclap, kualitas dan konsistensi kode lebih terjaga, meskipun aplikasi dikembangkan oleh banyak programmer.

Ada kalanya kode yang dihasilkan oleh thunderclap tetap harus dimodifikasi terlebih dahulu sesuai kebutuhan aplikasi. Hal tersebut sangat wajar dilakukan. Thunderclap adalah *code generator*, bukan *application generator*. Apa yang dihasilkan thunderclap sepenuhnya bergantung dari programmer. Template bisa dibuat untuk mengakomodir 100% fungsionalitas dimana usaha untuk membuat template tersebut tentunya jadi lebih besar. Bisa juga sekedar mengejar angka 50% sehingga template bisa dibuat dengan cepat, lalu sisa waktunya bisa dimanfaatkan untuk koding secara manual.



## Instalasi

`composer require laravolt/thunderclap`



## Penggunaan

`php artisan laravolt:clap`

`php artisan laravolt:clap --table=users --template=custom --force`



## Custom Template

Template yang tersedia saat ini dibuat khusus untuk admin panel laravolt. Untuk membuat custom template, ikut langkah berikut:

1. Jalankan `php artisan vendor:publish --provider="Laravolt\Thunderclap\ServiceProvider"`

2. Ubah file `config/laravolt/thunderclap.php`, ganti default template dan tambahkan template directory baru:

```PHP
   // Template skeleton (stubs)
   'default'    => 'custom',
   
   // name => directory path, relative with stubs directory or absolute path
   'templates'  => [
       'laravolt' => 'laravolt',
       'custom'   => base_path('stubs/custom'),
   ],
```

3. Buat template baru di folder `stubs/custom`. Cara paling cepat adalah dengan menyalin dari template bawaan thunderclap yang bisa ditemukan di `vendor/laravolt/thunderclap/stubs/laravolt`.
4. Pastikan semua file diakhiri dengan sufiks `.stub`, sesuai dengan template bawaan.

5. Jalankan kembali `php artisan laravolt:clap`.