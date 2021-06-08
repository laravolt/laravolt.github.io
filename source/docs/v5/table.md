---
title: Table
description: Tabular data
extends: _layouts.documentation
section: content
---

# Table
## Intro
Laravolt Table menyediakan UI untuk menampilkan data dalam bentuk tabular lengkap dengan fitur penunjang sebuah datatable seperti searching, sorting, dan filtering. Laravolt Table berbasis [Livewire](https://laravel-livewire.com/), sehingga interaksi dapat dilakukan tanpa full page refresh. Tidak perlu khawatir juga dengan Javascript karena semua tetek bengek terkait UI sudah ditangani oleh Laravolt. Kita cukup koding PHP-nya saja.

## Membuat Tabel
Karena berbasis Livewire, maka semua Table disimpan di folder `app\Http\Livewire\Table`. Untuk membuat Table baru, cukup jalankan perintah `make:table`:
```bash
php artisan make:table UserTable
```
Selanjutnya, cukup definisikan sumber data dan kolom apa saja yang hendak dimunculkan:
```php
class UserTable extends TableView
{
    public function data()
    {
        // WARNING: tanpa perlu memanggil get() atau paginate() di akhir
        return App\Models\User::where('status', 'ACTIVE');
    }

    public function columns(): array
    {
        return [
            Text::make('nama', 'Nama'),
            Text::make('email', 'Email'),            
        ];
    }
}
```
## Menampilkan Tabel
Untuk menampilkan tabel, cukup panggil Blade component atau Blade directive dari view:

###### resources/views/users/index.blade.php
```php
<livewire:table.user-table />

// atau

@livewire('table.user-table')

// atau

@livewire(\App\Http\Livewire\Table\UserTable::class)

```
### Referensi
- https://laravel-livewire.com/docs/2.x/rendering-components

## Sumber Data
Laravolt Table mampu mengolah beberapa macam sumber data untuk kemudian ditampilkan ke dalam tabel. Opsi yang tersedia untuk bisa dipakai sebagai _return value_ dari _method_ `data()` adalah.

- Array
- Collection
- Eloquent
- Query Builder
- Response dari Http Client

### Array
Sumber data paling sederhana adalah `array`.
```php
public function data()
{
    return [
        ['name' => 'Andi', 'email' => 'andi@example.com'],
        ['name' => 'Budi', 'email' => 'budi@example.com'],
    ];
}
```
### Collection
`\Illuminate\Support\Collection` juga bisa dijadikan sebagai sumber data:
```php
public function data()
{
    $users = [
        ['name' => 'Andi', 'email' => 'andi@example.com'],
        ['name' => 'Budi', 'email' => 'budi@example.com'],
        ['name' => 'Citra', 'email' => null],        
    ];
    
    return collect($users)->reject(fn($user) => $user->email === null);
}
```

### Eloquent
Sumber data yang paling umum digunakan tentu saja Eloquent:
```php
use App\Models\User;

public function data()
{
    return User::query()->whereNull('deleted_at');
}
```
Jika tidak membutuhkan paginasi, kita bisa langsung memanggil `get()` atau `all()`:
```php
use App\Models\User;

public function data()
{
    return User::query()->whereNull('deleted_at')->get();
}
```
&nbsp;
```php
use App\Models\User;

public function data()
{
    return User::all();
}
```

### Query Builder
Jika Eloquent bukan pilihanmu dan lebih memilih Query Builder, kita tetap bisa menerapkan hal yang sama:
```php
use App\Models\User;

public function data()
{
    return \DB::table('users')->whereNull('email'); // paginate() dihandle oleh Laravolt Table
}
```
&nbsp;
```php
use App\Models\User;

public function data()
{
    return \DB::table('users')->get(); // tanpa paginasi
}
```
&nbsp;
```php
use App\Models\User;

public function data()
{
    return \DB::table('users')->all(); // tanpa paginasi
}
```

### Response Dari HTTP Client
Untuk mendapatkan sumber data langsung dari API, kita bisa memanfaatkan [HTTP Client](https://laravel.com/docs/master/http-client) bawaan Laravel:
```php
use Illuminate\Support\Facades\Http;

public function data()
{
    return Http::get('https://jsonplaceholder.typicode.com/users');
}
```
## Column Types
### Avatar
### Boolean
### Button
### Checkall
### Date
### DateTime
### Html
### Id
### Label
### MultipleValues
### Number
### Raw
### RestfulButton
### RowNumber
### Text
### Url
### View

## Custom Column

## Style
## Searching
### Show/Hide Searchbox
### Search Debounce
## Sorting
## Filtering
## Pagination
## Export
## Pooling
## Query String
