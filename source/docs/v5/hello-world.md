---
title: Hello World
description: Creating your first page in Laravolt
extends: _layouts.documentation
section: content
---

# Hello World

Semua yang sudah kamu ketahui tentang Laravel bisa diterapkan di Laravolt.
Tidak ada perubahan struktur folder. Tidak ada perubahan artisan command. Tidak ada fungsi Laravel yang dihilangkan.
Jika kamu bisa Laravel, maka kamu juga bisa Laravolt.

## Membuat Halaman Baru
Anggaplah kita akan membuat sebuah halaman dashboard yang nantinya bisa diakses lewat menu samping. Berikut ini adalah langkah-langkah yang perlu dilakukan.

## Membuat Controller

```bash
php artisan make:controller DashboardController --invokable
```

###### app/Http/Controllers/DashboardController
```php
class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('dashboard');
    }
}
```
## Membuat View

Laravel tidak menyediakan command untuk meng-generate view. Oleh sebab itu, kamu bisa membuat file view secara manual
di `resources/views/dashboard.blade.php` dan mengisinya dengan potongan kode berikut:

```php
<x-volt-app title="Dashboard">

    Hello world!

</x-volt-app>
```

Atau, kamu bisa memanggil fitur tambahan dari Laravolt untuk membuat file view dengan lebih cepat:

```bash
php artisan make:view dashboard --title=Dashboard
```

## Menambahkan Route

```php
Route::get('dashboard', \App\Http\Controllers\Dashboard::class)->name('dashboard');
```

## Menambah Menu

###### config/laravolt/menu/app.php
```php
return [
    'App' => [
        'menu' => [
            'Dashboard' => [
                'route' => 'dashboard',
            ],
        ],
    ],
];
```

## Ringkasan
Cuma ada 2 tambahan yang berbeda:
- Layout view
- Menu
