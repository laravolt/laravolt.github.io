---
title: Workflow
description: One Two Three One Two Three Go!
extends: _layouts.documentation
section: content
---

# Workflow

## Prasyarat
- Sudah bisa login sebagai Admin aplikasi.
- Sudah memahami konsep BPMN dan Camunda Engine.
- Sudah memahami cara menambah menu sidebar.
- Sudah memahami cara membuat form dari config file.

## Overview
Laravolt Workflow mampu menyediakan antarmuka untuk mengeksekusi diagram BPMN, memanfaatkan [Camunda REST API](https://docs.camunda.org/manual/latest/), sehingga sebuah proses bisnis bisa divalidasi dengan lebih cepat.
## Installation
Pastikan kamu sudah meng-install package Laravolt Camunda dan mempersiapkan konfigurasinya.
```bash
composer require laravolt/camunda
```
Tambahkan ke file `.env`:
```
CAMUNDA_URL=http://localhost:8080/engine-rest

#optional
CAMUNDA_TENANT_ID=
CAMUNDA_USER=
CAMUNDA_PASSWORD=
```
Tambahkan ke file `config/services.php`:
```php
'camunda' => [
    'url' => env('CAMUNDA_URL', 'https://localhost:8080/engine-rest'),
    'user' => env('CAMUNDA_USER', 'demo'),
    'password' => env('CAMUNDA_PASSWORD', 'demo'),
    'tenant_id' => env('CAMUNDA_TENANT_ID', ''),
],

```

Jalankan `php artisan laravolt:workflow:check` untuk memastikan koneksi ke Camunda REST API sudah berhasil.

## Import BPMN
Login ke aplikasi sebagai Admin, pilih menu Workflow > BPMN, klik tombol Tambah.
![Empty Definition](../assets/uploads/workflow/table-bpmn-definitions-empty.png)
Pilih salah satu BPMN yang ingin di-import. Pastikan kamu sudah men-deploy BPMN tersebut dari Camunda Modeler sebelumnya.
![Import BPMN](../assets/uploads/workflow/table-import-bpmn.png)
Selesai. 
![BPMN imported](../assets/uploads/workflow/table-bpmn-definitions-imported.png)
Selanjutkan kita perlu mendefinisikan Modul untuk mengeksekusi BPMN tersebut.

## Menambah Modul
Setelah BPMN berhasil di-import, kita perlu mendefinisikan Modul untuk bisa mengeksekusi BPMN tersebut. Anggap saja membuat Modul ini seperti kita membuat halaman baru. Bedanya, kita tidak perlu membuat Route, Controller, View, ataupun Model satu persatu tetapi cukup dengan mendefinisikan sebuah file konfigurasi.

Pertama-tama, tambahkan sebuah file `config/workflow-modules/rekrutmen.php`. Sesuaikan nama file `rekrutmen.php` dengan proses bisnis aplikasi.

## Mendefinisikan Form
### Available Fields
## Menampilkan Data Dengan Tabel
### Mendefinisikan Kolom Yang Ditampilkan
### Custom Table View
### Filtering
### Searching
### Sorting
## Advance
### Form Listener
### Public Form
### Task Assignment
