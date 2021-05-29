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

Pilih salah satu BPMN yang ingin di-import. BPMN yang ditampilkan disini adalah BPMN yang sudah di-deploy ke Camunda Engine sebelumnya.

![Import BPMN](../assets/uploads/workflow/table-import-bpmn.png)

Selesai. 

![BPMN imported](../assets/uploads/workflow/table-bpmn-definitions-imported.png)

Selanjutkan kita perlu mendefinisikan Modul untuk mengeksekusi BPMN tersebut.

## Menambah Modul
Setelah BPMN berhasil di-import, kita perlu mendefinisikan Modul untuk bisa mengeksekusi BPMN tersebut. Anggap saja membuat Modul ini seperti kita membuat halaman baru. Bedanya, kita tidak perlu membuat Route, Controller, View, ataupun Model satu persatu tetapi cukup dengan mendefinisikan sebuah file konfigurasi.

Pertama-tama, tambahkan sebuah file `config/workflow-modules/rekrutmen.php`. Sesuaikan nama file `rekrutmen.php` dengan proses bisnis aplikasi.

###### config/workflow-modules/rekrutmen.php
```php
<?php

return [
    'process_definition_key' => 'proc_bl_rekrutmen',
    'name' => 'Rekrutmen Pegawai',
    'tasks' => [],
];

```
Berdasar file konfigurasi di atas, Modul sudah bisa diakses di `localhost/workflow/module/rekrutmen/instances`.

## Mendefinisikan Form
Untuk setiap BPMN yang di-import ke aplikasi, kita perlu mendefinisikan _form fields_ untuk semua Start Event dan User Task yang ditemui.

Buka kembali file `rekrutmen.php`, lalu tambahkan:
```php
return [
    'process_definition_key' => 'proc_bl_rekrutmen',
    'name' => 'Rekrutmen Pegawai',
    'tasks' => [
        'StartEvent_1' => [
            'form_schema' => [
                'full_name' => [
                    'type' => 'text',
                    'label' => 'Nama Pelamar',
                ],
            ],
        ],
    ],
];
```
Pada contoh di atas, `StartEvent_1` adalah ID dari Start Event pada BPMN rekrutmen. Definisi form bisa ditambahkan pada bagian `form_schema`. `full_name` adalah nama variable yang akan disimpan di aplikasi (dan dikirim ke Camunda Engine). Sesuaikan dengan kebutuhan aplikasi.

Setelah form untuk Start Event sudah didefinisikan semua, kamu bisa membuka kembali halaman `localhost/workflow/module/rekrutmen/instances` dan memulai proses baru dengan menekan tombol **+ New**.

Silakan diisi dan disubmit. Jika berhasil, maka data yang diisikan akan tampil di halaman sebelumnya. Tekan tombol **Action** untuk melanjutkan proses hingga tidak ada lagi form yang bisa diisi (proses selesai).

Silakan melanjutkan pendefinisian form untuk User Task yang lain. Sebagai referensi, form definisi lengkap untuk BPMN rekrutmen bisa dilihat di https://gist.github.com/uyab/8cbd4bf94b5842646852b12ee42b853d.

Kita bisa melihat, selain `text` ada beberapa jenis field lain yang sudah disediakan oleh Laravolt Workflow, antara lain:
- `email`
- `textarea`
- `datepicker`
- `checkbox`
- `boolean`
- `radioGroup`
- `dropdown`
- `uploader`
- `redactor`

Silakan bereksplorasi :)

## Menampilkan Data Dengan Tabel
Setelah berhasil mengeksekusi BPMN, langkah berikutnya adalah mengatur informasi apa saja yang perlu ditampilkan ke dalam tabel. Untuk kasus sederhana, kita cukup mendefinisikan `table_variables` di Modul yang sudah dibuat. Untuk kasus yang lebih kompleks, kita bisa membuat custom Table View sendiri.

### Mendefinisikan Kolom Yang Ditampilkan
Buka kembali file `rekrutmen.php`, lalu tambahkan `table_variables`:
###### config/workflow-modules/rekrutmen.php
```php
<?php

return [
    'process_definition_key' => 'proc_bl_rekrutmen',
    'name' => 'Rekrutmen Pegawai',
    'table_variables' => ['full_name', 'job_title'],
    'tasks' => [...]
    
];

```
Semua field yang kita definisikan di `form_schema` bisa dipakai sebagai `table_variables`. Silakan mencoba.

### Custom Table View
### Filtering
### Searching
### Sorting
## Advance
### Form Listener
### Public Form
### Task Assignment
