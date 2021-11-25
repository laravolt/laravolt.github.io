---
title: Membuat Authorized Menu
description: Membuat menu dengan hak akses
extends: _layouts.documentation
section: content
---

# Membuat Authorized Menu

## 1. Mendefinisikan Permission

###### app\Enums\Permission.php

```php
final class Permission extends Enum
{
    const DASHBOARD_VIEW = 'dashboard.view';
}

```

Setelah itu, jangan lupa jalankan command berikut:

```bash
php artisan laravolt:sync-permission
```

Baca juga [dokumentasi lengkap ACL](https://laravolt.dev/docs/v5/acl/).

## 2. Menghubungkan Menu dan Permission

###### config/laravolt/menu/app.php
```php
return [
    'App' => [
        'menu' => [
            'Dashboard' => [
                'route' => ['dashboard'],
                'active' => 'dashboard/*',
                'icon'  => 'chart-bar',
                'permissions' => [\App\Enum\Permissions::DASHBOARD_VIEW],
            ],
        ],
    ],
];
```

Saat ini permissions di menu hanya berfungsi untuk show/hide menu, sehingga URL masih bisa diakses dengan mengetik langsung di browser. Oleh sebab itu butuh step ketiga di bawah ini.

## 3. Tambahkan Pengecekan Hak Akses (Authorization) di Kode

Pengecekan hak akses di routes:
###### routes/web.php

```php
Route::get('dashboard', function () {
    // show dashboard
})->can(\App\Enum\Permissions::DASHBOARD_VIEW);
```

Atau juga bisa di Controller:

```php
public function index()
{
    $this->authorize(\App\Enum\Permissions::DASHBOARD_VIEW);
    
    // if passed, show dashboard
}
```

Dokumentasi lengkap terkait **authorization** di Laravel bisa dibaca di [dokumentasi resminya](https://laravel.com/docs/master/authorization).

## 4. Pengaturan Role di Level Aplikasi

Setelah Permission terdefinisi, Administrator aplikasi bisa melakukan pengaturan Role mana saja yang berhak
memiliki permission tersebut melalui menu "System -> Roles".

![image-20211006065105036](https://cdn.statically.io/gh/laravolt/storage/master/2021/10/image-20211006065105036-LkFi8U.png)

Karena Role bersifat dinamis, maka jika suatu ketika ada perubahan aturan hak akses, Administrator bisa melakukannya
secara mandiri tanpa perlu meminta Programmer untuk mengubah kodingan.

