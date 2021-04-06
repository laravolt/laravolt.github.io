---
title: Lookup
description: Use at your own risk
extends: _layouts.documentation
section: content
---

# Lookup

## Konsep

[TBD]

## Instalasi

[TBD]

## Menambah Lookup Baru

Pastikan sudah ada file `config/laravolt/lookup.php`. Jika belum, jalankan perintah:

```bash
php artisan vendor:publish --tag=config
```

Ini adalah skeleton filenya:

```php
<?php

return [
    'route' => [
        'enabled' => true,
        'middleware' => ['web', 'auth'],
        'prefix' => '',
    ],
    'view' => [
        'layout' => 'laravolt::layouts.app',
    ],
    'menu' => [
        'enabled' => true,
    ],
    'permission' => [],
    'collections' => [
        // Sample lookup collections
        'pekerjaan' => [
            'label' => 'Pekerjaan',
        ],
    ],
];
```

Ubah bagian `collections`, tambahkan lookup dengan format sesuai contoh. Misalnya kita ingin membuat lookup baru untuk menyimpan *list of* status perkawinan, maka cukup tambahkan config berikut:

```diff
<?php

return [
    'route' => [
        'enabled' => true,
        'middleware' => ['web', 'auth'],
        'prefix' => '',
    ],
    'view' => [
        'layout' => 'laravolt::layouts.app',
    ],
    'menu' => [
        'enabled' => true,
    ],
    'permission' => [],
    'collections' => [
        // Sample lookup collections
        'pekerjaan' => [
            'label' => 'Pekerjaan',
        ],
+        'status_perkawinan' => [
+            'label' => 'Status Perkawinan',
+        ],      
     ],
];
```

Selanjutnya buka menu Lookup, maka sebuah sub menu **Status Perkawinan** otomatis telah ditambahkan dimana kita bisa melakukan operasi CRUD.

Silakan cek tabel `platform_lookup` untuk mempelajari isinya.