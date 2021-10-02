---
title: Table
description: Tabular data
extends: _layouts.documentation
section: content
---

# Table
![image-20211002210333023](https://cdn.statically.io/gh/laravolt/storage/master/2021/10/image-20211002210333023-k5QGay.png)

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
        return \App\Models\User::where('status', 'ACTIVE')->paginate();
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
    return User::whereNull('deleted_at')->paginate();
}
```
Jika tidak membutuhkan paginasi, kita bisa langsung memanggil `get()`:
```php
use App\Models\User;

public function data()
{
    return User::query()->whereNull('deleted_at')->get();
}
```

### Query Builder
Jika Eloquent bukan pilihanmu dan lebih memilih Query Builder, kita tetap bisa menerapkan hal yang sama:
```php
public function data()
{
    return \DB::table('users')->whereNull('email')->paginate();
}
```
&nbsp;
```php
public function data()
{
    return \DB::table('users')->get(); // tanpa paginasi
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
      Image::make('profile_picture')
    ];
}
```
`Method` tambahan yang tersedia:
- `height(int $sizeInPixel)` untuk mengatur tinggi gambar.
- `width(int $sizeInPixel)` untuk mengatur lebar gambar.
- `alt(string $text)` untuk mengatur atribut `alt` (alternate text).

### Label
Kolom `Label` digunakan untuk menampilkan sebuah nilai agar terlihat lebih mencolok. Contoh nilai yang cocok ditampilkan sebagai `Label` antara lain: status, kategori, jenis, tipe, dan sejenisnya.

```php
use Laravolt\Suitable\Columns\Label;

public function columns(): array
{
    return [
        Label::make('status'),
    ];
}
```
Untuk menambahkan kelas CSS kepada `Label`, bisa memanfaatkan _method_ `addClass`:

```php
use Laravolt\Suitable\Columns\Label;

public function columns(): array
{
    return [
        Label::make('status')->addClass('green small'),
    ];
}
```

Ada beberapa kelas **_built in_**  yang bisa dipakai untuk menentukan warna sebuah `Label`, yaitu `red`, `orange`, `yellow`, `olive`, `green`, `teal`, `blue`, `violet`, `purple`, `pink`, `brown`, `grey`, `black`.

Pada prakteknya, ada kebutuhan untuk memberikan warna yang berbeda untuk setiap _value_. Hal ini bisa dilakukan dengan memanfaatkan _method_ `map()`:

```php
use Laravolt\Suitable\Columns\Label;

public function columns(): array
{
    return [
        Label::make('status')->map([
            'active' => 'green',
            'banned' => 'red',
        ]),
    ];
}
```

### Number
Kolom `Number` digunakan untuk menampilkan sebuah _value_ dalam format angka yang lebih manusiawi. Sebagai contoh, sebuah nilai 1000000 akan secara otomatis diubah menjadi **1.000.000** dan ditampilkan **rata kanan**.

```php
use Laravolt\Suitable\Columns\Number;

public function columns(): array
{
    return [
        Number::make('gaji',)
    ];
}
```
Format angka yang saat ini digunakan adalah format yang umum dipakai di Indonesia.

### Raw
Kolom `Raw` digunakan untuk menampilkan sebuah `value` **apa adanya** (_unescaped)_, tanpa melewati fungsi `htmlspecialchars`. Hati-hati ketika menggunakan `Raw` untuk sebuah _value_ yang berasal dari inputan _user_, karena ada peluang terjadinya _**Cross Site Scripting (XSS)**_.

```php
use Laravolt\Suitable\Columns\Raw;

public function data()
{
    return [
        ['bio' => '<b>Strong</b><script>alert("foo")</script>'],
    ];
}

public function columns(): array
{
    return [
        Raw::make('bio'),
    ];
}
```
Pada contoh di atas, kita akan mendapatkan sebuah tulisan **Strong** (dalam huruf tebal) dan kode Javascript untuk menampilkan _alert_ akan dieksekusi oleh _browser_.

Jika membutuhkan *custom logic* yang lebih leluasa, maka jenis kolom `Raw` juga bisa menerima *Closure*:

```php
// Menampilkan list of roles dari seorang user, dipisahkan dengan koman
Raw::make(
    function ($user) {
        return $user->roles->implode('name', ', ');
    },
    'Roles'
),
```



### RestfulButton
Kolom `RestfulButton` digunakan untuk membuat tombol-tombol standard sebuah proses _create-read-update-delete_ atau **CRUD**. Kita hanya perlu mendefinisikan _resource name_ untuk kemudian dihasilkan tiga buat tombol **show**, **edit**, dan **destroy**. 
```php
use Laravolt\Suitable\Columns\RestfulButton;

public function columns(): array
{
    return [
        RestfulButton::make('users'),
    ];
}
```
Pada contoh kode di atas, ketiga tombol yang dihasilkan akan memiliki route:

- show: `route('users.show', <id>)`
- edit: `route('users.edit', <id>)`
- destroy: `route('users.destroy', <id>)`

`<id>` otomatis diambil dari _primary key_ _object_ yang bersangkutan. Oleh sebab itu, `RestfulButton` **hanya bisa dipakai jika sumber data berasal dari Eloquent**.

_Method_ tambahan yang tersedia:

- `only($action1, $action2)` jika hanya ingin menampilkan aksi tertentu saja, misalnya `only('show')`.
- `except($action1, $action2)` jika ingin menghilangkan tombol tertentu, misalnya `except('destroy')`.

Untuk memahami lebih lanjut tentang _resource controller_, silakan membaca [dokumentasi resmi dari Laravel](https://laravel.com/docs/8.x/controllers#resource-controllers).

### RowNumber
Kolom `RowNumber` digunakan untuk menampilkan nomor baris secara terurut, dimulai dari 1. 

```php
use Laravolt\Suitable\Columns\RowNumber;

public function columns(): array
{
    return [
        RowNumber::make(),
    ];
}
```
### Text
Kolom `Text` digunakan untuk menampilkan value secara aman, terhindar dari **_Cross Site Scripting (XSS)_**, memanfaatkan fungsi `htmlspecialchars` bawaan PHP.
```php
use Laravolt\Suitable\Columns\Text;

public function data()
{
    return [
        ['bio' => '<b>Strong</b><script>alert("foo")</script>'],
    ];
}

public function columns(): array
{
    return [
        Text::make('bio'),      
    ];
}
```
Pada contoh di atas, "bio" akan ditampilkan apa adanya sesuai teks yang tertulis:
```text
<b>Strong</b><script>alert("foo")</script>
```
### Text vs Html vs Raw
Ada tiga kolom yang bisa digunakan untuk menampilkan konten yang berasal dari WYSIWYG dan mengandung tag HTML (dan Javascript). Berikut ini adalah perbedaan dari ketiganya:

| Kolom|      Output                                      |      Keterangan                            |
| -----| ------------------------------------------------- | ------------------------------------------------- |
| Text      |    `<b>Strong</b> <script>alert("foo")</script>`   |   Paling aman, menampilkan teks apa adanya.   |
| Html | **Strong** `<script>alert("foo")</script>` | Jika hanya ingin mengeksekusi tag HTML saja. |
| Raw  |      **Strong** (dan muncul alert di browser)    |    Jika ingin mengeksekusi sepenuhnya kode HTML dan Javascript.    |


### Url
Kolom `Url` digunakan untuk menampilkan sebuah URL secara otomatis menjadi _link_ yang bisa diklik.
```php
use Laravolt\Suitable\Columns\Url;

public function columns(): array
{
    return [
        Url::make('website),
    ];
}
```
### View
Ketika tampilan semakin kompleks, kita bisa memanfaatkan kolom `View` untuk memindahkan _logic_ untuk merender isi sebuah kolom ke sebuah file blade terpisah.
```php
use Laravolt\Suitable\Columns\View;

public function columns(): array
{
    return [
        View::make('profil')
    ];
}
```
Lalu buat sebuah file blade `profil.blade.php`:
###### resources/views/profil.blade.php
```html
<dl>
    <dt>Name</dt>
    <dd>{{ $data->name }}</dd>
    <dt>Email</dt>
    <dd>{{ $data->email }}</dd>
</dl>
```

## Custom Column

Jika kamu tidak menemukan jenis Column yang sesuai, maka `Raw` merupakan pilihan pertama untuk menampilkan data dengan *custom logic* buatan sendiri. 

Jika *custom logic* tersebut dibutuhkan di beberapa tempat, dan kamu ingin menerapkan prinsip ***Don't Repeat Yourself (DRY)***, maka membuat sebuah Class khusus untuk *custom column* menjadi pilihan yang lebih bijak.

Berikut ini adalah kerangka dari sebuah *custom column* yang berfungsi untuk melakukan *masking* terhadap data yang ditampilkan:

```php
<?php

namespace App\Tables\Columns;

use Laravolt\Suitable\Columns\Column;
use Laravolt\Suitable\Columns\ColumnInterface;

class MaskColumn extends Column implements ColumnInterface
{
    public function cell($cell, $collection, $loop)
    {
        return \Str::mask($cell->{$this->field});
    }
}

```

Yang perlu dibuat hanyalah sebuah *class* yang *extends* `Column` (base class), mengimplementasikan *ColumnInterface*, dan mendefinisikan *logic* untuk menampilkan data pada fungsi *cell($cell, $collection, $loop)*.

**`$cell`** merupakan item dari Colllection  (bisa Eloquent model atau obyek lain) yang saat ini akan ditampilkan di dalam *cell* dari sebuah tabel.

**`$collection`** adalah keseluruhan data (Collection).

**`$loop`** berisi informasi tentang *looping*, sesuai [dokumentasi dari Laravel](https://laravel.com/docs/master/blade#the-loop-variable).

Pada contoh di atas, *custom column* disimpan di `app/tables/columns`. Ini bukan aturan baku. Silakan sesuaikan namespace sesuai struktur aplikasimu.

## Style

TBD

## Searching

### Search Query

Ketika pengguna mengetikkan sesuatu di kolom pencarian (searchbox), maka isian tersebut akan otomatis di-*binding* ke properti `$search`, sehingga kita bisa mengaksesnya dengan memanggil `$this->search`.

Berikut ini contoh kode untuk melakukan pencarian berdasar nama:

```php
class UserTable extends TableView
{
    public function data()
    {
        return \App\Models\User::where('status', 'ACTIVE')
            ->whereLike(['name', 'email'], $this->search)
            ->paginate();
    }
}
```

>  `whereLike` merupakan *method* tambahan dari Laravolt untuk melakukan pencarian ke beberapa kolom sekaligus dengan mekanisme `where <kolom> like "%<keyword>%"`. Untuk data yang banyak, query ini bisa jadi tidak optimal. Silakan buat sendiri *logic* pencarian sesuai kebutuhan.

### Show/Hide Searchbox

```php
class UserTable extends TableView
{
    public bool $showSearchbox = false; // default to "true"
}
```



### Search Debounce

Setiap kali User mengetikkan sesuatu di searchbox, query pencarian akan otomatis dijalankan dengan mekanisme AJAX. Debounce adalah mekanisme **menunggu beberapa saat** hingga User dianggap benar-benar sudah berhenti mengetik, baru kemudian dilakukan query untuk mengupdate data yang ditampilkan.

```php
class UserTable extends TableView
{
	public int $searchDebounce = 1000; // in miliseconds, default to 300
}
```



## Sorting

Ketika mendefinisikan tabel, kita bisa menambahkan fungsi `sortable()` pada setiap kolom yang terdefinisi. Secara otomatis, kolom tersebut akan bisa diklik.

```php
class UserTable extends TableView
{
    public function data()
    {
        return \App\Models\User::where('status', 'ACTIVE')->paginate();
    }

    public function columns(): array
    {
        return [
            Text::make('nama', 'Nama')->sortable(),
            Text::make('email', 'Email')->sortable(),            
        ];
    }
}
```

Tapi jangan lupa, kita juga perlu melakukan modifikasi *query* agar data yang dihasilkan juga ikut terurut. Laravolt sudah menyediakan Trait `AutoSort` untuk meng-*handle* kebutuhan tersebut.

Pertama-tama, pastikan Model yang menjadi sumber data sudah menggunakan `AutoSort`:

```php
namespace App\Models;

use Laravolt\Suitable\AutoSort;

class User extends Model
{
    use AutoSort;
}
```

Selanjutnya, kita cukup memanggil fungsi *autoSort()* ketika melakukan *query* pengambilan data:

```php
class UserTable extends TableView
{
    public function data()
    {
        return \App\Models\User::where('status', 'ACTIVE')
            ->autoSort($this->sortPayload())
            ->paginate();
    }
}
```



## Filtering

## Pagination
## Export
## Pooling
## Query String

Setiap kali User melakukan interaksi dengan Table, maka ***state*** saat ini akan disimpan sebagai *query string*. Sebagai contoh, setelah mencari data dengan keyword "foo", maka URL dari browser akan otomatis berubah menjadi:

```http
/users?search=foo
```

Keuntungan yang didapat dengan menyimpan ***state*** secara eksplisit di URL antara lain:

1. User bisa membagi URL saat ini dengan mudah.
1. Ketika User me-refresh browser, data yang ditampilkan akan sesuai dengan ***state*** terakhir. 

Berikut ini adalah ***state*** yang secara otomatis akan mengubah *query string* di *browser*:

```php
protected $queryString = [
    'page' => ['except' => 1],
    'search' => ['except' => ''],
    'sort' => ['except' => null],
    'direction',
    'perPage' => ['except' => self::DEFAULT_PER_PAGE],
];
```

Silakan pelajari [dokumentasi resmi dari Livewire](https://laravel-livewire.com/docs/2.x/query-string) terkait *query string*.

Namun, jika karena suatu hal kamu tidak menginginkan *behaviour* di atas (misalnya ketika harus menampilkan 2 tabel dalam satu halaman yang sama), maka cukup kosongkan properti `$queryString` :

```php
class UserTable extends TableView
{
    protected $queryString = [];   
}
```

Selanjutnya, setiap kali User berinteraksi dengan tabel (*searching, sorting, filtering, pagination*), URL browser tidak akan ikut berubah.

## Table Action
