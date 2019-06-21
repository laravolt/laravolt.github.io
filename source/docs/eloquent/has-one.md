# One To One

Relasi one-to-one merupakan jenis relasi yang paling sederhana. Untuk setiap row di tabel A akan berhubungan dengan **maksimal satu** row di tabel B. Relasi ini ada dua variasi:



## 1 to 0..1

Adalah jenis relasi dimana row di tabel A bisa memiliki satu row di tabel B, bisa juga tidak. Contohnya, tabel `user` dan `profile`. Ketika pertama kali mendaftar di sebuah website, kita tidak wajib mengisi profil sehingga setelah registrasi, penambahan hanya terjadi di tabel `user`. Tabel `profile` baru diisi ketika pengguna melengkapi profilnya.

Contoh implementasi di Laravel:

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function profile()
    {
        return $this->hasOne('App\Profile')->withDefault();
    }
}
```

`withDefault()` diperlukan, untuk menghindari adanya error `trying to get property of non object` ketika memanggil `$user->profile->address` pada saat tabel `profile` masih belum ada isinya.



## 1 to 1

Adalah jenis relasi dimana satu row di tabel A memiliki tepat satu row di tabel B. Contohnya, tabel `customer` dan `payment`. Beberap website zaman now mewajibkan untuk mengisi informasi kartu kredit ketika melakukan registrasi. Dalam kasus ini, tabel `customer` dan `payment` akan selalu memiliki jumlah data yang sama.

Contoh implementasi di Laravel:

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function payment()
    {
        return $this->hasOne('App\Payment');
    }
}
```

## 

# Has Many

# Many To Many