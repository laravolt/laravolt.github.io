---
title: Contact Form
description: Build contact form using Laravolt
extends: _layouts.documentation
section: content
---

# Contact Form

Pada studi kasus sebelumnya, kita sudah berhasil membuat sebuah form yang berfungsi lengkap: mulai dari validasi, menyimpan data, hingga mengirimkan notifikasi.

Sekarang kita akan menambahkan halaman bagi Admin untuk melihat semua *contact form* yang masuk. Kira-kira tampilannya seperti di bawah ini. Sebuah tabel lengkap dengan searching, filter per kolom, sorting, serta ekspor ke PDF dan CSV.

![image-20191011132109449](../assets/uploads/image-20191011132109449-0774874.png)

## 1. Menyiapkan Halaman Admin

URL untuk admin nantinya adalah `/admin/contact-form`.

### 1.1. Membuat Route dan Controller

Daftarkan route baru di posisi paling bawah.

###### routes/web.php

```php
Route::prefix('admin')->namespace('Admin')->as('admin.')->group(function () {
    Route::get('contact-form', 'ContactFormController@index')->name('contact-form.index');
});
```

Lalu jalankan perintah untuk meng-generate Controller:

```bash
php artisan make:controller Admin/ContactFormController
```

Buat kerangka method untuk halaman index:

```php
class ContactFormController extends Controller
{
    public function index()
    {
        return view('admin.contact-form.index');
    }
```

Pastikan route sudah terdaftar dengan mengecek di console melalui perintah:

```bash
php artisan route:list --name=contact-form
```

![image-20191011133038990](../assets/uploads/image-20191011133038990-0775440.png)



### 1.2. Menyiapkan View

Tambahkan file view baru di folder  `resources/views/admin/contact-form/` dengan nama `index.blade.php`:

###### resources/views/admin/contact-form/index.blade.php

```php+HTML
@extends('ui::layouts.blank')
@section('content')
    {!! $table !!}
@stop
```

Sampai sini, jika kita buka url `admin/contact-form` akan menampilkan error. Tidak apa-apa, yang penting halaman sudah bisa diakses. Pada langkah selanjutnya kita akan berkenalan dangan [Suitable](https://laravolt.dev/docs/suitable/) untuk menghasilkan tabel yang lengkap dengan fitur filtering, sorting, paginasi, dan ekspor ke PDF serta CSV.

### 1.3. Membuat Tabel Dengan Suitable