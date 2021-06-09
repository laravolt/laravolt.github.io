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
Kolom `Avatar` digunakan untuk menampilkan gambar avatar secara otomatis dari **inisial**. Pada contoh di bawah ini, inisial dari email akan digunakan untuk menghasilkan gambar avatar yang sesuai.
```php
use Laravolt\Suitable\Columns\Avatar;

public function columns(): array
{
    return [
        Avatar::make('email', 'Avatar'),
    ];
}
```
Dokumentasi lengkap tentang `Avatar` bisa dibaca di https://github.com/laravolt/avatar.
### Boolean
Kolom `Boolean` digunakan untuk menampilkan nilai **_true_** atau **_false_** dalam bentuk ikon. Nilai yang tidak bertipe `boolean` akan di-_casting_ secara otomatis ke tipe `(bool)`.
```php
use Laravolt\Suitable\Columns\Boolean;

public function columns(): array
{
    return [
        Boolean::make('is_active'),
    ];
}
```
### Button
Kolom `Button` digunakan untuk menambahkan tombol yang berfungsi sebagai navigasi untuk berpindah ke halaman lain.

```php
use Laravolt\Suitable\Columns\Button;

public function columns(): array
{
    return [
        Button::make('permalink', 'Info')->label('Profile')->icon('external link'),
    ];
}
```
Pada contoh di atas, `permalink` berisi sebuah url yang valid, baik itu hardcoded "http://example.com" atau hasil dari pemanggilan fungsi `route()` atau `url()` di Laravel:
```php
class User extends Model 
{
    public function getPermalinkAttribute()
    {
        return route('users.show', $this->id);
    }
}
```
`Button::make()` juga menerima `Closure` untuk meng-generate url secara dinamis ketika pemanggilan:
```php
use Laravolt\Suitable\Columns\Button;

public function columns(): array
{
    return [
        // bisa memakai sintaks baru (arrow function)
        Button::make(fn ($user) => route('users.show', $user['id'])),

        // atau cara lama yang lebih panjang
        Button::make(
            function ($user) {
                return route('users.show', $user['id']);
            }
        ),    
    ];
}
```

### Checkall
Kolom `Checkall` digunakan untuk menambahkan **checkbox** di setiap baris yang selanjutnya bisa digunakan sebagai _multiple selection_. ID yang  telah dipilih (dicentang) selanjutnya bisa dikirim sebagai parameter ketika kita mendefinisikan `Table Action`.

```php
use Laravolt\Suitable\Columns\Checkall;

public function columns(): array
{
    return [
        Checkall::make('id'),
    ];
}
```
### Date
Kolom `Date` digunakan untuk mengubah tanggal dari database dengan format format `2021-06-02` menjadi tanggal yang lebih manusiawi untuk dibaca, yaitu **2 Juni 2021**.
```php
use Laravolt\Suitable\Columns\Date;

public function columns(): array
{
    return [
        Date::make('created_at'),
    ];
}
```
Ada _method_ tambahan yang tersedia untuk tipe kolom `Date`, yaitu:

- `format(string $format)` dimana $format adalah string yang sesuai dengan format yang diterima oleh [Moment.js](https://momentjs.com/).
- `timezone(string $timezone)` untuk melakukan konversi otomatis tanggal ke timezone yang sesuai. Daftar timezone yang valid bisa dilihat di [dokumentasi resmi PHP](https://www.php.net/manual/en/timezones.php). Jika tidak memanggil `timezone()` secara eksplisit, maka konversi ke timezone akan dilakukan dengan melihat:
    - Atribut `timezone` dari user yang sedang login: `auth()->user()->timezone`.
    - Jika null, timezone akan dilihat dari `config('app.timezone')`.

### DateTime
Mirip seperti kolom `Date`, `DateTime` mengubah nilai **2021-06-02 22:54:00** menjadi **2 Juni 2021 pukul 22.45**.
```php
use Laravolt\Suitable\Columns\DateTime;

public function columns(): array
{
    return [
        DateTime::make('created_at'),   
    ];
}
```
_Method_ `format()` dan `timezone()` juga tersedia, dengah _behaviour_ yang sama dengan kolom `Date`.
### Html
Kolom `Html` digunakan jika konten yang akan ditampilkan mengandung _tag_ HTML, dan kita ingin menampilkannya sesuai format HTML.
```php
public function data()
{
    return [
        ['bio' => '<b>Strong</b> <i>foo</i>'],
    ];
}

public function columns(): array
{
    return [
        Html::make('bio')
    ];
}
```
Pada contoh di atas, tabel akan menampilkan konten sebagai "**Strong** _foo_". Kolom ini biasa digunakan ketika data yang disimpan berasar dari **WYSIWYG** atau **_rich text editor_** seperti  redactor dan tinymce.

### Id
Kolom `Id` digunakan untuk menampilkan primary key dari sebuah model Eloquent. Di balik layar, kolom ini akan memanggil `getKey()`. Jadi pastikan hanya menggunakan kolom ini ketika sumber data berasal dari Eloquent.
```php
use Laravolt\Suitable\Columns\Id;

public function columns(): array
{
    return [
      Id::make(),
    ];
}
```
### Image
```php
use Laravolt\Suitable\Columns\Image;

public function columns(): array
{
    return [
    ];
}
```

### Label
```php
use Laravolt\Suitable\Columns\Label;

public function columns(): array
{
    return [
    ];
}
```
### MultipleValues
```php
use Laravolt\Suitable\Columns\MultipleValues;

public function columns(): array
{
    return [
    ];
}
```
### Number
```php
use Laravolt\Suitable\Columns\Number;

public function columns(): array
{
    return [
    ];
}
```
### Raw
```php
use Laravolt\Suitable\Columns\Raw;

public function columns(): array
{
    return [
    ];
}
```
### RestfulButton
```php
use Laravolt\Suitable\Columns\RestfulButton;

public function columns(): array
{
    return [
    ];
}
```
### RowNumber
```php
use Laravolt\Suitable\Columns\RowNumber;

public function columns(): array
{
    return [
    ];
}
```
### Text
```php
use Laravolt\Suitable\Columns\Text;

public function columns(): array
{
    return [
    ];
}
```
### Url
```php
use Laravolt\Suitable\Columns\Url;

public function columns(): array
{
    return [
    ];
}
```
### View
```php
use Laravolt\Suitable\Columns\View;

public function columns(): array
{
    return [
    ];
}
```

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
## Table Action
