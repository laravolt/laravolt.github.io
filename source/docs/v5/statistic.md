---
title: Statistic
description: Display single value
extends: _layouts.documentation
section: content
---

# Statistic
## Intro
Statistic merupakan Livewire Component yang berfungsi menampilkan *single value* data dalam bentuk yang menarik, disertai dengan label dan ikon.

![image-20210903093515083](../assets/uploads/statistic-preview.png)

## Membuat Statistic
Karena berbasis Livewire, maka semua Statistic disimpan di folder `app\Http\Livewire\Statistic`. Untuk membuat Statistic baru, cukup jalankan perintah `make:statistic`:
```bash
php artisan make:statistic TotalUser
```
Selanjutnya, cukup lengkapi skeleton Class yang dihasilkan:
```php
use Laravolt\Ui\Statistic;

class TotalUser extends Statistic
{
    public string $label = 'Total User';

    public ?string $icon = 'user';

    public function value(): int|string
    {
        return \App\Models\User::count();
    }
}
```
## Menampilkan Statistic
Untuk menampilkan chart, cukup panggil Blade component atau Blade directive dari view:

###### resources/views/dashboard.blade.php
```php
<livewire:statistic.total-user />

// atau

@livewire('statistic.total-user')

// atau

@livewire(\App\Http\Livewire\Statistic\TotalUser::class)

```
### Referensi
- https://laravel-livewire.com/docs/2.x/rendering-components



## Label

Untuk mengubah label chart yang ditampilkan, cukup ubah atribut `$title`:

```php
public string $label = 'Pengguna Baru';
```

Jika membutuhkan label dinamis, bisa dengan meng-override *method* `label()`:

```php
public function label(): string
{
    $month = request()->query('month');
    
    return "Total User Baru Bulan $month";
}

```

## Value

Untuk mengeset value yang akan ditampilkan, bisa dengan meng-override *method* `value()`:

```php
public function value(): int|string
{
    // your logic here
    return 999;
}
```

## Color

Untuk mengubah warna statistic, cukup ubah atribut `$color`:

```php
public ?string $color = 'red';
```

Jika membutuhkan warna dinamis, bisa dengan meng-override *method* `color()`:

```php
public function color(): ?string
{
    if (true) {
        return 'blue';
    }
    
    return 'red';
}
```

## Icon

Untuk mengubah ikon, cukup ubah atribut `$icon`:

```php
public ?string $icon = 'user';
```

Jika membutuhkan ikon dinamis, bisa dengan meng-override *method* `icon()`:

```php
public function icon(): ?string
{
    if (true) {
        return 'circle';
    }
    
    return 'user';
}

```

Daftar lengkap ikon yang bisa dipakai bisa dilihat di https://fontawesome.com/icons?d=gallery&p=2&s=duotone&m=pro.

## Title

Untuk mengubah judul atau *heading* dari chart yang ditampilkan, cukup ubah atribut `$title`:

```php
public string $title = 'Total User';
```

Jika membutuhkan judul dinamis, bisa dengan meng-override *method* `title()`:

```php
public function title(): string
{
    $month = request()->query('month');
    
    return "Total User Baru Bulan $month";
}

```

