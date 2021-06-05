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
```html
<livewire:table.user-table />

atau

@livewire('table.user-table')
```
### Referensi
- https://laravel-livewire.com/docs/2.x/rendering-components

## Sumber Data
### Eloquent
### Query Builder
### Array
### Collection
### HTTP Client

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
