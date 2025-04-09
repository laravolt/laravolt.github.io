---
title: Code Quality
description: Bad code never survive
extends: _layouts.documentation
section: content
---

# Code Quality

## Prolog

Bagaimana jika bug bisa terdeteksi tanpa harus menge-*run* program? Bagaimana jika bug bisa terdeteksi secara otomatis, tanpa harus melakukan *code review*?

![image-20201130074809347](../assets/uploads/larastan-restul.png)

Pesan di atas adalah contoh hasil *static code analysis* dengan **Larastan** terhadap kode yang sudah lolos *code review*. Larastan 1, code reviewer 0.

Kemampuan dan energi *code reviewer* (manusia) ada batasnya. Hal ini yang kadang menyebabkan kode yang buruk masih bisa lolos reviu dan naik ke *production*. Untuk itulah peran *tools* seperti Larastan menjadi sangat penting untuk menjaga kualitas kode. Selain karena bukan manusia (jadi tidak ada kata lelah), melakukan reviu kode dengan menggunakan *tools* juga lebih obyektif karena ada seperangkat *rules* yang terdefinisi dan telah disepakati sebelumnya.

Code reviewer bisa fokus mengurusi hal-hal penting lainnya, seperti:

1. Penamaan
2. Algoritma
3. Arsitektur *Class*
4. Dan hal-hal lain yang butuh *wisdom*.



## Code Style: Pint

### Tujuan

Memastikan cara penulisan kode seragam antar programmer meskipun menggunakan IDE/editor yang berbeda.

### Tools

https://github.com/laravel/pint

### Instalasi

```bash
composer require laravel/pint --dev
```

### Pemakaian

> 🌟 Jalankan perintah-perintah berikut ini dari folder aplikasi.

Melakukan *fixing* otomatis:

```bash
vendor/bin/pint
```

Melakukan pengecekan saja tanpa *fixing*, tambahkan opsi `--test`:

```bash
vendor/bin/pint --test
```

Jika command-nya terlalu panjang untuk diingat, tambahkan shortcut/alias ke composer.json:

```json
"scripts": {
    "pint": [
        "vendor/bin/pint"
    ]
}
```

Selanjutnya, kita cukup memanggil alias yang sudah didefinisikan di atas:

```bash
composer pint
```

### Customize Config

###### pint.json

```json
{
    "preset": "psr12",
    "rules": {
        "simplified_null_return": true,
        "braces": false,
        "new_with_braces": {
            "anonymous_class": false,
            "named_class": false
        }
    }
}
```

## Static Analysis

### Tujuan

Menemukan bug sebelum bug menemukan kita.

### Tools

- https://phpstan.org/
- https://github.com/larastan/larastan

### Instalasi

```bash
composer require larastan/larastan --dev
composer require spaze/phpstan-disallowed-calls --dev 
```

### Konfigurasi

###### phpstan.neon

```yaml
includes:
  - ./vendor/larastan/larastan/extension.neon
  - ./vendor/spaze/phpstan-disallowed-calls/extension.neon

parameters:
  paths:
    - app
    - config

  # The level 9 is the highest level
  level: 8

  disallowedFunctionCalls:
    - function: 'env()'
      message: 'use config() instead'
      allowIn:
        - config/*.php
```

### Pemakaian

```bash
vendor/bin/phpstan analyse
```



## Cognitive Complexity

### Tujuan

Memastikan kode mudah dibaca dan di-*maintain* untuk jangka waktu yang panjang.

### Tools

https://www.sonarlint.org/

### Instalasi

- https://blog.javan.co.id/meningkatkan-code-quality-dengan-plugin-sonarlint-di-intellij-idea-36705b6cd8fa
- https://blog.javan.co.id/cara-mudah-meningkatkan-kualitas-kode-menggunakan-sonar-37c6f8e0239b



## GrumPHP

### Tujuan

Menjalankan semua tools di atas setiap kali kita melakukan perubahan kode bisa jadi menyita cukup waktu dan berpotensi lupa. Oleh sebab itu, Laravolt sudah dilengkapi dengan GrumpPHP (https://github.com/phpro/grumphp) yang akan melakukan pengecekan secara otomatis setiak kali kita melakukan commit. Jika ada satu saja pengecekan yang gagal, maka commit tidak bisa dilakukan dan kita harus memperbaiki kode terlebih dahulu.

### Instalasi

```bash
composer require phpro/grumphp --dev
```

### Konfigurasi

###### grumphp.yml

```yaml
grumphp:
    tasks:
        phpstan:
            configuration: phpstan.neon
            use_grumphp_paths: false
```

### Pemakaian

#### Pengecekan Manual

```bash
vendor/bin/grumphp run
```

#### Otomatis

```bash
vendor/bin/grumphp git:init
```

Setelah kode di atas dijalankan, maka GrumPHP akan dijalankan secara otomatis sebelum commit.
