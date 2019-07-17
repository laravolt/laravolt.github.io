---
title: SemanticForm
description: Helper untuk membuat tag form sesuai style Semantic UI
extends: _layouts.documentation
section: content
---

# SemanticForm

## Intro

SemanticForm adalah helper untuk membuat form sesuai dengan style [Fomantic UI](https://fomantic-ui.com).

Tanpa SemanticForm, tipikal kode yang dibutuhkan untuk membuat sebuah form dengan Laravel, lengkap dengan penanganan `Old Input` dan `Error`, biasanya seperti ini:

``` html
<form class="ui form">
  <div class="field {{ $errors->has('name') ? 'error' : '' }}">
    <label>Your Fullname</label>
    <input type="text" name="name" value="{{ old('name') }}">
  </div>
</form>
```

Dengan SemanticForm, kode di atas bisa disederhanakan menjadi:

```php
{!! form()->open() !!}
{!! form()->text('name')->label('Your Fullname') !!}
{!! form()->close() !!}
```

## Fitur

SemanticForm secara otomatis akan menangani hal-hal berikut ini:

- Styling
- Error state
- Preserve old input, jadi isian tidak hilang ketika terjadi error saat form disubmit
- Model binding, otomatis mengisi form dari Eloquent model

## Instalasi

``` bash
composer require laravolt/semantic-form
```

## Cara Pemakaian

### Gambaran Umum

SemanticForm bisa dipanggil dengan dua cara:

- Melalui Facade `Form`, misalnya `form()->open()`.
- Melalu helper `form()`, misalnya `form()->open()`.

Pemanggilan melalui fungsi helper `form()` lebih direkomendasikan karena mendukung *auto completion*.

Di bawah ini adalah gambaran umum untuk membuat sebuah form:

```php
// Membuka form
form()->open()->route('post.store');

// Field lainnya disini...

// Tombol submit
form()->submi('Save');

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

Jika ingin memaksa SemanticForm untuk menghilangkan CSRF Token, maka method `withoutToken()` bisa dipanggil ketika membuka form.

``` php
form()->post('search')->withoutToken();
```

### Text
``` php
form()->text($name, $value)->label('Username');
```

### Number
``` php
form()->number($name, $integerValue)->label('Total');
```

### Date
``` php
form()->date($name, $value)->label('Birthday');
```

### Time
``` php
form()->time($name, $value)->label('Start Time');
```

### Password
``` php
form()->password($name)->label('Password');
```

### Email
``` php
form()->email($name, $value)->label('Email Address');
```
### Textarea
``` php
form()->textarea($name, $value)->label('Note');
```

### Select Box (Dropdown)
``` php
form()->select($name, $options)->label('Choose Country');
form()->select($name, $options, $selected)->label('Choose Country');
form()->select($name, $options)->placeholder('--Select--');
form()->select($name, $options)->appendOption($key, $label);
form()->select($name, $options)->prependOption($key, $label);
```

### Select Date & Select Date Time
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

Untuk melakukan konversi secara otomatis menjadi format tanggal yang dikenali database, yaitu `2016-5-4`, maka SemanticForm telah menyediakan dua buah `middleware`, yaitu `SelectDateMiddleware` dan `SelectDateTimeMiddleware`. Cara pemakaiannya cukup mudah.

##### 1. Daftarkan Middleware

###### app/Http/Kernel.php

```php
protected $routeMiddleware = [
    'selectdate' => \Laravolt\SemanticForm\Middleware\SelectDateMiddleware::class,
    'selectdatetime' => \Laravolt\SemanticForm\Middleware\SelectDateTimeMiddleware::class
];
```

##### 2. Panggil Middleware

###### routes/web.php

```php
Route::post('myForm', ['middleware' => ['web', 'selectdate:myDate'], function () {
	dd($_POST['myDate']); // 2016-5-4
}]);
```

### Select Range
``` php
form()->selectRange($name, $begin, $end)->label('Number of child');
```

### Select Month
``` php
form()->selectMonth($name, $format = '%B')->label('Month');
```

### Radio
``` php
$checked = true;
form()->radio($name, $value, $checked)->label('Item Label');
```

### Radio Group
``` php
$values = ['apple' => 'Apple', 'banana' => 'Banana'];
$checkedValue = 'banana';
form()->radioGroup($name, $values, $checkedValue)->label('Select Fruit');
```

### Checkbox
``` php
form()->checkbox($name, $value, $checked)->label('Remember Me');
```

### Checkbox Group
``` php
$values = ['apple' => 'Apple', 'banana' => 'Banana'];
$checkedValue = 'banana';
form()->checkboxGroup($name, $values, $checkedValue)->label('Select Fruit');
```

### File
``` php
form()->file($name);
```
### Input Wrapper
``` php
form()->input($name, $defaultvalue);
form()->input($name, $defaultvalue)->appendIcon('search');
form()->input($name, $defaultvalue)->prependIcon('users');
form()->input($name, $defaultvalue)->appendLabel($label);
form()->input($name, $defaultvalue)->prependLabel($label);
form()->input($name, $defaultvalue)->type("password");
```
Reference: http://semantic-ui.com/elements/input.html


### Datepicker
``` php
form()->datepicker($name, $value, $format);

// Valid $format are:
// DD -> two digit date
// MM -> two digit month number
// MMMM -> month name (localized)
// YY -> two digit year
// YYYY -> full year

// To convert localized format to standard (SQL) datetime format, you can use Jenssegers\Date\Date library (already included):
// Jenssegers\Date\Date::createFromFormat('d F Y', '12 februari 2000')->startOfDay()->toDateTimeString();
// Jenssegers\Date\Date::createFromFormat('d F Y', '12 februari 2000')->startOfDay()->toDateString();
```

### Timepicker
``` php
form()->timepicker($name, $value);
```

### Hidden
``` php
form()->hidden($name, $value);
```

### Button
``` php
form()->button($value);
```

### Submit
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

Setelah didaftarkan, macro bisa dipanggil secara langsung oleh SemanticForm:
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
Semanticform()->macro('default', function(){
    return new \Laravolt\SemanticForm\Elements\Wrapper(
      form()->button('Cancel'), 
      form()->submit('Submit')
    );
});

// And then make the call simplier:
form()->action('default');
```

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
Laravolt\SemanticForm\Elements\Hint::$defaultClass = 'custom-class';
```

##### Contoh
``` php
form()->text($name, $value)->label('Username')->id('username')->addClass('foo');
form()->text($name, $value)->label('Username')->data('url', 'http://id-laravel.com');
form()->password($name, $value)->label('Password')->hint('Minimum 6 characters');
form()->password($name, $value)->label('Password')->hint('Minimum 6 characters', 'my-custom-css-class');
```


## Credits
SemanticForm terinspirasi dari [AdamWathan\Form](https://github.com/adamwathan/form).