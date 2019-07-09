---
title: Route
description: Always take the scenic route
extends: _layouts.documentation
section: content

---

# Route

## Penamaan Route

| What     | How                  | Good                       | Bad                                                        |
| -------- | -------------------- | -------------------------- | ---------------------------------------------------------- |
| **URL**  | singular, kebab-case | `“/laporan-harian”`        | `“/laporanHarian”`, `“/laporan_harian”`                    |
| **Name** | singular, kebab-case | `->name("laporan-harian")` | `->name("laporanHarian")`, <br />`->name(laporan_harian")` |

## Patuhi Tujuh Kata Ajaib

Pendefinisian route untuk aksi-aksi standard CRUD adalah:

| Verb      | URI                 | Action  | Route Name   |
| :-------- | :------------------ | :------ | :----------- |
| GET       | `/user`             | index   | user.index   |
| GET       | `/user/create`      | create  | user.create  |
| POST      | `/user`             | store   | user.store   |
| GET       | `/user/{user}`      | show    | user.show    |
| GET       | `/user/{user}/user` | edit    | user.edit    |
| PUT/PATCH | `/user/{user}`      | update  | user.update  |
| DELETE    | `/user/{user}`      | destroy | user.destroy |

#### 👍🏼 Eksplisit

```php
Route::get('/user', 'UserController@index')->name('user.index');
Route::get('/user/{user}', 'UserController@show')->name('user.show');
Route::get('/user/create', 'UserController@edit')->name('user.create');
Route::post('/user', 'UserController@store')->name('user.store');
Route::get('/user/{user}', 'UserController@edit')->name('user.edit');
Route::put('/user/{user}', 'UserController@update')->name('user.update');
Route::delete('/user/{user}', 'UserController@destroy')->name('user.destroy');
```

#### 👍🏼 Implisit

```php
Route::resource('user', 'UserController');
```

Jika membutuhkan aksi tambahan, buat `Controller` baru dengan tetap mematuhi **7 kata ajaib** sebagai *action*-nya.

### Contoh 1: Edit Password User

#### 😕 Bad

###### editPassword dan updatePassword tidak termasuk 7 kata ajaib

```php
Route::get('/user/{user}/password', 'UserController@editPassword');
Route::put('/user/{user}/password', 'UserController@updatePassword');
```

#### 👍🏼 Good

###### Controller Baru Dengan Nama Gabungan

```php
Route::get('/user/{user}/password', 'UserPasswordController@edit');
Route::put('/user/{user}/password', 'UserPasswordController@password');
```

#### 👍🏼 Good

###### Controller Baru Sebagai Nested Controller

```php
Route::get('/user/{user}/password', 'User\PasswordController@edit');
Route::put('/user/{user}/password', 'User\PasswordController@password');
```

### Contoh 2: Menampilkan Daftar Follower User

#### 😕 Bad

###### follower tidak termasuk 7 kata ajaib

```php
Route::get('/user/{user}/follower', 'UserController@follower');
```

#### 👍🏼 Good

###### Controller Baru Dengan Nama Gabungan

```php
Route::get('/user/{user}/follower', 'UserFollowerController@index');
```

#### 👍🏼 Good

###### Controller Baru Sebagai Nested Controller

```php
Route::get('/user/{user}/follower', 'User\FollowerController@index');
```

> Referensi
>
> - https://laravel.com/docs/5.8/controllers#resource-controllers
> - https://blog.javan.co.id/resource-controller-29d129413be2
> - https://streamacon.com/video/laracon-us-2017/day-1-adam-wathan

## Single Action Controller

Manfaatkan Single Action Controller ketika:

1. Bukan salah satu aksi CRUD.
2. Aksi bisa dipanggil dari halaman mana saja.
3. Aksi berkaitan dengan tabel pivot (many to many).

Beberapa contoh kasus pemanfaatan Single Action Controller antara lain:

1. Upload file
2. Reset password
3. Clear cache
4. Landing page setelah login
5. Logout
6. Follow-unfollow, subscribe-unsubscribe, like-dislike, dan aksi lain yang sifatnya *toggleable*.

> Referensi: https://laravel.com/docs/5.8/controllers#single-action-controllers