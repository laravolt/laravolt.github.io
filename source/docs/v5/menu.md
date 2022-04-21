---
title: Menu
description: Mendaftarkan menu sidebar
extends: _layouts.documentation
section: content
---

# Menu
Laravolt melakukan pendekatan *config file* untuk menampilkan menu di sidebar, dengan tujuan:

1. Satu *single source of truth* dimana ada satu rujukan utama bagi programmer.
1. Karena *config file* masuk ke git, maka setiap perubahan menu bisa didistribusikan secara konsisten.
1. Memisahkan entri dan tampilan. *Config file* hanya berisi informasi penting terkait menu seperti label, url, dan icon. Kamu tidak perlu memikirkan bagaimana HTML dan CSS karena sudah ditangani oleh Laravolt.

Laravolt secara otomatis akan membaca folder `config/laravolt/menu` untuk melihat konfigurasi menu.

Secara singkat, anatomi dari menu adalah:

- Grup 1
  - Menu 1
  - Menu 2
    - Sub menu 2.1
    - Sub menu 2.2
  - Menu 3
- Grup 2

## Mendaftarkan Menu
Buat sebuah file baru `config/laravolt/menu/app.php`:
```php
<?php

return [
    'App' => [
        'order' => 1,
        'menu' => [
            'Dashboard' => [
                'route' => ['dashboard'],
                'active' => 'dashboard/*',
                'icon'  => 'chart-bar'
            ],
            'Manage Posts' => [
                'route' => ['posts.index'],
                'active' => 'posts/*',
                'icon'  => 'newspaper'
            ],
        ],
    ],
];
```
*Config file* berfungsi untuk mengelompokkan menu. Kamu bebas membuat sebanyak mungkin *config file* sesuai kebutuhan aplikasi, misalnya:

- `config/laravolt/menu/app.php`
- `config/laravolt/menu/master-data.php`
- `config/laravolt/menu/settings.php`

## Nested Menu

Laravolt mendukung hingga 2 level menu (menu dan submenu). Untuk membuatnya, cukup tambahkan entri `'menu'` dengan skema array yang sama:

```php
<?php

return [
    'App' => [
        'order' => 1,
        'menu' => [
            'Dashboard' => [
                'route' => ['dashboard'],
                'active' => 'dashboard/*',
                'icon' => 'chart-bar',
            ],
            'Posts' => [
                'icon' => 'newspaper',
                'menu' => [
                    'Published' => [
                        'route' => ['posts.index', ['type' => 'published']],
                        'active' => 'posts?type=draft',
                    ],
                    'Draft' => [
                        'route' => ['posts.index', ['type' => 'draft']],
                        'active' => 'posts?type=draft',
                    ],
                ],

            ],
        ],
    ],
];

```



## Available Options

### order

Hanya tersedia di level grup. Berfungsi untuk menentukan urutan menu.

```php
<?php

return [
    'Menu Utama' => [
        'order' => 2,
        'menu' => [
            // ...
        ],
    ],
];


```



### route

```php
'route' => ['route.name', ['param1' => 'value']],
```

Jangan memanggil helper `route()` secara langsung dari *config file* karena berpotensi ada error di *production*.

### url

Jika kamu tidak terbiasa menggunakan ***named routes***, maka cukup tuliskan hardcode URL-nya saja.

```php
'url' => 'posts/create',
```

### active

Berfungsi untuk menentukan entri menu mana yang perlu diset *active* dan *expanded*. Bisa menggunakan wildcard.

```php
'active' => 'posts/*',
```

### icon

Mengatur ikon yang akan ditampilkan. Ikon yang bisa digunakan bisa dilihat di https://fontawesome.com/v5/search?s=duotone. Laravolt sudah memiliki lisensi resmi Font Awesome 5 Pro.

```php
'icon' => 'users',
```

Untuk saat ini hanya menu level satu yang bisa menampilkan ikon sedangkan label kategori (grup menu) dan sub menu tidak bisa.

### permissions

Mengatur apakah sebuah menu perlu ditampilkan atau tidak, berdasar **Permissions** yang dimiliki oleh User.

```php
'permissions' => [\App\Enum\Permissions::MANAGE_POST],
```

## Dynamic Menu
Untuk menambahkan menu secara dinamis, tambahkan contoh kode berikut ke method `boot()` di `AppServiceProvider`:

```php
public function boot()
{
    app('laravolt.menu.sidebar')->register(function (\Lavary\Menu\Builder $menu) {
        // Menambahkan menu ke existing group
        $group1 = $menu->get('system');
        $group1->add('My Menu', 'my-menu')
            ->data('icon', 'list')
            ->data('order', 10)
            ->data('permission', 'foo')
            ->active("my-menu/*");

        // Menambahkan group dan menu baru
        $group2 = $menu->add('New Group');
        $group2->add('My Menu 2', 'my-menu-2')
            ->data('icon', 'list')
            ->data('order', 10)
            ->data('permission', 'foo')
            ->active("my-menu-2/*");

        // Menambahkan group, menu, dan sub menu
        $group3 = $menu->add('Nested Menu');
        $menu3 = $group3->add('My Menu 3')
            ->data('icon', 'list')
            ->data('order', 10)
            ->data('permission', 'foo');
        $menu3->add('Sub Menu A', '#');
    });
}
 ```
