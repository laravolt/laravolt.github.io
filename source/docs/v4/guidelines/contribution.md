---
title: Contribution
description: Programmer mati meninggalkan amal jariyah... dan kode
extends: _layouts.documentation
section: content

---

# Kontribusi

## Setup

0. Install aplikasi [Github Desktop](https://desktop.github.com/). Ini opsional sih, tapi bisa membantu mengelola branch dan memudahkan Pull Request.

1. Jika sudah terdaftar sebagai [Contributor](https://github.com/laravolt/laravolt/people?affiliation=ALL), bisa langsung clone Laravolt dari https://github.com/laravolt/laravolt

2. Jika belum terdaftar sebagai Contributor, silakan [fork](https://help.github.com/en/github/getting-started-with-github/fork-a-repo) dan clone repository Laravolt milikmu sendiri.

3. Laravolt adalah sebuah package, jadi untuk mencobanya kita harus [meng-*install*  Laravel](https://laravel.com/docs/master) terlebih dahulu.

    ```bash
    composer create-project --prefer-dist laravel/laravel sandbox
    ```

    Silakang diselesaikan instalasinya hingga selesai [sesuai dokumentasi](https://laravel.com/docs/master#installation).

4. Sampai disini, struktur folder yang sudah kita buat adalah:

    ```bash
    ├── sandbox (folder Laravel)
    │   ├── README.md
    │   ├── app
    │   ├── artisan
    │   ├── bootstrap
    │   ├── ...
    ├── laravolt (folder Laravolt)
    │   ├── README.md
    │   ├── bin
    │   ├── composer.json
    │   ├── composer.lock
    │   ├── monorepo-builder.yml
    │   ├── packages
    └───└── vendor
    ```

5. Edit file `sandbox/composer.json`, tambahkan potongan kode "repositories" berikut tepat di atas blok "require":

    ```json
    "repositories": [
      {
        "type": "path",
        "url": "../laravolt/",
        "options": {
          "symlink": true
        }
      }
    ],
    "require": {

    },
    ```

6. Selanjutnya, masuk ke folder `sandbox` dan jalankan beberapa [langkah instalasi Laravolt](https://laravolt.dev/docs/installation/) berikut ini:

    ```bash
    cd sandbox
    composer require laravolt/laravolt
    ```

    **Laravel 6**

    ```bash
    php artisan preset laravolt
    ```

    **Laravel 7**

    ```bash
    php artisan ui laravolt
    ```

    ```bash
    php artisan vendor:publish --tag=migrations
    php artisan migrate
    php artisan laravolt:admin Admin admin@laravolt.dev secret
    ```

7. Install dan compile Assets

    **Yarn user**

    ```bash
    yarn install
    yarn run dev
    ```

    **NPM user**

    ```bash
    npm install
    npm run dev
    ```

8. Jalankan `php artisan server` atau *web server* lain kesayanganmu. Pastikan ketika diakses di browser (misalnya http://localhost:8000), muncul halaman login. Gunakan *credentials* sesuai yang diisikan pada langkah sebelum ini.



## Development

Setelah setup selesai, kamu bisa mulai koding menyempurnakan Laravolt. Ingat, kita punya dua buah folder:

1. Folder `sandbox` bertindak sebagai aplikasi, semua perubahan disini tidak akan dicommit ke Laravolt. Folder ini digunakan untuk menguji apakah perubahan yang kita lakukan sudah sesuai dengan harapan atau belulm.
2. Folder `laravolt` berisi `source code` Laravolt. Perubahan yang dilakukan disini akan dicommit + dimerge ke repository Laravolt.

```bash
├── README.md
├── bin
│   ├── build.sh
│   └── split.sh
├── composer.json
├── composer.lock
├── monorepo-builder.yml
└── packages
    ├── camunda
    ├── comma
    ├── epilog
    ├── lookup
    ├── mailkeeper
    ├── media
    ├── menu
    ├── platform
    ├── semantic-form
    ├── suitable
    ├── support
    ├── thunderclap
    └── workflow
```

3. Pastikan selalu membuat *branch* baru sebelum mulai koding, dengan format:
    1. `feature/<nama-feature>`
    2. `bug/<nama-bug>`
4. Pastikan sudah ada isu terkait di https://github.com/laravolt/laravolt/issues. Jika belum ada, silakan tambahkan isu baru.
5. Jika koding sudah selesai, lakukan Pull Request:
    1. [Melalui aplikasi desktop](https://help.github.com/en/desktop/contributing-to-projects/creating-a-pull-request)
    2. Atau [melalui web](https://help.github.com/en/github/collaborating-with-issues-and-pull-requests/creating-a-pull-request)
6. Selamat bersenang-senang ⚡️