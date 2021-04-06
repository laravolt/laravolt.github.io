# Bagaimana Laravel Berinteraksi Dengan Database

Laravel menyediakan 2 mekanisme untuk melakukan interaksi dengan database, yaitu melalui Query Builder dan Eloquent (Model). Secara singkat, perbedaan diantara keduanya bisa dilihat di tabel berikut:

| Poin                | Query Builder                                                | Eloquent     |
| ------------------- | ------------------------------------------------------------ | ------------ |
| Pendekatan          | Query, fluent interface                                      | OOP          |
| Hasil               | array/stdClass                                               | Model        |
| Kapan digunakan     | Query yang kompleks <br />(reporting, statistik, dan lain-lain) | Operasi CRUD |
| Easy to learn       | Ya                                                           | Butuh waktu  |
| Easy to maintenance | Butuh waktu                                                  | Ya           |

Selanjutnya, mari kita bahas masing-masing cara secara lebih mendalam.

## Query Builder

Salah satu cara untuk berinteraksi dengan database di Laravel adalah menggunakan Query Builder. Sesuai namanya, Query Builder adalah sebuah **class yang menyediakan berbagai macam method** untuk melakukan query ke database. Query Builder membantu programmer menyusun (build) query SQL secara lebih manusiawi, dengan memanfaatkan mekanisme [**fluent interface**](https://en.wikipedia.org/wiki/Fluent_interface#PHP).

Jadi, anggap saja Query Builder itu seperti wrapper atau pembungkus, cara yang lebih modern, dari yang biasanya menulis query SQL dengan menggabungkan string dan variable berubah menjadi memanggil method dan parameter.

Karena programmer konon katanya lebih suka membaca kode dibanding penjelasan atau dokumentasi, mari kita perhatikan contoh-contoh di bawah ini.

### Cara Jadul

```php
$byName = $_POST['name'];
$bySex = $_POST['sex'];
$byBlood = $_POST['blood'];

$query = "SELECT * FROM pendonor";
$conditions = "";

if($byName !="") {
  $conditions .= "name='$byName' AND ";
}

if($bySex !="") {
  $conditions .= "sex='$bySex' AND ";
}

if($byBlood !="") {
  $conditions .= "blood_type='$byBlood' AND ";
}

if ($conditions) {
  $query = "$query WHERE $conditions";
}

// execute query
// mysqli_query($connection, $query);

// Hasil query (yang diharapkan):
// SELECT * FROM pendonor WHERE 1=1 AND name="fulan" AND sex="M" AND blood="AB"
```

Menyusun query dengan menggabungkan string dan variable secara dinamis sangat *error prone* (**berpotensi menimbulkan error jika tidak hati-hati**). Salah sedikit saja akan menghasilkan sintaks SQL yang salah. Sebagai contoh, kode di atas sejatinya akan menghasilkan query yang salah. 

Bisa kasih tahu apa salahnya? 

Bisa memperbaiki?

### Cara Modern

```php
$byName = $_POST['name'];
$bySex = $_POST['sex'];
$byBlood = $_POST['blood'];

$query = DB::table('pendonor');

if($byName !="") {
  $query->where('name', $byName);
}

if($bySex !="") {
  $query->where('sex', $bySex);
}

if($byBlood !="") {
  $query->where('blood_type', $byBlood);
}

// execute query
$query->get();
```

Sekilas terlihat mirip ya :) 

Dengan Query Builder, pola pikir kita adalah memanggil *method* yang sudah tersedia. Semua jenis query: `select`, `insert`, `update`, `delete`, `grouping`, `join`, `where`, `having`, hingga `sub query` sudah ada padanan *method*-nya di Query Builder. Kita tidak perlu memikirkan bagaimana menyusun sintaks SQL yang tepat, tidak perlu memperhatikan detil kecil seperti kurang spasi atau kurang operator `AND`. Itu tugas Query Builder. Bukan berarti pemahaman tentang sintaks SQL tidak penting. Tapi, yang lebih penting adalah **bagaimana memahami cara menyusun logika query yang benar**. 

Mari kita lihat-lihat lagi contoh kode untuk berinteraksi dengan database menggunakan Query Builder.

#### Contoh Query Builder

```php
// Mendapatkan semua pendonor terurut umur
DB::table('pendonor')
  ->orderBy('age')
  ->get();

// Mendapatkan pendonor di Joglosemar
DB::table('pendonor')
  ->whereIn('location', ['Jogja', 'Solo', 'Semarang'])
  ->get();

// Mendapatkan satu pendonor secara acak
DB::table('pendonor')
  ->inRandomOrder()
  ->first();

// Mendapatkan jumlah pendonor untuk tiap golongan darah
DB::table('pendonor')
  ->select(DB::raw('count(*) as jumlah, blood_type'))
  ->groupBy('blood_type')
  ->get();

// Paginasi
DB::table('pendonor')->paginate(10);
DB::table('pendonor')->skip(5)->take(10)->get();
DB::table('pendonor')->offset(20)->take(30)->get();

// Insert satu data
DB::table('pendonor')->insert(
  ['name' => 'Jon Dodo', 'sex' => 'M', 'blood_type' => 'AB']
);

// Insert banyak data
DB::table('pendonor')->insert([
  ['name' => 'Jon Dodo', 'sex' => 'M', 'blood_type' => 'AB'],
  ['name' => 'Citra Lestari', 'sex' => 'F', 'blood_type' => 'O'],  
]);

// Insert atau update jika record sudah ada sebelumnya
DB::table('pendonor')
  ->updateOrInsert(
  	['name' => 'Jon Dodo', 'sex' => 'M', 'tanggal_lahir' => '1985-11-22'],
    ['donation_count' => '2']
);

// Increment kolom
DB::table('pendonor')->increment('donation_count'); // donation_count += 1;
DB::table('pendonor')->increment('donation_count', 2); // donation_count += 2;
```

Query Builder, dibelakang layar, menggunakan PDO untuk mengakses database. Programmer *oldies* mungkin lebih familiar dengan fungsi-fungsi `mysql` atau `mysqli`. Mari *move on*, [PDO memiliki lebih banyak kelebihan](https://code.tutsplus.com/tutorials/pdo-vs-mysqli-which-should-you-use--net-24059) dibanding `mysql` atau `mysqli`.

Kelebihan lainnya, Query Builder mendukung berbagai macam database, mulai dari MySQL, MariaDB, PostgreSQL, SQL Server, hingga SQLite. Jadi, kita tidak perlu khawatir ketika tiba-tiba database yang digunakan berubah, misalnya dari yang awalnya MySQL menjadi PostgreSQL. Query yang kita buat menggunakan Query Builder akan tetap bisa dipakai lintas database. 

## Eloquent

Eloquent adalah pendekatan yang lebih OOP untuk berinteraksi dengan database. Dibelakang layar, Eloquent juga menggunakan Query Builder untuk menghasilkan sintaks SQL yang tepat. Jadi, membiasakan diri dengan Query Builder akan sangat bermanfaat ketika kita sudah mulai memakai Eloquent. Saya sarankan untuk mencoba dulu Query Builder beberapa saat sebelum mulai menggunakan Eloquent.

Selanjutnya, di bawah ini ada beberapa poin penting terkait Eloquent, lebih dari sisi konsep (bukan teknis), untuk memberikan pondasi dan pemahaman yang kuat dalam mengarungi lautan kode Laravel.

### Eloquent Adalah Salah Satu Bentuk Active Record

- Apa itu AR
- Merepresentasikan tabel sekaligus row
- Apa bedanya dengan Data Mapper

### Eloquent Punya Banyak magic

- timestamps
- accessor
- mutator
- eager load

### Model Hanyalah Sebuah Istilah Dalam MVC

- Namanya tidak harus Model

### Join Digantikan Oleh Relationship

- HasOne
- HasMany
- BelongsTo
- ManyToMany