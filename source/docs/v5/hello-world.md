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
![image-20210907081648058](../assets/uploads/hello-world-dashboard.png)

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

Skeleton file view bisa dibuat secara otomatis dengan perintah `php artisan make:view`:

```bash
php artisan make:view dashboard --title=Dashboard
```

File yang dihasilkan akan disimpan di `resources/views/dashboard.blade.php`.
Silakan buka dan perbaiki isinya sesuai kebutuhan.

```php
<x-volt-app title="Dashboard">

    Hello world!

</x-volt-app>
```

## Menambahkan Route

```php
Route::get('dashboard', \App\Http\Controllers\DashboardController::class)->name('dashboard');
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
Selamat, kita berhasil membuat halaman pertama aplikasi dengan Laravolt.
Dari contoh di atas, ada beberapa hal yang sudah kita praktekkan terkait fitur bawaan Laravolt.

### Code Generator Untuk Mempercepat Koding
Kita sudah bisa meng-_generate_ skeleton file Blade secara cepat dengan `php artisan make:view`. 
Ada beberapa komponen lain yang bisa kita generate dengan cepat skeleton kodenya, misalnya: datatable, chart, atau bahkan skeleton CRUD lengkap.

### Blade Component Untuk Membangun UI
Akan ada banyak **Blade Component** yang kita temui selama mengembangkan aplikasi dengan Laravolt.  `<x-volt-app>`  hanya salah satu contoh [pemanfaatan Blade Component untuk *layouting*](https://laravel.com/docs/master/blade#layouts-using-components).

Masih ada `<x-volt-panel>`, `<x-volt-grid>`, `<x-volt-icon>` dan lain-lain. Memanfaatkan Blade Component untuk membangun UI merupakah salah satu praktek enkapsulasi, dimana styling (CSS) dan logic (Javascript) terkait UI kita sembunyikan di masing-masing komponen. 

Ada dua keuntungan yang bisa didapat dari hal ini:

1. File blade menjadi lebih sederhana.
1. Tampilan UI menjadi lebih standard dan konsisten. Jika ada perubahan style, cukup ubah di satu tempat (base component-nya), maka semua halaman yang memanggil komponent tersebut otomatis ikut berubah.

### *Config File* Untuk Mendaftarkan Menu

Hampir semua fitur bawaan Laravolt bisa dikonfigurasi lewat *config file*. Saat ini kita sudah mengenalnya untuk mengatur menu-menu yang ditampilkan di *sidebar*. Selain itu, masih ada banyak *config file* yang bisa kita atur konfigurasinya jika butuh *custom behaviour*. Tapi berdasar pengalaman sejauh ini, 80% aplikasi tidak membutuhkan kustomisasi tersebut.

Jadi tenang saja, *stick to the default option*. Jika memang suatu saat butuh kustomisasi, kamu tahu Laravolt menyediakan opsinya, sudah didokumentasikan di setiap fitur.



Lanjutkan :)
