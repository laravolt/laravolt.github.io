---
title: Flash Message (Toast)
description: Flash message for next (or current) request
extends: _layouts.documentation
section: content
---

# Flash Message (Toast)
## Intro
Laravolt akan mendeteksi secara otomatis setiap pesan error dari _form validation_ dan session dengan key khusus, lalu mengubahnya menjadi **_flash message_** atau toast di halaman web.

## Form Validation Message
Ketika ada pesan error dari proses validasi form, maka Laravolt akan otomatis menampilkannya di halaman web. Tidak perlu menambahkan apapun.
```php
// Somewhere in Controller
$request->validate([
    'start_date_project' => 'required',
    'end_date_project' => 'required',
    'maintenance_date' => 'required',
]);
```

> Ketika proses instalasi Laravolt, middleware `Laravolt\Middleware\DetectFlashMessage` akan ditambahkan secara otmatis 
> ke $middlewareGroups "web" pada file `app/Http/Kernel.php`.
> Jika flash message tidak muncul, silakan cek kembali konfigurasi _middleware_ Anda.

## Session Flash Message
Flash message biasanya ditampilkan untuk next request, sehingga umum digabungkan dengan pemanggilan `redirect()` di Controller:
```php
// in Controller
return redirect()->to('home')->with('info', 'Welcome back');
return redirect()->to('home')->with('success', 'Profile updated');
return redirect()->to('home')->with('warning', 'Please complete your profile');
return redirect()->to('home')->with('error', 'Sorry, dashboard not available right now');
```

## Flash Message for Current Request
Jika diperlukan menampilkan flash message untuk request saat ini, bisa memanggil helper `session()->now()`:
```php
class HomeController 
{
    public function index()
    {
        session()->now('info', 'Welcome back');
        session()->now('success', 'Profile updated');
        session()->now('warning', 'Please complete your profile');
        session()->now('error', 'Sorry, dashboard not available right now');
        
        return view('home');
    }
}
```
