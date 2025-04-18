---
title: Workflow
description: One Two Three One Two Three Go!
extends: _layouts.documentation
section: content
---

# Workflow

## Prasyarat
- Sudah berhasil melakukan instalasi Laravolt.
- Sudah bisa login sebagai Admin aplikasi.
- Sudah memahami konsep BPMN dan Camunda Engine.

## Overview
Laravolt Workflow menyediakan antarmuka (GUI) untuk mengeksekusi diagram BPMN, memanfaatkan [Camunda REST API](https://docs.camunda.org/manual/latest/), sehingga sebuah proses bisnis bisa dijalankan dan divalidasi dengan lebih cepat.

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

Pertama-tama, tambahkan sebuah file `config/laravolt/workflow-modules/rekrutmen.php`. Sesuaikan nama file `rekrutmen.php` dengan proses bisnis aplikasi.

###### config/laravolt/workflow-modules/rekrutmen.php
```php
<?php

return [
    'process_definition_key' => 'proc_bl_rekrutmen',
    'name' => 'Rekrutmen Pegawai',
    'tasks' => [],
];

```
Berdasar file konfigurasi di atas, Modul sudah bisa diakses di URL `localhost/workflow/module/rekrutmen/instances`.

## Menambah Menu
Agar URL lebih mudah diakses, kita bisa menambahkannya ke menu. Caranya, buat file `config/laravolt/menu/app.php` dengan isian:
```php
<?php

return [
    'App' => [
        'menu' => [
            'Rekrutmen' => [
                'route' => ['workflow::module.instances.index', 'rekrutmen'],
                'icon'  => 'inbox'
            ],
        ],
    ],
];

```
Silakan sesuaikan sendiri label `Rekrutmen`, route _key_ `rekrutmen`, dan icon `inbox` sesuai kebutuhan aplikasi.

> Icon yang tersedia bisa dilihat di https://fontawesome.com/v5/search?s=duotone

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

> ID dari Start Event dan User Task bisa dilihat dengan cara membuka file BPMN menggunakan aplikasi Camunda Modeler.

Setelah form untuk Start Event sudah didefinisikan semua, kamu bisa membuka kembali halaman `localhost/workflow/module/rekrutmen/instances` dan memulai proses baru dengan menekan tombol **+ New**.

Silakan diisi dan disubmit. Jika berhasil, maka data yang diisikan akan tampil di halaman sebelumnya.

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

Jika semua form sudah didefinisikan, tekan tombol **Action** untuk melanjutkan proses hingga tidak ada lagi form yang bisa diisi (proses selesai).

## Form Listener
Terkadang ada kebutuhan dimana kita perlu mengirim sebuah data ke Camunda API tetapi data tersebut tidak berasal dari form inputan user, misalnya data `user_id`.

Ada dua buah Event yang bisa dimanfaatkan untuk melakukan hal di atas. Event `\Laravolt\Workflow\Events\ProcessInstanceStarting::class` dipakai untuk **Start Form** dan event `\Laravolt\Workflow\Events\TaskCompleting::class` dipakai untuk **User Task Form**

Yang perlu kita lakukan adalah membuat sebuah class Listener dan mendaftarkannya ke file konfigurasi.

Class Listener bisa dibuat dengan memanfaatkan perintah:
```bash
php artisan make:listener AttachUserId
```
File yang di-_generate_ bisa dilihat di folder `app/Listeners`.

Untuk event `ProcessInstanceStarting`:
```php
<?php

namespace App\Listeners;

use Laravolt\Workflow\Events\ProcessInstanceStarting;

class AttachUserId
{
    public function handle(ProcessInstanceStarting $event)
    {
        $event->form->modifyVariables(
            function ($variables) {
                $variables['userId'] = ['value' => auth()->id()];

                return $variables;
            }
        );
    }
}
```
Untuk event `TaskCompleting`:
```php
<?php

namespace App\Listeners;

use Laravolt\Workflow\Events\TaskCompleting;

class MyListener
{
    public function handle(TaskCompleting $event)
    {
        $event->form->modifyVariables(
            function ($variables) {
                $variables['someVariable'] = ['value' => 'foo'];

                return $variables;
            }
        );
    }
}
```
Lalu daftarkan Listener yang sudah dibuat ke event yang sesuai:
###### config/laravolt/workflow-modules/rekrutmen.php
```php
return [
    'process_definition_key' => 'proc_bl_rekrutmen',
    'name' => 'Rekrutmen Pegawai',
    'tasks' => [
        'StartEvent_1' => [
            'form_schema' => [],
            'listeners' => [
                \Laravolt\Workflow\Events\ProcessInstanceStarting::class => [
                    \App\Listeners\AttachUserId::class,
                ],
            ],
        ],
        'act_reviewDataDiri' => [
            'form_schema' => [],
            'listeners' => [
                \Laravolt\Workflow\Events\TaskCompleting::class => [
                    \App\Listeners\MyListener::class,
                ],
            ],
        ],

    ],
];
```
## Menampilkan Data Dengan Tabel
Setelah berhasil mengeksekusi BPMN, langkah berikutnya adalah mengatur informasi apa saja yang perlu ditampilkan ke dalam tabel. Untuk kasus sederhana, kita cukup mendefinisikan `table_variables` di Modul yang sudah dibuat. Untuk kasus yang lebih kompleks, kita bisa membuat custom Table View sendiri.

### Mendefinisikan Kolom Yang Ditampilkan
Buka kembali file `rekrutmen.php`, lalu tambahkan `table_variables`:
###### config/laravolt/workflow-modules/rekrutmen.php
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
Untuk kebutuhan yang lebih kompleks, kita bisa membuat sendiri komponen Table dengan menambahkan konfigurasi:
```php
    'table' => \App\Http\Livewire\Tables\MyCustomTable::class
    //'table_variables' => ['full_name', 'job_title'], sudah tidak diperlukan lagi
```
Cara membuat komponen Table bisa dipelajari di dokumentasi [Laravolt Table](https://laravolt.dev/docs/v6/table/).

## Public Form
[TODO]
## Task Assignment
[TODO]
