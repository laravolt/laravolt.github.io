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

## Merge Request (MR)

1. Beri penjelasan apa yang ditambahkan atau apa yang berubah. Jika sudah menggunakan *task management* (ActiveCollab, Jira, Trello, Basecamp, atau yang lainnya), cukup cantumkan link ke task yang bersangkutan.
2. Assign ke Reviewer yang ditunjuk.
3. Jika ada perbaikan, Reviewer mengubah `Assignee` ke programmer semula.
4. Setelah diperbaiki, programmer mengubah `Assignee` ke Reviewer.
5. Jika sudah OK, maka Reviewer:
    1. Melakukan approval,
    2. Menghapus *merged branch*
    3. Melakukan *squash commit* jika perlu.

> Code review dalam sebuah MR adalah proses belajar yang unik, karena akan ditemui banyak sekali kasus yang baru pertama kali ditemui Programmer, tapi bagi Reviewer sudah berulang-kali mengalaminya. Oleh sebab itu, terkadang timbul pertanyaan: "Ini udah jalan kok, kenapa harus digituin?" Dari sinilah ada proses transfer ilmu yang natural. Programmer memberi solusi berdasar kondisi sekarang, Reviewer memberi masukan berdasar kemungkinan di masa depan. Programmer bisa dapat banyak pengalaman tanpa harus mengalaminya sendiri. Kualitas software menjadi lebih terjaga. Win-win solution.

## .gitignore

`.gitignore` berisi daftar file dan folder yang tidak dimasukkan ke index git. Biasanya yang didaftarkan adalah file dan direktori yang memiliki karakteristik:

1. Berisi konfigurasi yang berbeda-beda untuk setiap programmer, misalnya `.env`.

1. Semua folder untuk menyimpan hasil upload file dari user.

1. Semua folder yang digenerate otomatis oleh aplikasi, misalnya hasil kompilasi JS ataupun CSS.

1. Semua folder yang digenerate oleh OS dan editor/IDE seperti Sublime Text, Visual Studio Code, atau PHPStorm.

1. Untuk kemudahan, bisa menggunakan https://www.gitignore.io/ untuk mendapatkan `.gitignore` yang umum digunakan.

    
