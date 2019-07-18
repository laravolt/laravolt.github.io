---
title: Coding Standard
description: Bad code never survive
extends: _layouts.documentation
section: content
---
# Git
## Penamaan Branch

1. Nama branch ditulis dalam format **kebab-case**
2. Dua branch yang wajib ada adalah:
   - `master` sebagai branch utama. Merge ke `master` berarti naik ke production.
   - `develop` sebagai branch development. Merge ke `develop` berarti naik ke staging. 
3. Sesuai dengan jenis task, nama branch wajib diawali dengan salah satu prefix berikut:
   - `feature/`
   - `issue/`
   - `hotfix/`

#### Contoh

##### Good

- `feature/crud-faq`
- `issue/gagal-edit-password`
- `hotfix/hapus-hardcoded-userid`

##### Bad

- `crudFaq`
- `gagal_edit_password`
- `hotfix_hapus-userId`

## Commit

1. Sebelum commit, cek kembali daftar _modified files_ dan pastikan tidak ada kode sampah.
1. Jika menemukan perubahan yang tidak berhubungan dengan yang lain tapi kamu merasa sayang untuk dibuang, lakukan `git stash`.
1. Alokasikan minimal 30 detik untuk mengingat kembali **kenapa** kamu melakukan perubahan tersebut. 
Tuliskan jawaban dari pertanyaan **kenapa** tersebut sebagai _commit message_. Lakukan ini dalam kondisi apapun, baik santai ataupun dibawah tekanan. Menunda commit 30 detik tidak akan membuatmu dipecat.

## .gitignore

`.gitignore` berisi daftar file dan folder yang tidak dimasukkan ke index git. Biasanya yang didaftarkan adalah file dan direktori yang memiliki karakteristik:

1. Berisi konfigurasi yang berbeda-beda untuk setiap programmer, misalnya `.env`.

1. Semua folder untuk menyimpan hasil upload file dari user.

1. Semua folder yang digenerate otomatis oleh aplikasi, misalnya hasil kompilasi JS ataupun CSS.

1. Semua folder yang digenerate oleh OS dan editor/IDE seperti Sublime Text, Visual Studio Code, atau PHPStorm.

1. Untuk kemudahan, bisa menggunakan https://www.gitignore.io/ untuk mendapatkan `.gitignore` yang umum digunakan.

    
