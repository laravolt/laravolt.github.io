---
title: Chart
description: Livewire chart component powered by ApexCharts
extends: _layouts.documentation
section: content
---

# Chart
## Intro
Laravolt Chart merupakan Livewire Component untuk menampilkan *chart*, memanfaatkan library [ApexCharts](https://apexcharts.com/). Laravolt Chart bertindak sebagai *wrapper* sehingga kamu tidak perlu menulis kode Javascript sama sekali. Semua opsi bisa diatur dengan kode PHP di Livewire Component.

## Membuat Chart
Karena berbasis Livewire, maka semua Chart disimpan di folder `app\Http\Livewire\Chart`. Untuk membuat Chart baru, cukup jalankan perintah `make:chart`:
```bash
php artisan make:chart DailyRegistration
```
Selanjutnya, cukup definisikan sumber data dan olah lebih lanjut agar formatnya sesuai dengan contoh yang diberikan:
```php
class DailyRegistration extends Line
{
    public string $title = 'Foo';

    public function series(): array
    {
        return [
            'series-1' => [
                'Label 1' => 10,
                'Label 2' => 14,
                'Label 3' => 40
            ],
        ];
    }
}
```
## Menampilkan Chart
Untuk menampilkan chart, cukup panggil Blade component atau Blade directive dari view:

###### resources/views/dashboard.blade.php
```php
<livewire:chart.daily-registration />

// atau

@livewire('chart.daily-registration')

// atau

@livewire(\App\Http\Livewire\Chart\DailyRegistration::class)

```
### Referensi
- https://laravel-livewire.com/docs/2.x/rendering-components



## Title

Untuk mengubah judul atau *heading* dari chart yang ditampilkan, cukup ubah atribut `$title`:

```php
public string $title = 'Data Harian Pengguna Baru';
```

Jika membutuhkan judul dinamis, bisa dengan meng-override *method* `title()`:

```php
public function title(): string
{
    $month = request()->query('month');
    
    return "Data Penjualan Bulan $month";
}

```



## Height

Untuk mengubah tinggi dari chart yang ditampilkan, cukup ubah atribut `$height`:

```php
protected int $height = 500;
```

Jika membutuhkan pengaturan *height* secara dinamis, bisa dengan meng-override *method* `height()`:

```php
public function height(): int
{
	if (auth()->user()->isAdmin()) {
        return 100;
    }
    
    return 400;
}

```



## Chart Type

Untuk mengubah tipe chart yang ditampilkan, cukup ubah base class yang di-*extends*. Saat ini tipe chart yang tersedia adalah:

- Laravolt\Charts\Bar
- Laravolt\Charts\Line
- Laravolt\Charts\Area
- Laravolt\Charts\Donut

### Bar

```php
use Laravolt\Charts\Bar;

class DailyRegistration extends Bar
{
    
}
```



### Line

```php
use Laravolt\Charts\Line;

class DailyRegistration extends Line
{
    
}
```



### Area

```php
use Laravolt\Charts\Area;

class DailyRegistration extends Area
{
    
}
```



### Donut

```php
use Laravolt\Charts\Donut;

class DailyRegistration extends Donut
{
    
}
```



## Contoh Pengolahan Data

Di bawah ini adalah contoh kode untuk menampilkan data registrasi pengguna setiap bulan selama setahun.

```php
public function series(): array
{
    // Inisiasi data 12 bulan dengan value 0.
    // Ingat, array dimulai dari index 0.
    $months = collect()->pad(12, 0);


    // Ambil data registrasi bulanan.
    // Di step ini, tidak semua bulan ada datanya.
    $users = User::whereYear('created_at', now()->year)
        ->pluck('created_at')
        ->countBy(function ($createdAt) {
            // kurangi dengan 1, agar sesuai dengan index array yang dimulai dari 0
            return Carbon::parse($createdAt)->month - 1;
        });

    // Oleh sebab itu, kita gabungkan data bulanan riil dengan data 12 bulan kosongan,
    // agar array yang dihasilkan tetap 12
    $data = $users->union($months)->toArray();
    
    return [
        'registered' => $data,
    ];
}

public function labels(): array
{
    return ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
}

```

Laravolt Chart tidak peduli dari mana data yang ditampilkan berasal, selama format akhirnya dalam bentuk array:

```php
return [
    'series-name' => [12, 12, 89, 43, 99],
    'another-series' => [20, 30, 40, 44, 50],
];
```



## Label

*By default*, label akan diambil dari `key` array yang dikembalikan oleh *method* `series()`. Untuk mengubahnya, kita bisa meng-*override* *method* `labels()`:

```php
public function labels(): array
{
    return ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
}

```



## Chart Options

Ada cukup banyak *options* yang disediakan oleh ApexCharts untuk mengatur bagaimana sebuah *chart* ditampilkan. *By default*, tidak semua opsi tersebut diaktifkan.

Jika kamu ingin mengubah atau menambahkan opsi, bisa dilakukan dengan meng-*override* *method* `options()`. Sebagai contoh, kita bisa mengubah [posisi *legend*](https://apexcharts.com/docs/options/legend/) dari bawah (nilai default) ke atas dengan mengeset opsi `legend.position`:

```php
public function options(): array
{
    $defaultOptions = parent::options();
    $additionalOptions = [
        'legend' => [
            'position' => 'top',
        ],
    ];

    // merge both options
    return $additionalOptions + $defaultOptions;
}
```

Dokumentasi lengkap *options* dari ApexCharts bisa dibaca di https://apexcharts.com/docs.
