---
title: Suitable
description: Datatable dengan style Fomantic UI
extends: _layouts.documentation
section: content
---

# Suitable

## Intro

Suitable adalah helper untuk menampilkan data dari Eloquent menjadi tabel (datatable) dengan struktur HTML sesuai standard Fomantic UI. Fitur-fitur yang tersedia:

1. Membuat *full featured datatable* dengan 1 baris kode
2. Column sorting (server side)
3. Column filtering (server side)
4. Searching (server side)
5. Ekspor ke PDF, CSV, XLS, XLSX (server side)
6. Pagination (server side)
7. Custom column definition

Semua pengolahan data dilakukan di server side tanpa bantuan Javascript. Untuk meningkatkan response time ketika melakukan navigasi, sangat disarankan untuk menggunakan teknologi seperti:

- [Turbolinks](https://github.com/turbolinks/turbolinks)
- [Pjax (Versi jQuery)](https://github.com/defunkt/jquery-pjax)
- [Pjax (Versi Non jQuery)](https://github.com/MoOx/pjax)
- https://swup.js.org/

Penggunaan salah satu teknologi di atas memungkinkan untuk melakukan transisi halaman web secara lebih halus, tanpa full page refresh. Aplikasi web bisa dibuat seolah-olah mirip Single Page Application, meskipun stack yang digunakan murni server side rendering.

## Installation

```bash
composer require laravolt/suitable
```

Jika diperlukan, `config` dan `views` bisa di-*publish* untuk dimodifikasi sesuai kebutuhan:

```bash
php artisan vendor:publish --tag=views --tag=config --provider="Laravolt\Suitable\ServiceProvider"
```

## Konfigurasi

##### `laravolt.suitable.query_string.sort_by`

Query string untuk menentukan kolom sorting.

Default value: `“sort”`

##### `laravolt.suitable.query_string.sort_direction`  

Query string untuk metode sorting.

Default value: `“direction”`

##### `laravolt.suitable.query_string.search`  

Query string untuk keyword pencarian.

Default value: `“search”`

##### `laravolt.suitable.restful_button.delete_confirmation_fields`

Nama-nama kolom yang akan dipakai sebagai *identifier* ketika menampilkan konfirmasi penghapusan data. Suitable akan mengecek semua kolom yang diisikan dan mengambil kolom pertama yang cocok. 

Default value: `['title', 'name']`

## Cara Pemakaian

Ada 2 cara pemakaian Suitable untuk menampilkan tabel, yaitu sebagai HTML Builder atau sebagai TableView. Sebagai HTML Builder, kamu langsung memanggil helper class `Suitable` untuk mendefinisikan tabel yang ingin dihasilkan. Builder hanya bertugas menghasilkan `string` HTML. Titik.

Sedangkan sebagai TableView, sebuah tabel direpresentasikan dalam sebuah kelas `TableView` dimana kelas ini selain bertanggung jawab menghasilkan string HTML juga dapat digunakan untuk memanipulasi response dari `Controller`, misalnya untuk menghasilkan file PDF atau spreadsheet.

## HTML Builder

Penggunaan paling sederhana Suitable adalah sebagai HTML builder, dimana Suitable dapat menghasilkan tag HTML untuk menampilkan data dalam bentuk tabel. Output yang dihasilkan, setelah memanggil method `render()`, hanyalah string biasa. Oleh karena itu, pemanggilan Suitable bisa dilakukan dimana saja.

Memanggil `render()` langsung di view:

###### resources/views/users/index.blade.php

```php
{!! Suitable::source($data)->columns(['id','name'])->render() !!}
```

Atau bisa juga menyimpan string hasil `render()` ke sebuah variable sehingga view tinggal menampilkan saja:

###### UserController.php

```php
public function index()
{
  	$data = \App\User::all();
  	$table = Suitable::source($data)->render();

  return view('users.index', compact('table'));
}
```

###### resources/views/users/index.blade.php

```php
{!! $table !!}
```



### Contoh Pemakaian

##### Basic Table

```php
Suitable::source($users)
  ->columns(['id', 'name', 'email'])
  ->render()
```

![image-20190621232445948](../assets/uploads/006tNc79gy1g49a7v9tl0j30h707574i.jpg)

##### Custom Header

```php
Suitable::source($users)
  ->columns([
    'id',
    ['header' => 'Nama', 'field' => 'name'],
    ['header' => 'Surel', 'field' => 'email'],
  ])
  ->render()
```

![image-20190621234309592](../assets/uploads/006tNc79gy1g49a2qsvsgj30gu06tgm7.jpg)

##### Raw HTML

```php
Suitable::source($users)
  ->columns([
    'id',
    ['header' => 'Nama', 'field' => 'name'],
    ['header' => 'Surel', 'raw' => function ($user) {
      return sprintf('<a href="mailto:%s">%s</a>', $user->email, $user->email);
    }],
  ])
  ->render()
```

![image-20190622000047520](../assets/uploads/006tNc79gy1g49a2s7qfuj30gt076gma.jpg)

##### Custom Cell View

###### resources/views/custom-cell.blade.php

```php
// Variable $data secara otomatis tersedia, merupakan item (object Eloquent) untuk row tersebut
Custom cell untuk user dengan ID {{ $data->getKey() }}
```

**Perhatian:** Tidak perlu menambahkan tag `<td>` karena Suitable akan menambahkannya secara otomatis.

###### resouces/views/index.blade.php

```php
Suitable::source($users)
  ->columns([
    'id',
    ['header' => 'Nama', 'field' => 'name'],
    ['header' => 'Custom Cell', 'view' => 'custom-cell'],
  ])
  ->render()
```

![image-20190622010510594](../assets/uploads/image-20190622010510594.png)

##### Custom Row View

Jika ingin membuat struktur row yang kompleks, maka bisa memanfaatkan method `row(string $view)`. Dengan custom row, maka struktur tabel bisa dikreasikan sebebas mungkin, misalnya melakukan merge cell dengan `rowspan`.

###### resources/views/custom-row.blade.php

```html
<tr>
    <td rowspan="2">{{ $data->getKey() }}</td>
    <td><strong>{{ $data->name }}</strong></td>
</tr>
<tr>
    <td>{{ $data->email }}</td>
</tr>
```

###### resources/views/index.blade.php

```php
Suitable::source($users)
  ->columns([
    'id',
    'Name/Email',
  ])
  ->row('custom-row')
  ->render()
```

![image-20190622011826523](../assets/uploads/image-20190622011826523.png)

##### Searchbox

Untuk menampilkan kotak pencarian bisa memanggil method `search()`.

```php
Suitable::source($users)
    ->columns(['id', 'name', 'email'])
    ->search()
    ->render()
```

![image-20190626212032177](../assets/uploads/image-20190626212032177.png)

Melakukan pencarian di searchbox akan membuat terjadinya request ke URL saat ini dengan tambahan query string `?search=<foo>`. Query string `search` tersebut selanjutnya bisa digunakan di Controller untuk melakukan query ke database.

```php
class UserController 
{
    public function index()
    {
        $keyword = request()->get('search');       
        $users = \App\User::where('name', 'like', "%$keyword%")->get();

        // more action here...
    }
}
```

Query string bisa diganti dengan memberikan argumen ke fungsi `search($param)`.

```php
Suitable::source($users)
    ->columns(['id', 'name', 'email'])
    ->search('keyword')
    ->render()
```

Kode di atas akan menghasilkan URL seperti di bawah ini ketika pencarian dilakukan lewat searchbox yang disediakan:

```html
http://localhost/users?keyword=foo
```

Untuk mengganti nama query string secara global, bisa mengubah konfigurasi `laravolt.epicentrum.query_string.search`. 

> File konfigurasi bisa ditemukan di `config/laravolt/epicentrum.php`. 
>
> Jika file konfigurasi tidak tersedia, silakan lakukan langkah *publish vendor file* terlebih dahulu.

##### Column Filtering

Jika ingin menambahkan searchbox untuk kolom tertentu, bisa menambahkan opsi `searchable => <boolean>|<string>`.

```php
Suitable::source($users)
    ->columns([
        'id',
        ['header' => 'Nama', 'field' => 'name', 'searchable' => true],
        ['header' => 'Surel', 'field' => 'email', 'searchable' => 'email_adddress'],
    ])
    ->render()

```

![image-20190627061005673](../assets/uploads/image-20190627061005673.png)

Pencarian bisa dilakukan dengan mengetikkan sesuatu di searchbox lalu **menekan tombol enter**. Pada contoh di atas, URL yang dihasilkan ketika melakukan pencarian adalah:

```html
http://localhost/users?filter[name]=foo&filter[email_address]=bar
```

Selanjutnya, query string `filter` bisa digunakan di Controller untuk melakukan filtering terhadap data yang ditampilkan, misalnya seperti di bawah ini:

```php
class UserController 
{
    public function index()
    {
        $query = \App\User::query();
        $filters = request()->get('filter');               
        foreach ($filters as $column => $keyword) {
            $query->where($column, 'like', "%$keyword%");
        }
		$users = $query->get();
        
        // more action here...
    }
}
```

> Suitable menyediakan Trait [AutoFilter](#auto-filter) yang bisa dipasang di Model. Setelah terpasang,  Model bisa memanggil scope `autoFilter()` dan secara otomatis akan menangani proses filtering data berdasar query string.

##### Column Sorting

Header kolom bisa dibuat agar *clickable* dan menghasilkan query string yang sesuai untuk proses sorting data dengan menambahkan opsi `sortable => <boolean>|<string>`. 

```php
Suitable::source($users)
    ->columns([
        'id',
        ['header' => 'Nama', 'field' => 'name', 'sortable' => true],
        ['header' => 'Surel', 'field' => 'email', 'sortable' => 'email_address'],
    ])
    ->render()
```

Kode di atas akan menghasilkan tabel dengan header kolom berubah menjadi link yang bisa diklik untuk mendukung proses sorting data.

![image-20190627061546888](../assets/uploads/image-20190627061546888.png)

Mengklik salah satu kolom akan menghasilkan URL seperti di bawah ini:

```html
http://localhost/users?sort=name&direction=desc
```

Query string `sort` berisi nama kolom sedangkan `direction` menunjukkan metode sorting apakah `asc` atau `desc`. Kedua query string ini selanjutnya bisa digunakan di Controller untuk melakukan sorting data:

```php
class UserController 
{
    public function index()
    {
        $query = \App\User::query();
        $sort = request()->get('sort');               
        $direction = request()->get('direction');               
        
        if ($sort) {
            $query->orderBy($sort, $direction);
        }
        
        $users = $query->get();
        
        // more action here...
    }
}
```

> Suitable menyediakan Trait [AutoSort](#auto-sort) yang bisa dipasang di Model. Setelah terpasang, Model bisa memanggil scope `autoSort()` dan secara otomatis akan menangani proses sorting data berdasar query string.

## Table View 

TableView adalah sebuah `class` yang fungsinya khusus untuk menampilkan tabel. TableView memiliki fungsi yang sama dengan HTML Builder, dengan beberapa fitur tambahan:

1. Berbasis **class** sehingga reusable.
2. Mendukung sistem **plugin** untuk kemudahan memodifikasi setiap elemen tabel: header, kolom, dan footer. 
3. Otomatis bisa ekspor ke PDF, spreadsheet, dan CSV.



### Penggunaan

Berbeda dengan Suitable HTML Builder yang bisa dipanggil dimana saja, TableView direkomendasikan untuk dipanggil hanya dari Controller atau routes, karena sejatinya TableView adalah sebuah class [Responsable](https://laravel-news.com/laravel-5-5-responsable) yang bisa langsung mengembalikan response terhadap suatu request.  

Secara umum, ada tiga langkah yang diperlukan untuk menerapkan TableView:

1. Membuat class Table View
2. Memodifikasi response dari Controller
3. Menampilkan tabel di View

##### 1. Membuat Class Table View

###### app/Table/UserTableView.php

```php
use Laravolt\Suitable\TableView;

class UserTableView extends TableView
{
    protected function columns()
    {
        return ['id', 'title'];
    }
}
```

Cukup sederhana, method `columns()` sangat mirip dengan yang dimiliki oleh Suitable HTML Builder.

##### 2. Memodifikasi Response Dari Controller

Selanjutnya, proses di controller perlu sedikit diubah.

###### UserController.php

```php
// Before
public function index()
{
    $users = \App\User::paginate();

    return view('users.index', compact('users'));
}

// After
public function index()
{
    $users = \App\User::paginate();

    return (\App\Table\UserTableView::make($users))->view('users.index');
}

```

Ada beberapa hal yang patut diperhatikan dari potongan kode di atas:

1. Fungsi `view()` bawaan Laravel diganti dengan fungsi `view()` dari TableView, dengan parameter fungsi yang sama.
2. Dengan memanggil fungsi `view()` milik TableView, sebuah variable `$table` yang merupakan *instance* dari `UserTableView` secara otomatis akan di-passing ke view.

##### 3. Menampilkan Tabel Di View

###### resources/views/users/index.blade.php

```php
{!! $table !!}
```

## Column

Selain menggunakan format `array` seperti pada contoh-contoh di atas, pendefinisian kolom juga bisa dilakukan menggunakan *predefined* `Column` yang telah tersedia.

```php
use Laravolt\Suitable\Columns\Date;
use Laravolt\Suitable\Columns\DateTime;
use Laravolt\Suitable\Columns\Numbering;
use Laravolt\Suitable\Columns\Text;
use Laravolt\Suitable\TableView;

class UserTable extends TableView
{
    protected function columns()
    {
        return [
            Numbering::make('No'),
            Text::make('name'),
            Date::make('created_at', 'Member Since'),
            DateTime::make('updated_at', 'Last Login'),
        ];
    }
}
```

![image-20190702065721094](../assets/uploads/image-20190702065721094.png)

### Predefined Columns

##### Avatar

```php
use Laravolt\Suitable\Columns\Avatar;

Avatar::make('name', 'Avatar')
```

![image-20190702073146548](../assets/uploads/image-20190702073146548.png)

##### Boolean

```php
use Laravolt\Suitable\Columns\Boolean;

Boolean::make('status')
```

![image-20190702073123606](../assets/uploads/image-20190702073123606.png)

##### Date

`Date` digunakan untuk menampilkan tanggal dalam format yang manusiawi.

```php
use Laravolt\Suitable\Columns\Date;

Date::make('created_at', 'Member Since');
```

![image-20190702073238804](../assets/uploads/image-20190702073238804.png)

##### DateTime

`DateTime` digunakan untuk menampilkan tanggal dan jam dalam format yang manusiawi.

```php
use Laravolt\Suitable\Columns\DateTime;

DateTime::make('updated_at', 'Last Login');
```

![image-20190702073257435](../assets/uploads/image-20190702073257435.png)

##### Id

Menampilkan `primary key` secara otomatis. Dibelakang layar, class ini akan memanggil `$model->getKey()` dari setiap data yang ditampilkan.

```php
use Laravolt\Suitable\Columns\Id;

Id::make();
```



![image-20190702073338349](../assets/uploads/image-20190702073338349.png)

##### Numbering

Menampilkan `index` baris secara otomatis, dimulai dari angka 1.

```php
use Laravolt\Suitable\Columns\Numbering;

Numbering::make('No');
```

![image-20190702073548176](../assets/uploads/image-20190702073548176.png)

##### Raw

Memanggil *Closure* untuk menampilkan isi kolom. Kamu bebas melakukan apapun di dalam Closure tersebut, selama hasil akhirnya adalah `string`.

```php
use Laravolt\Suitable\Columns\Raw;

Raw::make(function ($item) {
    return $item->roles->implode('name', ' & ');
}, 'Roles');
```

![image-20190702074146098](../assets/uploads/image-20190702074146098.png)

##### Restful Button

`RestfulButton` akan menampilkan 3 buah tombol yang biasa dipakai untuk melakukan operasi CRUD, yaitu view, edit, dan delete.

```php
use Laravolt\Suitable\Columns\RestfulButton;

RestfulButton::make('users');
```

![image-20190702074253502](../assets/uploads/image-20190702074253502.png)

Beberapa method tambahan yang tersedia:

| Method   | Deskripsi                            |
| -------- | ------------------------------------ |
| `only`   | Aksi apa saja yang ingin ditampilkan |
| `except` | Aksi apa saja yang ingin dihilangkan |

```php
RestfulButton::make('users')->only("view", "edit");

RestfulButton::make('users')->excep("delete");
```



##### Text

`Text` akan menampilkan teks sama persis dengan yang tersimpan di database.

```php
use Laravolt\Suitable\Columns\Text;

View::text('name')
View::text('created_at')
```

![image-20190702075515080](../assets/uploads/image-20190702075515080.png)

##### View

Jika konten kolom cukup kompleks, maka bisa menggunakan `View` untuk memindahkannya ke *dedicated file*.

```php
use Laravolt\Suitable\Columns\View;

View::make('users.address', 'Address')
```

###### resources/views/users/address.blade.php

```php
<dl>
    <dt>Address</dt>
    <dd>{{ $data->address }}, {{ $data->city->name }}, {{ $data->province->name }}</dd>
    <dt>Postal Code</dt>
    <dt>{{ $data->postal_code }}</dt>
</dl>
```

![image-20190702075131814](../assets/uploads/image-20190702075131814.png)

### Available Methods

Untuk setiap *predefined* `Column` di atas, ada beberapa method yang telah tersedia:

| Method                                   | Deskripsi                                                    |
| ---------------------------------------- | ------------------------------------------------------------ |
| `setHeaderAttributes(array $attributes)` | Untuk menambahkan atribut di tag `<th>` dari kolom yang bersangkutan. <br /> |
| `setCellAttributes(array $attributes)`   | Untuk menambahkan atribut di tag `<td>` dari setiap cell yang akan di-generate. |
| `sortable($param)`                       | `$param` dapat berisi Boolean (true false) atau `string` nama kolom yang akan dijadikan parameter ketika melakukan sorting. |
| `searchable($param)`                     | `$param` dapat berisi Boolean (true false) atau `string` nama kolom yang akan dijadikan parameter ketika melakukan filtering per kolom. |



## Auto Sort

Untuk melakukan sorting secara otomatis di level Query (Eloquent), telah tersedia trait `AutoSort` yang bisa dipasangkan di Model terkait.

###### User.php

```php
use Laravolt\Suitable\AutoSort;

class User extends \Illuminate\Database\Eloquent\Model
{    
    use AutoSort;
}
```

###### UserController.php

```php
public function index()
{
    $users = User::autoSort()->paginate();
}
```

Scope `autoSort` akan otomatis membaca query string dari URL dan mengaplikasikannya menjadi database query di Model yang bersangkutan. Penamaan query string ditentukan oleh config: 

- `suitable.query_string.sort_by` (default to **“sort”**)

- `suitable.query_string.sort_direction` (default to **“direction”**)

###### Contoh URL

```html
http://localhost/users?sort=name&direction=desc
```



## Auto Filter

Untuk melakukan filtering secara otomatis di level Query (Eloquent), telah tersedia trait `AutoFilter` yang bisa dipasangkan di Model terkait.

###### User.php

```php
use Laravolt\Suitable\AutoFilter;

class User extends \Illuminate\Database\Eloquent\Model
{    
    use AutoFilter;
}
```

###### UserController.php

```php
public function index()
{
    // http://localhost/users?filter[name]=Jon&filter[email]=Dodo
    $users = User::autoFilter()->paginate();
}
```

By default, scope `autoFilter` akan membaca query string `filter` dari URL. Jika nama query string yang diberikan berbeda, silakan dicantumkan secara eksplisit sebagai parameter:

```php
public function index()
{
    // http://localhost/users?criteria[name]=Jon&criteria[email]=Dodo
    $users = User::autoFilter('criteria')->paginate();
}
```



## Export Ke PDF & Spreadsheet

