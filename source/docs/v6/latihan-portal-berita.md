---
title: Manajemen Portal Berita
description: Membuat Manajemen Portal Berita Dengan Laravolt
extends: _layouts.documentation
section: content
---

# Portal Berita
## Spesifikasi

Buat sebuah aplikasi untuk mengelola website berita, semacam detik.com versi sederhana. 

### Aktor

Aplikasi ini akan melibatkan empat aktor:

1. Admin
1. Writer
1. Member
1. Guest



### User Story

Secara umum, user story yang bisa dilakukan oleh masing-masing aktor antara lain:

1. Writer bisa melakukan CRUD konten berita
1. Admin bisa memoderasi komentar
1. Admin bisa memoderasi Member dan Writer yang terdaftar
1. Admin bisa melihat dashboard untuk mendapatkan summary dan statistik aplikasi
1. Writer bisa melihat dashboard untuk melihat statistik terkait berita
1. Guest bisa menelusuri dan membaca berita, termasuk:
   1. Melakukan pencarian judul dan konten berita berdasar keyword tertentu
   1. Memfilter berita berdasar topik tertentu
   1. Membaca komentar
1. Guest bisa melakukan pendaftaran, termasuk:
   1. Verifikasi email
   1. Otentikasi (login, logout)
   1. Lupas password
1. Member bisa mengedit profilnya sendiri
1. Member bisa menambah, mengedit, dan menghapus komentarnya sendiri

## Konsep Teknis

### Model

1. User
1. Post
1. Topic
1. Comment

### Relationship

1. Member is-a User
1. Writer is-a Member
1. Writer has many Post
1. Member has many Comment
1. Post belongs to Topic
1. Post belongs to Writer
1. Comment belongs to Member

### Spesifikasi Kode

1. Admin panel menggunakan Laravolt
1. Tampilan website untuk pengunjung dibuat menggunakan TailwindCSS
1. CRUD Post dan Topic dibuat dengan AutoCRUD
1. Chart untuk halaman dashboard dibuat dengan Laravolt Chart

## Mission

### 🚲 Level 1 

1. Kerjakan sesuai minimum requirements di atas
1. Tambahkan seeder untuk mengisi data awal sebanyak 1000 berita dengan masing-masing memiliki 100 komentar
1. Lengkapi readme.md dengan petunjuk setup aplikasi pertama kali
1. Beri nama aplikasi sesuai pilihan Anda, lalu push source code ke GitHub
1. Deploy aplikasi ke [heroku](https://www.heroku.com/)

### 🛵 Level 2

1. Admin bisa mengekspor berita dan komentar dalam format Excel
1. Admin bisa memfilter data yang ditampilkan di dashboard berdasar periode tertentu (tanggal awal - tanggal akhir)
1. Writer hanya bisa mengelola berita miliknya sendiri
1. Writer mendapat email notifikasi jika ada komentar baru di berita yang ditulisnya

### 🚗 Level 3

1. Admin bisa mengatur beberapa setting terkait website melalui admin panel:
   1. Nama dan deskripsi website
   1. Logo dan favicon
   1. Script google analytics
1. Buat 1 tema tambahan untuk website dan bisa diubah oleh Admin melalui admin panel. Multi theme bisa menggunakan library https://github.com/qirolab/laravel-themer.
1. Admin bisa melihat traffic pengunjung website melaui dashboard aplikasi, memanfaatkan library https://github.com/spatie/laravel-analytics.

### 🏎️ Level 4

1. Source code aplikasi lolos PHPStan level 9
1. Integration test
1. Nilai Pagespeed Insight untuk website di atas 90



## Demo

TBD
