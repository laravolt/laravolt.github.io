---
title: Auto CRUD
description: No Code CRUD berbasis config file
extends: _layouts.documentation
section: content
---

# AutoCRUD

## Konsep

Create, Read, Update, Delete merupakan salah satu fitur yang paling sering dijumpai dalam pengembangan sistem informasi. Ciri-ciri dari fitur CRUD adalah:

1. Ada 1 halaman berisi list of data, biasanya ditampilkan dalam bentuk datatable lengkap dengan searching, sorting, dan paginasi.
1. Ada tombol untuk menambah, mengedit, dan menghapus data
1. Bisa mengekspor data ke format Excel atau PDF.

Dengan AutoCRUD, fitur-fitur di atas tidak perlu dikoding sama sekali. Cukup definisikan field-field apa saja yang perlu ditampilkan dari sebuah Eloquent Model, dan simsalabim, sebuah fitur CRUD yang lengkap sudah bisa diakses lewat aplikasi.

AutoCRUD membutuhkan dua hal agar bisa berfungsi dengan baik:

1. Model yang sudah didefinisikan sebelumnya, lengkap dengan *relationship*-nya.
1. File konfigurasi untuk mengatur bagaimana field ditampilkan.

## Model

Fitur CRUD biasanya berlaku untuk sebuah tabel di database, dan untuk setiap tabel tersebut biasanya sudah dibuat juga Model-nya.

## Konfigurasi

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
'name' => '',
'type' => '',
'label' => '',
```



Kita bisa merujuk ke interface `Laravolt\Fields\Field` untuk melihat `type` yang tersedia:

```php
// Form Elements
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

Untuk mengatur apakah sebuah field bisa di-sort atau tidak, bisa menggunakan opsi `sortable`. By default `sortable` akan bernilai `true`. Untuk men-disable *sorting*, kita tinggal mengeset dengan nilai `false`:

```php
'sortable' => false,
```

Untuk field yang berjenis relationship, nilai default-nya adalah `false`. Untuk meng-enable sorting, kita perlu mengesetnya dengan nama kolom yang akan digunakan untuk sorting pada *related table*:

```php
// sort by country.name
'type' => Laravolt\Fields\Field::BELONGS_TO,
'name' => 'country',
'sortable' => 'name',
'label' => 'Country',
```



### Searching

Untuk mengatur apakah sebuah field bisa di-search atau tidak, bisa menggunakan opsi `searchable`. By default `searchable` akan bernilai `true`. Jika ingin menghapus kolom dari daftar pencarian, kita tinggal mengesetnya dengan nilai `false`:

```php
'searchable' => false,
```

Untuk field yang berjenis relationship, nilai default-nya adalah `false`. Untuk meng-enable pencarian pada related table, kita perlu mengesetnya dengan nama kolom yang sesuai:

```php
// pencarian juga akan dilakukan pada kolom country.name
'type' => Laravolt\Fields\Field::BELONGS_TO,
'name' => 'country',
'searchable' => 'name',
'label' => 'Country',
```



## Field Types (Schema)

Setiap jenis field bisa memiliki atribut tambahan yang spesifik sesuai dengan fungsinya. Mari kita bahas satu per satu.

### Boolean

### Checkbox

### Checkbox Group

### Color

### Date

### Date Picker

### Datetime Picker

### Dropdown

### Dropdown Color

### Dropdown DB

### Email

### Hidden

### Number

### Multirow

### Password

### Radio Group

### Redactor

### Rupiah

### Text

### Textarea

### Time

### Uploader
