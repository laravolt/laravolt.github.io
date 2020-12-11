---
title: The right tools for the right code
description: Rekomendasi beberapa pengaturan yang akan menambah playground anda menarik.
extends: _layouts.documentation
section: content
---
# Editor & IDE

Direkomendasikan untuk menggunakan salah satu editor berikut ini:

**PHPStorm**

- Berbayar (gratis untuk mahasiswa)
- *Powerfull*
- Butuh RAM besar

**Visual Studio Code**

- Gratis
- Butuh usaha tambahan agar bisa se-*powerful* PHPStorm
- Lebih hemat RAM

## Visual Studio Code

Link: https://code.visualstudio.com/

Visual Studio Code adalah sebuah ***text editor*** yang sangat ringan dan intuitif. Nah, agar fungsinya semakin *powerfull*, kita perlu menambahkan beberapa ekstensi agar editor tercinta ini memiliki *value* (fitur) lebih dari *text editor* lain seperti *nano* atau *notepad++*.

### TL;DR

> *Commands* dibawah akan secara otomatis menambah *extension* dari daftar ***rekomendasi extension essential*** tanpa perlu melakukan instalasi satu persatu.

1. Pasang *extension* **Settings Sync**
1. `SHIFT + ALT + D` untuk membuka GUI dari *extension*
1. Klik menu `Download Public Gist`
1. Masukkan `25cef208ec0fa79cebfeb0a653370b91`
1. Tunggu hingga *process* pemasangan dan pengunduhan *extension* selesai

### Rekomendasi *Extension Essential*

#### Settings Sync

Link: https://marketplace.visualstudio.com/items?itemName=Shan.code-settings-sync

Fungsi utama dari *extension* ini adalah untuk mengamankan pengaturan *text editor* kesayangan kita yang satu ini. Jika sewaktu-waktu kita perlu pindah *machine* kita cukup mensinkronasikan *setting*-an sebelumnya dan tetap menggunakan habit kita biasanya tanpa *setup* apapun lagi.

#### PHP Intelephense

Link: https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client

*PHP code intelligence for Visual Studio Code*, adalah sebuah *extension* yang akan mendukung *coding*-an PHP kita lebih produktif. Versi ringan dari [PHP IntelliSense](https://marketplace.visualstudio.com/items?itemName=felixfbecker.php-intellisense), dengan fungsionalitas kurang lebih sama *extension* **PHP Intelephense** akan mengurangi beban *machine*.

#### Laravel Extension Pack

Link: https://marketplace.visualstudio.com/items?itemName=onecentlin.laravel-extension-pack

Satu *extension* yang akan memasangkan ke kita beberapa *extension* lain, seperti:
1. Laravel Blade Snippets
1. Laravel Snippets
1. Laravel Artisan
1. Laravel Extra Intellisense
1. Laravel goto view
1. Laravel goto controller
1. DotENV

#### Sonarlint

Link: https://marketplace.visualstudio.com/items?itemName=SonarSource.sonarlint-vscode

Dengan *extension* ini kita bisa meningkatkan kualitas dari kode yang kita buat, dengan catatan kita memenuhi semua rekomendasi yang diberikan.

#### GitLens
Link: https://gitlens.amod.io/

Ekstensi GitLens memudahkan kita berinteraksi dengan git. Beberapa fitur yang disediakan:
1. Navigasi _file_ sesuai history git.
2. _Git blame & authorship_, menyediakan informasi commit beserta siapa author yang terakhir kali mengubah file ataupun baris kode tertentu.
3. Visualisasi git _branch_.

## PHPStorm

Link: https://www.jetbrains.com/phpstorm/

Untuk menambahkan plugins, silakan buka men Preferences > Plugins > Marketplace.

PHPStorm sudah dibekali dengan banyak fitur bawaan sehingga kita hanya perlu menambahkan beberapa plugin saja, antara lain:
1. Laravel
2. SonarLint
3. Php Inspection (EA Extended)
4. WakaTime (opsional, statistik personal)
5. Code with me (_collaborative coding_)
