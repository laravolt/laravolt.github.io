---
title: Auto CRUD
description: No Code CRUD berbasis config file
extends: _layouts.documentation
section: content
---

# AutoCRUD

## Overview

Create, Read, Update, Delete merupakan salah satu fitur yang paling sering dijumpai dalam pengembangan sistem informasi. Ciri-ciri dari fitur CRUD adalah:

1. Ada halaman berisi list of data, biasanya ditampilkan dalam bentuk datatable lengkap dengan searching, sorting, dan paginasi.
1. Ada tombol untuk menambah, mengedit, dan menghapus data.

Dengan AutoCRUD, fitur-fitur di atas tidak perlu dikoding sama sekali. Cukup **"definisikan"** field apa saja yang perlu ditampilkan dari sebuah Eloquent Model dan secara otomatis sebuah fitur CRUD yang lengkap sudah bisa diakses lewat aplikasi, tanpa koding.

AutoCRUD hanya membutuhkan dua hal berikut:

1. Eloquent Model lengkap dengan relationship-nya.
1. File konfigurasi untuk **"mendefinisikan"** field yang ditampilkan.



## Model

```php
class User extends Model
{
    public function country()
    {
        return $this->belongsTo("App\\Models\\Country");
    }
}
```



## Configuration

###### config/laravolt/auto-crud-resources/user.php

```php
return [
    'label' => 'User',
    'model' => \App\Models\User::class,
    'schema' => [
        [
            'name' => 'name',
            'type' => \Laravolt\Fields\Field::TEXT,
            'label' => 'Nama Lengkap',
        ],
        [
            'name' => 'email',
            'type' => \Laravolt\Fields\Field::EMAIL,
            'label' => 'Email',
        ],
        [
            'name' => 'password',
            'type' => \Laravolt\Fields\Field::PASSWORD,
            'label' => 'Password',
        ],
    ],
];
```

### `label`

Teks yang akan ditampilkan di menu.

### `model`

Kelas Eloquent Model yang akan dipanggil untuk setiap aksi CRUD yang dilakukan.

### `schema`

Mendefinisikan field-field apa saja yang perlu ditampilkan. Entri minimal yang wajib ada adalah `name`, `type`, dan `label`:

```php
'name' => 'fullname',
'type' => 'text',
'label' => 'Nama Lengkap',
```



Kita bisa merujuk ke interface `\Laravolt\Fields\Field` untuk melihat `type` yang tersedia:

```php
// Input Elements
\Laravolt\Fields\Field::BOOLEAN;
\Laravolt\Fields\Field::CHECKBOX;
\Laravolt\Fields\Field::CHECKBOX_GROUP;
\Laravolt\Fields\Field::COLOR;
\Laravolt\Fields\Field::DATE;
\Laravolt\Fields\Field::DATE_PICKER;
\Laravolt\Fields\Field::DATETIME_PICKER;
\Laravolt\Fields\Field::DROPDOWN;
\Laravolt\Fields\Field::DROPDOWN_COLOR;
\Laravolt\Fields\Field::DROPDOWN_DB;
\Laravolt\Fields\Field::EMAIL;
\Laravolt\Fields\Field::HIDDEN;
\Laravolt\Fields\Field::NUMBER;
\Laravolt\Fields\Field::MULTIROW;
\Laravolt\Fields\Field::PASSWORD;
\Laravolt\Fields\Field::RADIO_GROUP;
\Laravolt\Fields\Field::REDACTOR;
\Laravolt\Fields\Field::RUPIAH;
\Laravolt\Fields\Field::TEXT;
\Laravolt\Fields\Field::TEXTAREA;
\Laravolt\Fields\Field::TIME;
\Laravolt\Fields\Field::UPLOADER;

// Other Elements
\Laravolt\Fields\Field::ACTION;
\Laravolt\Fields\Field::BUTTON;
\Laravolt\Fields\Field::HTML;
\Laravolt\Fields\Field::SEGMENT;
\Laravolt\Fields\Field::SUBMIT;

// Relationship
\Laravolt\Fields\Field::BELONGS_TO;
```



### Visibility

Untuk setiap field, opsi berikut ini bisa digunakan untuk mengatur apakah field tersebut perlu ditampilkan atau tidak. *By default* semua bernilai **true**.

```php
'show_on_index' => false,
'show_on_detail' => true,    
'show_on_create' => true,
'show_on_edit' => true,    
```

### Sorting

Untuk mengatur apakah sebuah field bisa di-sort atau tidak, bisa menggunakan opsi `sortable`. Untuk field berjenis **Input Elements**, by default `sortable` akan bernilai `true`. Untuk men-disable *sorting*, kita tinggal mengeset dengan nilai `false`:

```php
'sortable' => false,
```

Untuk field yang berjenis **Relationship**, nilai default-nya adalah `false`. Untuk meng-enable sorting, kita perlu mengesetnya dengan nama kolom yang akan digunakan untuk sorting pada *related table*:

```php
// sort by kolom "name" pada tabel "countries" (atau apapun nama tabelnya, sesuai definisi di relationshipnya)
'type' => Laravolt\Fields\Field::BELONGS_TO,
'name' => 'country',
'sortable' => 'name',
'label' => 'Country',
```
By default field `Laravolt\Fields\Field::BELONGS_TO` akan menampilkan data dari model relasinya dalam format JSON. Untuk mengubahnya, tambahkan public method **display()** pada Model relasinya.

```php
class Country extends Model
{
    public function display()
    {
        //menampilkan data dari kolom nama
        return $this->name;
    }
}
```

Ketika menambahkan sorting pada field Relationship, kita juga perlu menambahkan trait `Laravolt\Suitable\AutoSort` pada model asalnya, yaitu`\App\Models\User`:

```php
use Laravolt\Suitable\AutoSort;

class User extends Model
{
    use AutoSort;
    
    public function country()
    {
        return $this->belongsTo("App\\Models\\Country");
    }
}
```

Trait `AutoSort` akan secara otomatis memodifikasi *query* agar bisa melakukan sorting pada related tabel dengan mekanisme join.

### Searching

Untuk mengatur apakah sebuah field bisa di-search atau tidak, bisa menggunakan opsi `searchable`. Untuk field berjenis **Input Elements**, by default `searchable` akan bernilai `true`. Jika ingin menghapus kolom dari daftar pencarian, kita tinggal mengesetnya dengan nilai `false`:

```php
'searchable' => false,
```

Untuk field yang berjenis **Relationship**, nilai default-nya adalah `false`. Untuk meng-enable pencarian pada related table, kita perlu mengesetnya dengan nama kolom yang sesuai:

```php
// pencarian juga akan dilakukan pada kolom countries.name
'type' => Laravolt\Fields\Field::BELONGS_TO,
'name' => 'country',
'searchable' => 'name',
'label' => 'Country',
```



## Field Types (Schema)

### Boolean

```php
[
    'type' => \Laravolt\Fields\Field::BOOLEAN,
    'name' => 'approved',
    'label' => 'Apakah Disetujui?',
],

```



### Checkbox

```php
[
    'type' => \Laravolt\Fields\Field::CHECKBOX,
    'name' => 'remember',
    'label' => 'Remember Me',
],
```



### Checkbox Group

```php
[
    'type' => \Laravolt\Fields\Field::CHECKBOX_GROUP,
    'name' => 'pendidikan',
    'label' => 'Pendidikan Terakhir',
    'options' => ['sd', 'smp', 'sma', 'S1'],
    'inline' => false, // false (default value) or true
],
```


### Color

```php
[
    'type' => \Laravolt\Fields\Field::COLOR,
    'name' => 'color',
    'label' => 'Color',
],
```


### Date

```php
[
    'type' => \Laravolt\Fields\Field::DATE,
    'name' => 'date',
    'label' => 'Date',
],
```


### Date Picker

```php
[
    'type' => \Laravolt\Fields\Field::DATE_PICKER,
    'name' => 'datepicker',
    'label' => 'Date Picker',
],
```


### Datetime Picker

```php
[
    'type' => \Laravolt\Fields\Field::DATETIME_PICKER,
    'name' => 'datetimepicker',
    'label' => 'Datetime Picker',
],
```


### Dropdown

```php
[
    'type' => \Laravolt\Fields\Field::DROPDOWN,
    'name' => 'dropdown',
    'label' => 'Dropdown',
    'options' => [1 => 'SD', 2 => 'SMP', 3 => 'SMA'],
],
```


### Dropdown Color

```php
[
    'type' => \Laravolt\Fields\Field::DROPDOWN_COLOR,
    'name' => 'dropdown_color',
    'label' => 'Dropdown Color',
],
```

### Dropdown DB

Dropdown dengan pilihan *option* yang didapat dari hasil query ke database.

```php
[
    'type' => \Laravolt\Fields\Field::DROPDOWN_DB,
    'name' => 'dropdown_db',
    'label' => 'Dropdown DB',
    'query' => 'select id, name from users limit 10'
],
```


### Email

```php
[
    'type' => \Laravolt\Fields\Field::EMAIL,
    'name' => 'email',
    'label' => 'Email',
],
```


### Hidden

```php
[
    'type' => \Laravolt\Fields\Field::HIDDEN,
    'name' => 'user_id',
],
```


### Number

```php
[
    'type' => \Laravolt\Fields\Field::NUMBER,
    'name' => 'number',
    'label' => 'Number',
],
```

### Multirow

//TODO

```php
```


### Password

```php
[
    'type' => \Laravolt\Fields\Field::PASSWORD,
    'name' => 'password',
    'label' => 'Password',
],
```


### Radio Group

```php
[
    'type' => \Laravolt\Fields\Field::RADIO_GROUP,
    'name' => 'radio_group',
    'label' => 'Radio Group',
    'options' => [1 => 'SD', 2 => 'SMP', 3 => 'SMA'],
    'inline' => false, // false (default value) or true
],
```


### Redactor

```php
[
    'type' => \Laravolt\Fields\Field::REDACTOR,
    'name' => 'article',
    'label' => 'Article',
],
```


### Rupiah

```php
[
    'type' => \Laravolt\Fields\Field::RUPIAH,
    'name' => 'rupiah',
    'label' => 'Rupiah',
],
```


### Text

```php
[
    'type' => \Laravolt\Fields\Field::TEXT,
    'name' => 'text',
    'label' => 'Text',
],
```


### Textarea

```php
[
    'type' => \Laravolt\Fields\Field::TEXTAREA,
    'name' => 'textarea',
    'label' => 'Textarea',
],
```


### Time

```php
[
    'type' => \Laravolt\Fields\Field::TIME,
    'name' => 'time',
    'label' => 'Time (Standard Browser)',
],
```


### Uploader

```php
[
    'name' => 'profile_picture',
    'type' => \Laravolt\Fields\Field::UPLOADER,
    'label' => 'Profile Picture',
    'limit' => 1, // jumlah maksimal file yang bisa diupload
    'extensions' => ['jpg', 'png'],
    'fileMaxSize' => 5, // dalam MB    
],
```

