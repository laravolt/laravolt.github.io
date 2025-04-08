---
title: Naming Things
description: Two hard things in programming
extends: _layouts.documentation
section: content

---

# Naming Things

| What                     | Penulisan                                                    | Contoh                                                       |
| ------------------------ | ------------------------------------------------------------ | ------------------------------------------------------------ |
| Variable                 | camelCase                                                    | $userId                                                      |
| Class property           | camelCase                                                    | private $accessToken                                         |
| Class method             | camelCase                                                    | $postRepository->featuredArticle()                           |
| Global helper            | snake_case                                                   | format_rupiah()                                              |
| Model                    | StudlyCase<br />**Kata Benda**                               | User<br />UserProfile                                        |
| View file                | kebab-case                                                   | laporan-harian.blade.php                                     |
| View file (partial)      | kebab-case **diawali underscore**                            | _tabel-pegawai.blade.php                                     |
| Resource controller      | StudlyCase<br />**Kata Benda**<br />Sufiks `Controller`      | UserController<br />BukuTamuController                       |
| Single action controller | StudlyCase<br />**Kata Kerja**<br />Sufiks `Controller`      | ClearCacheController<br />LogoutController<br />DownloadLaporanHarianController |
| Route URL                | kebab-case                                                   | https://javan.co.id/lowongan-kerja                           |
| Route name               | kebab-case<br />**Antara resource dan action dipisahkan dot (".")** | Route::get('lowongan-kerja', 'LowonganKerjaController@index')->name('lowongan-kerja.index'); |
| Route parameter          | camelCase                                                    | Route::get('lowongan-kerja/{lowonganKerja}', 'LowonganKerjaController@index'); |
| Config file              | kebab-case                                                   | config/dynamic-form.php                                      |
| Config key               | snake_case                                                   | `'allowed_types' => ['text', 'textarea', 'select’]`          |
| Artisan command          | kebab-case                                                   | `php artisan generate-laporan`                               |
| Table name               | snake_case<br />**Kata Benda**<br />Bisa diberi prefik untuk ***grouping*** | pegawai <br />master_provinsi<br />master_kabupaten<br />    |
