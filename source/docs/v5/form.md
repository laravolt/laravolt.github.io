---
title: Form
description: Helper untuk membuat tag form sesuai style Semantic UI
extends: _layouts.documentation
section: content
---

# Form

## Intro

Laravolt Form adalah helper untuk membuat form sesuai dengan style [Fomantic UI](https://fomantic-ui.com).

Tanpa Laravolt Form, tipikal kode yang dibutuhkan untuk membuat sebuah form dengan Laravel, lengkap dengan penanganan `Old Input` dan `Error`, biasanya seperti ini:

``` html
<form class="ui form">
  <div class="field {{ $errors->has('name') ? 'error' : '' }}">
    <label>Your Fullname</label>
    <input type="text" name="name" value="{{ old('name') }}">
  </div>
</form>
```

Dengan Laravolt Form, kode di atas bisa disederhanakan menjadi:

```php
{!! form()->open() !!}
{!! form()->text('name')->label('Your Fullname') !!}
{!! form()->close() !!}
```

Anda bisa fokus pada fungsionalitas form. Urusan struktur (HTML), tampilan (CSS), dan behaviour (JS) sudah ditangani oleh Laravolt.

## Fitur

Laravolt Form secara otomatis sudah menangani hal-hal berikut ini:

- Styling
- Error state
- Preserve old input, jadi isian tidak hilang ketika terjadi error saat form disubmit
- Model binding, otomatis mengisi form dari Eloquent model

## Cara Pemakaian

### Gambaran Umum

Laravolt Form bisa dipanggil dengan dua cara:

- Melalui Facade **Form**, misalnya `Form::open()`.
- Melalu helper **form()**, misalnya `form()->open()`.

Pemanggilan melalui fungsi helper `form()` lebih direkomendasikan karena mendukung *auto completion*.

Di bawah ini adalah gambaran umum untuk membuat sebuah form:

```php
// Membuka form
form()->open()->route('post.store');

// Field lainnya disini...

// Tombol submit
form()->submit('Save');

// Menutup form
form()->close();
```



### Membuka Form
``` php
form()->open('search'); // action="search"
form()->open()->get();
form()->open()->post();
form()->open()->put();
form()->open()->patch();
form()->open()->delete();
form()->open(); // default to method="GET"
form()->open()->action('search');
form()->open()->url('search'); // alias for action()
form()->open()->route('route.name');
form()->open()->post()->action(route('comment.store'));
form()->open()->post()->multipart(); // Wajib ada jika form digunakan untuk upload file
```

### Membuka Form (*Shortcut*)
``` php
form()->open('search'); // action="search" method=POST
form()->get('search'); // action="search" method=GET
form()->post('search'); // action="search" method=POST
form()->put('search'); // action="search" method=POST _method=PUT
form()->patch('search'); // action="search" method=POST _method=PATCH
form()->delete('search'); // action="search" method=POST _method=DELETE
```

### CSRF Token
[CSRF Token](https://laravel.com/docs/5.8/csrf) yang merupakan salah satu metode pengamanan form di Laravel sudah ditangani secara otomatis. Setiap kali form dibuat maka akan dibuatkan juga CSRF Token. Hal ini berlaku untuk semua jenis form kecuali untuk method `GET`.

Jika ingin memaksa Laravolt Form untuk menghilangkan CSRF Token, maka method `withoutToken()` bisa dipanggil ketika membuka form.

``` php
form()->post('search')->withoutToken();
```

### Basic Input

#### Checkbox

``` php
form()->checkbox($name, $value, $checked)->label('Remember Me');
```

#### Checkbox Group
``` php
$values = ['apple' => 'Apple', 'banana' => 'Banana'];
$checkedValue = 'banana';
form()->checkboxGroup($name, $values, $checkedValue)->label('Select Fruit');
```

#### Coordinate

```php
form()->coordinate('lokasi');
```



Menampilkan peta yang bisa dipilih dengan *drag & drop* untuk mendapatkan koordinat *latitude* dan *longitude*, menggunakan API Google Maps.

#### Email

``` php
form()->email($name, $value)->label('Email Address');
```

#### Hidden
``` php
form()->hidden($name, $value);
```


#### Input Wrapper

``` php
form()->input($name, $defaultvalue, $type = 'text');
form()->input($name, $defaultvalue)->appendIcon('search');
form()->input($name, $defaultvalue)->prependIcon('users');
form()->input($name, $defaultvalue)->appendLabel($label);
form()->input($name, $defaultvalue)->prependLabel($label);
form()->input($name, $defaultvalue)->type("password");
```
Reference: http://semantic-ui.com/elements/input.html


#### Number
``` php
form()->number($name, $integerValue)->label('Total');

// method tambahan khusus untuk number
form()
  ->number("umur", 17)
  ->min(7) // membatasi batas bawah angka yang bisa diinput
  ->max(35) // membatasi batas atas angka yang bisa diinput
  ->step(1);
```

#### Password
``` php
form()->password($name)->label('Password');
```

#### Text

``` php
form()->text($name, $value)->label('Username');
```

#### Textarea
``` php
form()->textarea($name, $value)->label('Note');
```

#### Time
``` php
form()->time($name, $value)->label('Start Time');
```


#### Radio
``` php
$checked = true;
form()->radio($name, $value, $checked)->label('Item Label');
```

#### Radio Group
``` php
$values = ['apple' => 'Apple', 'banana' => 'Banana'];
$checkedValue = 'banana';
form()->radioGroup($name, $values, $checkedValue)->label('Select Fruit');
```

#### Rupiah

```php
form()->rupiah('harga', $defaultValue);
```

Menampilkan inputan angka dengan format ribuan secara otomatis, memanfaatkan http://autonumeric.org/.

### Date & Time

#### Date

``` php
form()->date($name, $value)->label('Birthday');
```
#### Datepicker

Tanggal saja.

``` php
form()->datepicker($name, $value, $format);

// $format bisa diisi sesuai format yang disebutkan di https://www.php.net/manual/en/function.date.php

// To convert localized format to standard (SQL) datetime format, you can use Jenssegers\Date\Date library (already included):
// Jenssegers\Date\Date::createFromFormat('d F Y', '12 februari 2000')->startOfDay()->toDateTimeString();
// Jenssegers\Date\Date::createFromFormat('d F Y', '12 februari 2000')->startOfDay()->toDateString();
```

#### Datepicker with time

Tanggal dan waktu.

```php
form()->datepicker()->withTime();
```

#### Timepicker

Hanya dropdown waktu saja, tanpa tanggal.

``` php
form()->timepicker($name, $value);
```

#### Select Date & Select Date Time

``` php
form()->selectDate('myDate', $startYear, $endYear)->label('Birth Date');
form()->selectDateTime('myDate', $startYear, $endYear, $intervalInMinute)->label('Schedule');
```

Tanggal dan waktu yang dipilih melalui `selectDate` and `selectDateTime` akan dikirim dengan nama `_myDate` dan dalam format array:

```php
// $_POST
[
  '_myDate' => ['date'=>4, 'month'=>5, 'year'=>2016]
]
```

Untuk melakukan konversi secara otomatis menjadi format tanggal yang dikenali database, yaitu `2016-5-4`, maka Laravolt Form telah menyediakan dua buah `middleware`, yaitu `SelectDateMiddleware` dan `SelectDateTimeMiddleware`. Cara pemakaiannya cukup mudah.

##### 1. Daftarkan Middleware

###### app/Http/Kernel.php

```php
protected $routeMiddleware = [
    'selectdate' => \Laravolt\Laravolt Form\Middleware\SelectDateMiddleware::class,
    'selectdatetime' => \Laravolt\Laravolt Form\Middleware\SelectDateTimeMiddleware::class
];
```

##### 2. Panggil Middleware

###### routes/web.php

```php
Route::post('myForm', ['middleware' => ['web', 'selectdate:myDate'], function () {
	dd($_POST['myDate']); // 2016-5-4
}]);
```

### Select/Dropdown
#### Select (Dropdown) Single Value
``` php
$options = [
    'id' => 'Indonesia',
    'ms' => 'Malaysia',
];
form()->select($name, $options)->label('Choose Country');
form()->select($name, $options, $selected)->label('Choose Country');
form()->select($name, $options)->placeholder('--Select--');
form()->select($name, $options)->appendOption($key, $label);
form()->select($name, $options)->prependOption($key, $label);
```

#### Select Multiple (Tagging)

```php
$options = [
    'id' => 'Indonesia',
    'ms' => 'Malaysia',
];
form()->select($name, $options, $selected)->multiple()->label('Select Multiple');
```


#### Select Range
``` php
form()->selectRange($name, $begin, $end)->label('Number of child');
```

#### Select Month
``` php
form()->selectMonth($name, $format = '%B')->label('Month');
```

#### Dropdown DB

```php
$query = 'SELECT id, name from provinsi order by name';
form()->dropdownDB('provinsi', $query, $keyColumn = 'id', $valueColumn = 'name');
```

Dengan kode diatas, maka opsi dropdown akan diisi secara otomatis menggunakan hasil raw query ke database. Satu lagi, Anda bisa membuat *chained dropdown* secara mudah dengan memanfaatkan method `dependency()`:

```php
$query = 'SELECT id, name from kabupaten where provinsi_id = %s'
form()->dropdownDB('kabupaten', $query, 'id', 'name')->dependency('provinsi');
```

Setiap kali dropdown provinsi berubah nilainya, maka dropdown kabupaten juga akan di-update opsinya sesuai provinsi terpilih. 

> *Under the hood*, **ID** dari provinsi akan dikirim ke server via AJAX, dan query untuk dropdown kabupaten akan dijalankan dengan mengganti placeholder **%s** dengan **ID** provinsi tersebut.

**Prepopulate Child Dropdown**

_By default_, hanya _parent dropdown_ yang akan melakukan query ketika halaman di-_load_ pertama kali. Query untuk _child dropdown_ baru dijalankan ketika value _parent_-nya berubah. Namun ada kalanya opsi dari _child dropdown_ juga perlu di-_generate_ di awal, misalnya ketika membuat halaman edit.

Sebagai contoh, jika sebelumnya pengguna sudah memilih provinsi dan kabupaten, maka kita bisa menampilkan _selected value_ di awal dengan cara seperti berikut:

```php
$selectedProvinsi = 1;
$selectedKabupaten = 56;

$queryProvinsi = 'SELECT id, name from provinsi order by name';
form()->dropdownDB('provinsi', $query, $keyColumn = 'id', $valueColumn = 'name')->value(selectedProvinsi);

$queryKabupaten = 'SELECT id, name from kabupaten where provinsi_id = %s'
form()->dropdownDB('kabupaten', $query, 'id', 'name')->value($selectedKabupaten)->dependency('provinsi', selectedProvinsi);
```
Bisa dilihat, kita hanya perlu mengeset value masing-masing dropdown dengan `->value($selectedValue)` dan menambahkan parameter kedua di _method_ `->dependency('provinsi', $selectedProvinsi)`. Dengan cara ini, opsi kedua dropdown akan di-_populate_ di awal dan _selected value_-nya bisa diset seperti biasa.

### File

#### Standar HTML  File Input

``` php
form()->file($name);
```

#### Uploader

Wrapper untuk library [fileuploader](https://innostudio.de/fileuploader/documentation/).

```php
{!! 
  form()
  ->uploader('files')
  ->limit($maxUploadedFile) //optional, defaul to 1 (single file upload)
  ->extensions(['jpg', 'png']) // optional, default to null (all files allowed)
  ->fileMaxSize($sizeInMB)  //optional, default to 1000 MB 
  ->mediaUrl($customURL) //optional, default to route("media::store"), handled by Laravolt
!!}
```


### Rich Text Editor (WYSIWYG)

#### Redactor

``` php
form()->redactor($name, $value);

//Additional Methods
form()->redactor($name, $value)->mediaUrl($url); //custom URL to handle file upload, default to route("media::store")
```



### Action

#### Button

``` php
form()->button($value);
```
#### Link

``` php
form()->link($label, $url);
```

#### Submit
``` php
form()->submit($value);
```



### Model Binding

##### Version 1
``` php
{!! form()->bind($model) !!}
```

##### Version 2
``` php
// as parameter for method open()
{!! form()->open($route, $model) !!}

// or chaining it
{!! form()->bind($model)->get($route) !!}
```

##### Warning
```php 
// This is OK in version 1, but will produce error in version 2
{!! form()->bind($model) !!}
```


### Macro
Macro digunakan untuk mendaftarkan *custom field* agar bisa dipanggil dengan lebih mudah.

```php
form()->macro('trix', function ($id, $name, $value = null) {
    return sprintf(
        "%s %s", 
        form()->hidden($name, $defaultValue)->id($id), 
        "<trix-editor input='{$id}'></trix-editor>"
    );
});
```

Setelah didaftarkan, macro bisa dipanggil secara langsung oleh Laravolt Form:
```php
form()->trix('contentId', 'content', '<b>some content</b>');
```

### Action

`Action` digunakan untuk mengelompokkan tombol-tombol aksi (Simpan, Batal, Reset, dan lainnya) dalam sebuah form. Menggabungkan `Action` dan `Macro` bisa menyederhanakan pembuatan form, terutama jika banyak form memiliki tombol yang seragam.

##### Manual Action

```php
form()->action(form()->submit('Save'), form()->button('cancel'));
```

##### Shortcut Dengan Macro 1

```php

// Assumed you already define some macros:
form()->macro('submit', function(){
    return form()->submit('Submit');
});

form()->macro('cancel', function(){
    return form()->button('Cancel');
});

// Then you can just call macro name as string
form()->action('submit', 'cancel');
```

##### Shortcut Dengan Macro 2

``` php
// Even further, you can define macro thats just wrap several buttons:
Laravolt Form()->macro('default', function(){
    return new \Laravolt\Laravolt Form\Elements\Wrapper(
      form()->button('Cancel'), 
      form()->submit('Submit')
    );
});

// And then make the call simplier:
form()->action('default');
```

### Layout

Secara default, Laravolt Form akan menghasilkan form dengan susuan vertikal dari atas ke bawah.

![image-20190718061239509](../assets/uploads/image-20190718061239509.png)

Jika ingin menerapkan susuan layout menyamping 2 kolom (label di kiri, input di kanan), cukup memanggil method `horizontal()` ketika membuat form.

```php
form()->open()->horizontal()
```

Kode di atas akan menghasilkan susunan form seperti ini:

![image-20190718061301632](../assets/uploads/image-20190718061301632.png)

### Method Lainnya

Untuk setiap jenis form, method dibawah ini bisa dipanggil sesuai kebutuhan:

* id($string)
* addClass($string)
* removeClass($string)
* attribute($name, $value)
* clear($attribute)
* required()
* readonly()
* data($name, $value)
* enable($flag = true)
* disable($flag = true)
* hint($text) (Since 1.10.0)
* hint($text, $class = "hint") (Since 1.10.2)

### Override Hint Class Globally (Since 1.10.2)
``` php
// Tambahkan kode berikut ketika booting, misalnya di AppServiceProvider
Laravolt\Laravolt Form\Elements\Hint::$defaultClass = 'custom-class';
```

##### Contoh
``` php
form()->text($name, $value)->label('Username')->id('username')->addClass('foo');
form()->text($name, $value)->label('Username')->data('url', 'http://id-laravel.com');
form()->password($name, $value)->label('Password')->hint('Minimum 6 characters');
form()->password($name, $value)->label('Password')->hint('Minimum 6 characters', 'my-custom-css-class');
```


## Credits
Laravolt Form terinspirasi dari [AdamWathan\Form](https://github.com/adamwathan/form).
