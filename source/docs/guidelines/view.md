---
title: View
description: Dumb view is the best view in the world
extends: _layouts.documentation
section: content
---

# View

1. View tidak boleh mengandung *logic*. Pindahkan *logic* ke ***[helper](/docs/snippets/membuat-helper)*** atau ***Model***.
2. Jika view sudah terlalu kompleks, manfaatkan `@include` dan `@component` untuk memecahnya.
3. Manfaatkan ***Service Injection*** ketika:
   - View akan dipakai di beberapa tempat.
   - Ada bagian view yang kadang perlu ditampilkan kadang tidak, tergantung role atau kondisi lainnya.



### Memindahkan Logic Dari View ke Model Accessor

#### Contoh Kasus

Dalam sebuah CMS, tanggal artikel dibuat biasanya diambil dari kolom `created_at` yang disimpan dalam format Y-m-d H:i:s. Ketika akan ditampilkan, baik di halaman index atau di halaman show, maka perlu diubah ke dalam format yang lebih manusiawi, misal dari **2019-05-11 02:45:00** menjadi **11 April 2019 02:45**.

##### index.blade.php

```php+HTML
@foreach($artikel as $item)
	<div>
  	<h3>{{ $item->title }}</h3>  
    <small>{{ date('d F Y', strtotime($item->created_at)) }}</small>
	</div>
@endforeach
```

##### show.blade.php

```php+HTML
<h3>{{ $item->title }}</h3>  
<small>{{ date('d F Y', strtotime($item->created_at)) }}</small>
<div>
  {!! $item->content !!}
</div>
```

Solusi di atas berjalan dengan baik, hingga kemudian ada kebutuhan untuk mengganti format tanggal dari **11 April 2019 02:45** menjadi **1 April 2019** saja, tanpa perlu menampilkan jam. Kamu harus mengubah kode di semua view. Pada contoh di atas kebetulan hanya dua, tapi di proyek sesungguhnya bisa jadi ada belasan hingga puluhan file yang harus direfactor.

#### Solusi

Tambahkan accessor di model Artikel:

```php
class Artikel extends Model 
{
    public function getDateFormattedAttribute()
    {
     	return date('d F Y', strtotime($this->created_at)); 
    }
}
```

Bersihkan view:

##### index.blade.php

```php+HTML
@foreach($artikel as $item)
	<div>
  	<h3>{{ $item->title }}</h3>  
    <small>{{ $item->date_formatted }}</small>
	</div>
@endforeach
```

##### show.blade.php

```php+HTML
<h3>{{ $item->title }}</h3>  
<small>{{ $item->date_formatted }}</small>
<div>
  {!! $item->content !!}
</div>
```



Meskipun tidak ada aturan khusus terkait penamaan fungsi accessor, kami merekomendasikan menggunakan standard prefix `present_` (dari kata presenter) agar programmer bisa langsung paham dari mana suatu atribut itu berasal, apakah dari kolom atau dari accessor.

```php
$model->title // Jelas ini dari kolom title, mari cek DB
$model->excerpt // Cek DB, lho kok tidak ada kolom `excerpt`? Oo, ini accessor, mari buka file
  
$model->present_excerpt // Ok, ini pasti acccessor, mari buka file
```



#### Referensi

1. https://laravel.com/docs/5.8/eloquent-mutators#accessors-and-mutators