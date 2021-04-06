---
title: Dear System Analyst
description: Bagaimana membuat dokumen analisis yang Laravolt Friendly
extends: _layouts.documentation
section: content


---

# Laravolt Untuk System Analyst

Ada beberapa standard di Laravolt yang penting diketahui oleh System Analyst agar tujuan untuk mempercepat proses pengembangan Sistem Informasi bisa dicapai. Sebagian besar berkaitan dengan desain database. Mari kita bahas satu per satu.

## Penamaan Tabel dan Kolom

### Konsisten

Konsisten, bukan tentang bahasa Inggris semua atau bahasa Indonesia semua, tapi lebih ke konsistensi pemakaian istilah.

Konsisten, bukan hanya di level dokumen teknis, tapi di seluruh lingkup proyek. Ketika ketemu User membahas **kasi**,  lalu di dokumen analisis dituliskan **Kepasa Seksi**, jangan tiba-tiba berubah menjadi **head_of_section** atau **section_chief** di rancangan database. Pakai saja istilah aslinya, **kasi**. Lumayan mengurangi overhead otak untuk melakukan *translation* dan *dictionary lookup*.

### Mudah Dipahami

1. Nama yang pendek (3 suku kata atau kurang) lebih mudah dibaca dan dipahami.
2. Jika kepepetnya tidak bisa pendek, jangan memaksa untuk menyingkatnya. Nama yang panjang tapi jelas lebih baik dibanding nama yang pendek tapi butuh mikir (sekali lagi, overhead otak).
3. Boleh menyingkat untuk istilah-istilah yang memang sudah umum digunakan sesuai domain bisnis proyek:
    1. `tmt` vs `tanggal_mulai_tugas`
    2. `nip` vs `nomor_induk_pegawai`
    3. `npwp` vs `nomor_pajak`

### Tidak Masalah Campur *English* dan Bahasa Indonesia

1. Tidak perlu memaksa mengubah `unit_kerja` menjadi `work_unit` atau `unit_of_work`.

2. Misal sudah punya tabel `peserta` dengan kolom-kolom diataranya: `nama`, `nilai_tpa`, dan `nilai_un`. Lalu butuh ditambahkan satu kolom lagi untuk menyimpan nilai TOEFL. Mana yang lebih baik: `nilai_toefl` atau `toefl_score`?

    

## Primary Key

1. Beri nama `id`.
1. Tipe data boleh dipilih antara:
    1. **Unsigned integer + auto increment**
        1. Default behaviour
        1. Memudahkan programmer debugging
        1. Mudah “ditebak” oleh user
    1. **UUID**
        1. Perlu sedikit kustomisasi
        1. Tidak mudah “ditebak” oleh user
        1. Sedikit merepotkan programmer ketika debugging

## Foreign Key

1. Beri prefix `_id`.
2. Beri nama sesuai entitas yang tersimpan di kolom tersebut, contoh:
    1. Lebih baik `author_id` daripada `user_id` untuk menyimpan siapa penulis sebuah Post.
3. Pastikan tipe datanya sama.

## Timestamps

Secara default, Laravolt akan menyimpan kapan suatu record di database dibuat dan diupdate dalam dua buah kolom:

1. created_at (TIMESTAMP)
2. updated_at (TIMESTAMP)

Jika membutuhkan tambahan kolom untuk menyimpan siapa yang melakukan create atau update, tambahkan kolom:

1. created_by (Unsigned Big Integer)
2. updated_by (Unsigned Big Integer)

Jika membutuhkan mekanise *soft delete*, tambahkan kolom:

1. deleted_at (TIMESTAMP)
2. deleted_by (Unsigned Big Integer)

## Boolean

Untuk kolom dengan tipe boolean, hanya berisi nilai antara `true` atau `false`, gunakan nama yang mencerminkan pertanyaan yang jawabannya `yes` or `no`. Dalam bahasa Inggris, kolom seperti ini biasanya diawali dengan prefiks **is**, **has**, **should**, **can**, dan sejenisnya. Bisa juga digabungkan dengan sufiks **able**.

- is_active
- has_attachment
- should_change_password
- is_downloadable
- can_closed

Versi bahasa Indonesianya kira-kira seperti ini:

- apakah_aktif
- punya_lampiran
- apakah_harus_ganti_password
- bisa_didownload
- bisa_diakhiri

## Enum

Untuk kolom enumerasi yang kemungkinan "*value*-nya sudah ***fixed***", dianjurkan untuk tetap memakai tipe data `string` dan bukan `enum`, karena:

1. Enum belum menjadi standard SQL, hanya dikenali di MySQL.
2. Jangan langsung percaya dengan pernyataan "*value*-nya sudah ***fixed***". Perubahan itu pasti, dan mengubah enum di level database itu tidak begitu menyenangkan bagi programmer.
3. Laravolt memiliki mekanisme class `Enum` yang lebih friendly untuk programmer.
4. Untuk kebutuhan dokumentasi, boleh tetap menuliskan sebagai `enum`. Programmer laravolt akan mengkonversinya menjadi `string` biasa ketika koding.

## Menyimpan File (Media Library)

Untuk entitas yang membutuhkan menyimpan file, baik itu gambar, dokumen pdf/word/excel ataupun jenis file lainnya, semuanya akan disimpan dalam satu buah tabel yang sama. Jadi tidak perlu ditambahkan kolom-kolom untuk menyimpan metadata file. Sebaliknya, ada satu tabel khusus, `media`, yang akan menyimpan metadata file tersebut ditambah dengan foreign key ke tabel lain yang berelasi.

### Bukan Laravolt

##### User

| Kolom            | Tipe             |
| ---------------- | ---------------- |
| id               | Primary Key      |
| email            | Varchar          |
| name             | Varchar          |
| avatar_path      | Text             |
| avatar_extension | Varchar          |
| avatar_size      | Unsigned Integer |

##### Post 

| Kolom                    | Tipe             |
| ------------------------ | ---------------- |
| id                       | Primary Key      |
| title                    | Varchar          |
| content                  | Text             |
| featured_image_path      | Text             |
| featured_image_extension | Varchar          |
| featured_image_size      | Unsigned Integer |

### Laravolt

##### User

| Kolom                | Tipe                 |
| -------------------- | -------------------- |
| id                   | Primary Key          |
| email                | Varchar              |
| name                 | Varchar              |
| ~~avatar_path~~      | ~~Text~~             |
| ~~avatar_extension~~ | ~~Varchar~~          |
| ~~avatar_size~~      | ~~Unsigned Integer~~ |

##### Post 

| Kolom                        | Tipe                 |
| ---------------------------- | -------------------- |
| id                           | Primary Key          |
| title                        | Varchar              |
| content                      | Text                 |
| ~~featured_image_path~~      | ~~Text~~             |
| ~~featured_image_extension~~ | ~~Varchar~~          |
| ~~featured_image_size~~      | ~~Unsigned Integer~~ |

##### Media

| Kolom             | Tipe                                                         |
| ----------------- | ------------------------------------------------------------ |
| id                | Primary Key                                                  |
| model_type        | Model (atau nama table)                                      |
| model_id          | Foreign key ke tabel lain                                    |
| collection_name   | Collection name. Satu tabel bisa punya banyak *file collection*. |
| name              | Nama file yang diberikan setelah diupload                    |
| file_name         | Nama file asli ketika diupload                               |
| mime_type         | jpg, png, doc, pdf, atau lainnya                             |
| disk              | Lokasi penyimpanan                                           |
| size              | Ukuran file                                                  |
| manipulations     | -                                                            |
| custom_properties | -                                                            |
| responsive_images | -                                                            |
| order_column      | -                                                            |
| created_at        | -                                                            |
| updated_at        | -                                                            |

> Yang lebih penting adalah adanya kejelasan bagi programmer apakah file-nya **hanya boleh satu** atau **bisa banyak** (Has One vs Has Many).
>
> Laravolt menggunakan [Spatie Media Library](https://docs.spatie.be/laravel-medialibrary/) untuk penyimpanan file. Dokumentasi lebih lengkap bisa dibaca di situs resminya.

## Task Description

1. Sebutkan tabel apa saja yang terlibat
2. Untuk form:
    1. Tuliskan halaman redirect yang dituju jika berhasil submit form
    2. Sebutkan field mana yang wajib diisi dan mana yang opsional. *By default* Laravolt akan membaca dari metadata database. Jika kolom didefinisikan sebagai `NOT NULL` berarti wajib diisi.

## User Interface

- Fixed row (multiple input) vs add row below
- Single column vs multiple column form
- Separate multiple upload