---
title: Customizing The UI
description: Memodifikasi tampilan default Laravolt
extends: _layouts.documentation
section: content
---

# Customizing The UI

## Merubah Theme Dashboard Admin
Laravolt telah menyediakan theme untuk dashboard admin diantaranya : 
*** basik, black, blue, classic, cool, fox, grey, pink, red, teal dan violet***.

Untuk merubah theme setting di ***config/laravolt/ui.php***
```php
 /*
 * Set default theme
 * Available themes: basik, black, blue, classic, fox, grey, pink, red, teal, violet
 * */
'theme' => 'black',
```
## Membuat Theme Baru
### 1. Buat file Sass
buat file Sass di resources/sass/ , untuk format nama file nya ***_new-theme***


### 2. Import Theme
Setelah kita membuat file Sass untuk theme baru, kita bisa meng-import ke file sass utama kita.

Dibawah ini contoh meng-import file theme baru ke app.scss
```sass
@import "new-theme";

```
### 3. Memulai custom theme
Dibawah ini contoh sketelon untuk membuat theme baru.
```sass
[data-theme="new-theme"] {
    //style
 }
```


> Kamu bisa copy paste theme existing yang sudah disediakan oleh laravolt, Hal ini untuk mempermudah kita membuat theme baru. Untuk theme existing kamu bisa copy di vendor/laravolt/laravolt/packages/platform/resources/sass/themes/ 

Setelah selesai membuat theme baru, kamu harus setting config Laravolt UI di config/laravolt.ui.php.
Ubah dengan theme yang baru saja kita buat.
