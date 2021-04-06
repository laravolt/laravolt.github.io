---
title: Troubleshooting
description: Solusi dari permasalahan yang sering ditemui
extends: _layouts.documentation
section: content
---

# Troubleshooting
## `laravel.log` could not be opened: failed to open stream: Permission denied

Biasa ditemui ketika deployment di CentOS.
>https://stackoverflow.com/questions/37257975/permissions-issue-with-laravel-on-centos

## URL yang di-generate selalu http meskipun sudah menggunakan SSL.

Hal ini biasa dialami ketika menerapkan arsitektur `reversed proxy`. Laravel tidak bisa melakukan deteksi otomatis skema request, sehingga harus diberi tahu secara manual dengan cara:

```php
if ($this->app->environment('production', 'staging', 'testing')) {
    \Illuminate\Support\Facades\URL::forceScheme('https');
}
```
Potongan kode di atas bisa ditambahkan dimanapun ketika aplikasi booting, misalnya di dalam method `boot` dalam `RouteServiceProvider`.

Jangan lupa untuk menyesuaikan nilai `APP_ENV` di file `.env` di server production/staging/testing.

## Setup Laravel di Nginx sebagai subdirektori
https://serversforhackers.com/c/nginx-php-in-subdirectory
[TODO: setup demo site + validasi tutorial di atas]
```
// nginx.conf

...

location /subdirektori/ {
    #dibawah ini adalah configuration pada arsitektur reversed_proxy.
    
    rewrite /subdirektori(.*) $1 break;
    proxy_set_header Accept-Encoding "";
    proxy_pass http://xxx.xxx.xxx.xxx:xxxx;
}
```

dan tambahkan ketika aplikasi laravel booting
```php
use Illuminate\Support\Facades\URL;

...

URL::forceRootUrl('https://domainkamu.id/subdirektori');

...
```

## Setup Laravel dengan load balancing

### Session
agar session dapat belajar, session harus disimpan di tempat yang bisa dipakai bersama,
contoh dengan menggunakan `SESSION_DRIVER` = `database` atau `redis`

lalu pada configurasi laravel harus menggunakan `session.domain` (cek file `config/session.php`) yang sama dengan cara menambahkan _key-value_ pada `.env`
```
SESSION_DOMAIN=example.com
```

lalu tambahkan middleware baru dari package `fideloper/trustproxy`

nb : biasanya aplikasi laravel sudah menambahkan middleware ini pada default aplikasi laravel sejak laravel 5.5

jika belum tambahkan dengan cara 
1. tambah dependency dari https://github.com/fideloper/TrustedProxy
2. Tambahkan middleware pada `App\Http\Kernel.php`
```php
protected $middleware = [
    ...
    'Fideloper\Proxy\TrustProxies',
    ...
];
```
