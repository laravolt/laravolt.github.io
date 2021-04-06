---
title: Building Application
description: Build your first application using Laravolt
extends: _layouts.documentation
section: content
---

# Building Application

## Intro

Untuk lebih mendekatkan diri dengan Laravolt, kita akan bersama-sama membuat sebuah aplikasi dengan nama **Lapor**. Versi asli dari layanan Lapor bisa diakses di https://www.lapor.go.id/. Kita akan mencoba mereproduksi pembuatan layanan tersebut menggunakan Laravolt. Sesuai jargon Laravolt, [2 minggu jadi](https://www.merdeka.com/teknologi/pernyataan-jokowi-soal-2-minggu-selesai-jadi-perdebatan-hebat.html).

## Aplikasi Lapor

### Fungsi Utama

Lapor memiliki 2 fungsi utama:

1. Sebagai sarana untuk menyampaikan aspirasi warga dan melaporkan segala sesuatu yang dianggap tidak sesuai aturan.
2. Sebagai alat untuk mengawasi dan mengontrol pemerintah.

### Kebutuhan Fungsional

Secara fungsional, fitur-fitur yang ada di dalam Lapor adalah:

1. Masyarakat bisa menyampaikan aspirasi secara tertulis melalui internet.
2. Pemerintah bisa meneruskan aspirasi ke instansi terkait.
3. Instansi **wajib** menindaklanjuti aspirasi tersebut.
4. Masyarakat bisa mengikuti tindak lanjut dari aspirasi yang disampaikannya.
5. Pemerintah bisa melihat laporan kinerja setiap instansi.
6. Pemerintah bisa mengunduh rekapitulasi aspirasi dalam periode tertentu.

### Daftar Fitur

Kita detilkan lagi, maka halaman dan fitur yang harus kita bikin adalah:

1. Halaman publik:
    1. Halaman otentikasi, yang terdiri dari:
        1. Halaman login, mengisi email dan password.
        2. Halaman registrasi, mengisi nama, email, dan password.
        3. Halaman lupa password, mengisi email.
    2. Halaman untuk menuliskan aspirasi:
        1. Warga bisa menulis aspirasi baik sudah login ataupun belum.
        2. Isian aspirasi berupa text dan wajib diisi.
        3. Jika tidak login, wajib mengisi email.
    3. Halaman untuk mengikuti perkembangan aspirasi yang sudah dibuat
        1. Menampilkan komentar dari instansi
        2. Menampilkan historis perubahan status
        3. Pemilik aspirasi bisa mengubah status aspirasi:
            1. Selesai, jika aspirasi sudah ditangani dengan baik.
            2. Batalkan, jika aspirasi dirasa sudah tidak relevan.
2. Halaman admin
    1. Halaman untuk meneruskan aspirasi ke instansi terkait.
    2. Halaman untuk menindaklanjuti aspirasi:
        1. Bisa input balasan berupa teks
        2. Setelas dibalas, warga akan mendapat notifikasi ke emailnya
        3. Instansi bisa mengubah status aspirasi:
            1. Sedang ditangani
            2. Sudah selesai ditangani
    3. Halaman untuk melihat laporan kinerja instansi:
        1. Urutan instansi berdasar jumlah laporan yang masuk
        2. Urutan instansi berdasar jumlah laporan yang selesai ditangani
        3. Urutan instansi berdasar persentasi laporan yang selesai ditangani
    4. Halaman untuk mengunduh rekapitulasi aspirasi dalam format Excel dan PDF

## Instalasi Laravolt

## Otentikasi (*Authentication*)

### Login

### Logout

## Otorisasi (*Authorization*)

### Konsep Otorisasi di Laravolt

Fixed permission, dynamic roles

### Mendefinisikan Permission

MEMBUAT_ASPIRASI

MENGEDIT_ASPIRASI

MENERUSKAN_ASPIRASI

MENINDAKLANJUTI_ASPIRASI

MELIHAT_LAPORAN

MENCETAK_LAPORAN



### Mendefinisikan Role

WARGA

ADMIN_SISTEM

ADMIN_PUSAT

INSTANSI

### Menetapkan Permission Untuk Setiap Role

## Membuat Skeleton Aplikasi

### Mendefinisikan Route

### Membuat Controller

### Membuat View

## Menyiapkan Database & Model

### Membuat Migration

### Membuat Model

### Membuat Seeder

## Input Aspirasi

## Detil Aspirasi

## Meneruskan Aspirasi Ke Instansi

### Kirim Notifikasi Email

## Menindaklanjuti Aspirasi

### Input Komentar

### Kirim Notifikasi Email

## Melihat Laporan

## Mencetak Laporan 

