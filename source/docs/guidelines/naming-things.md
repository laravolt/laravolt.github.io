---
title: Naming Things
description: Two hard things in programming
extends: _layouts.documentation
section: content

---

# Naming Things

| What                     | Penulisan                                           | Contoh                                                       |
| ------------------------ | --------------------------------------------------- | ------------------------------------------------------------ |
| Variable                 | camelCase                                           | $userId                                                      |
| Class Property           | camelCase                                           | private $accessToken                                         |
| Class Method             | camelCase                                           | $postRepository->featuredArticle()                           |
| Global Helper            | snake_case                                          | format_rupiah()                                              |
| Model                    | StudlyCase<br />Kata Benda                          | User<br />UserProfile                                        |
| View File                | kebab-case                                          | laporan-harian.blade.php                                     |
| Resource Controller      | StudlyCase<br />Kata Benda<br />Sufiks `Controller` | UserController<br />BukuTamuController                       |
| Single Action Controller | StudlyCase<br />Kata Kerja<br />Sufiks `Controller` | ClearCacheController<br />LogoutController<br />DownloadLaporanHarianController |
| Route URL                | kebab-case                                          | https://javan.co.id/lowongan-kerja                           |
| Route Name               | kebab-case                                          | Route::get('lowongan-kerja', 'LowonganKerjaController@index')->name('lowongan-kerja'); |
| Route Parameter          | camelCase                                           | Route::get('lowongan-kerja/{lowonganKerja}', 'LowonganKerjaController@index'); |
| Config File              | kebab-case                                          | config/dynamic-form.php                                      |
| Config Key               | snake_case                                          | `'allowed_types' => ['text', 'textarea', 'select’]`          |
| Artisan Command          | kebab-case                                          | `php artisan generate-laporan`                               |
