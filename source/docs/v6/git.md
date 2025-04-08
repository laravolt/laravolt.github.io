---
title: Git Guideline
description: Bad code never survive
extends: _layouts.documentation
section: content
---
# Git
## Workflow

Git workflow mendefinisikan bagaimana *branching strategy* kita ketika memakai git dalam pengembangan software, mencakup:

1. Bagaimana menamakan branch?
2. Kapan perlu membuat branch baru?
3. Kapan deployment bisa dilakukan?
4. Branch baru dibuat dari branch yang mana?
5. Jika sudah selesai, branch baru di-merge kemana?
6. Bagaimana jika ada bug di production?
7. Dan lain-lain terkait strategi branching

Ada dua metode yang sering dijadikan rujukan, yaitu:

1. [GitFlow](https://nvie.com/posts/a-successful-git-branching-model/) (versi ideal untuk product development, relatif lebih kompleks, cocok untuk tim dan scope proyek besar)
2. [Github Flow](https://guides.github.com/introduction/flow/) (sederhana, cocok untuk tim dan proyek kecil)

Masing-masing metode punya kelebihan dan kekurangan masing-masing. Dan dalam perjalanannya, kami mencoba menerapkan metode baru yang sesuai untuk diterapkan dalam pengembangan sistem informasi di Indonesia, sebut saja **[Simplified Git Flow](https://medium.com/goodtogoat/simplified-git-flow-5dc37ba76ea8)**.

### Simplified Git Flow

- Minimal selalu ada 2 branch:
    - `main` adalah (protected) branch yang siap di-deploy ke production.
    - `develop` adalah (protected + default) branch yang aktif digunakan selama masa pengembangan. Pengujian dilakukan di branch ini. 
- Ketika programmer mulai mengerjakan sesuatu, buat branch baru dari `develop` sesuai **aturan penamaan branch** yang telah ditetapkan (lihat di bawah).
- Jika ada bug di production, maka programmer membuat branch *hotfix* dari `main`. Jika sudah selesai, merge ke `develop` untuk dilakukan pengujian (branch `hotfix` jangan dihapus) **dan jika sudah lolos tes** dilanjutkan dengan merge lagi branch `hotfix` tersebut  ke `main`. 
- Secara periodik (biasanya mingguan), setelah lolos pengujian, branch `develop` di merge ke branch `main` dan otomatis di-deploy ke production.
    - Pada tahap ini bisa dilakukan proses ***tagging new version*** untuk memudahkan penyebutan. Jadi jika ada bug, kita bisa bilang "oh, ini muncul sejak versi 1.1" dan bukan "oh, ini muncul sejak 2 atau 3 minggu yang lalu".

## Penamaan Branch

1. Nama branch ditulis dalam format **kebab-case**
2. Dua branch yang wajib ada adalah:
   - `main` sebagai branch utama. Merge ke `main` berarti naik ke production.
   - `develop` sebagai branch development. Merge ke `develop` berarti naik ke staging. 
3. Sesuai dengan jenis task, nama branch wajib diawali dengan salah satu prefix berikut:
   - `feature/` untuk fitur baru atau enhancement fitur yang sudah ada sebelumnya
   - `issue/` untuk bugfix
   - `hotfix/` untuk bugfix yang sangat penting dan harus segera dideploy ke production
   - `refactor/` untuk perbaikan kode tanpa adanya penambahan fitur baru
   - `styling/` untuk perbaikan tampilan tanpa adanya penambahan fitur

> Sebelumnya, kita mengenal _default branch name_ yang biasa digunakan adalah `master`. Tapi sejak tahun 2020, istilah `master` mulai diganti dengan `main`.
> Referensi terkait pergantian ini:
> 
> - [Github](https://about.gitlab.com/blog/2021/03/10/new-git-default-branch-name/)
> - [Gitlab](https://about.gitlab.com/blog/2021/03/10/new-git-default-branch-name/)

### Contoh

#### ✅ Good

- `feature/crud-faq`
- `feature/mockup-login`
- `issue/gagal-edit-password`
- `hotfix/hapus-hardcoded-userid`
- `refactor/cleanup-user-controller`
- `styling/login-page`
- `styling/perbesar-searchbox-topbar`

#### ❌ Bad

- `crudFaq`
- `gagal_edit_password`
- `hotfix_hapus-userId`
- `perbaikan-tampilan` (Tampilan yang mana?)
- `feature/damar` (jangan narsis)

## Commit

1. Sebelum commit, cek kembali daftar _modified files_ dan pastikan tidak ada kode sampah.
1. Jika menemukan perubahan yang tidak berhubungan dengan yang lain tapi kamu merasa sayang untuk dibuang, lakukan `git stash`.

## Pesan Commit

Alokasikan minimal **30 detik** untuk mengingat kembali **kenapa** kamu melakukan perubahan tersebut. 
Tuliskan jawaban dari pertanyaan **kenapa** tersebut sebagai _commit message_. Lakukan ini dalam kondisi apapun, baik santai ataupun dibawah tekanan. Menunda commit **30 detik** tidak akan menyebabkan perang dunia ketiga.

### Contoh

| ❌ Bad                                               | Why Bad?         | ✅ Good                                                       |
| --------------------------------------------------- | ---------------- | ------------------------------------------------------------ |
| Fix product rating                                  | Terlalu umum     | Fix product rating: handle jika rating masih null            |
| Fix bug                                             | Terlalu umum     | Perbaikan pengecekan role admin ketika hapus komentar        |
| Tambah validasi                                     | Terlalu umum     | Tambah validasi harga produk: value yang diinput minimal "0" |
| Halaman grocery 404                                 | Ambigu           | Fix 404 ketika mengakses halaman grocery karena salah urutan routes |
| Muncul pesan error jika profil tidak lengkap        | Ambigu           | Munculkan pesan error jika profil tidak diisi lengkap<br />**atau**<br />Hapus pesan error meskipun profil tidak diisi lengkap |
| menghapus spasi pada PartnerController.php line 217 | Terlalu spesifik | Hapus whitespace karena menyebabkan blank response           |
| button cari filter kost                             | Terlalu umum     | Ubah ukuran tombol "Cari" di halaman filter kost             |
| styling searchbox                                   | Terlalu umum     | Ubah searchbox agar lebih kontras dan kelihatan              |
| memperbaiki tampilan mobile                         | Terlalu umum     | Mengubah ~~tampilan mobile~~ halaman pencarian agar sesuai dengan desain di zeplin |
| migration                                           | Terlalu umum     | migration: tambah kolom item_task                            |
| change migration                                    | Terlalu umum     | migration: ubah kolom users.name menjadi nullable            |



## Merge Request (MR)

1. Sebelum melakukan MR, pastikan:
    1. Pesan commit yang saya tuliskan sudah sesuai panduan
    2. Saya sudah melakukan pengujian mandiri
    3. Saya sudah menghapus semua `comment` dan `unused debugging code`
2. Beri penjelasan apa yang ditambahkan atau apa yang berubah. Jika sudah menggunakan *task management* (ActiveCollab, Jira, Trello, Basecamp, atau yang lainnya), cukup cantumkan link ke task yang bersangkutan.
3. Assign ke Reviewer yang ditunjuk.
4. Jika ada perbaikan, Reviewer mengubah `Assignee` ke programmer semula.
5. Setelah diperbaiki, programmer mengubah `Assignee` ke Reviewer.
6. Jika sudah OK, maka Reviewer:
    1. Melakukan approval,
    2. Menghapus *merged branch*
    3. Melakukan *squash commit* jika perlu.



## Code Review

Code review dalam sebuah MR adalah proses belajar yang unik, karena akan ditemui banyak sekali kasus yang baru pertama kali ditemui Programmer, tapi bagi Reviewer sudah berulang-kali mengalaminya. Oleh sebab itu, terkadang timbul pertanyaan: "Ini udah jalan kok, kenapa harus digituin?" 

Dari sinilah ada proses transfer ilmu yang natural. Programmer memberi solusi berdasar kondisi sekarang, Reviewer memberi masukan berdasar kemungkinan di masa depan. Programmer bisa dapat banyak pengalaman tanpa harus mengalaminya sendiri. Kualitas software menjadi lebih terjaga. 

**Win-win solution**.

### Checklist Untuk Reviewer

1. Kode sesuai standard *style guidelines*
2. Perubahan kode sesuai dengan MR
3. Tidak ada hardcoded rule
4. Jika ada potongan kode yang cukup panjang dan tidak dimengerti, boleh minta penjelasan
5. Setiap migration script harus disertai dengan seeder yang sesuai

## .gitignore

`.gitignore` berisi daftar file dan folder yang tidak dimasukkan ke index git. Biasanya yang didaftarkan adalah file dan direktori yang memiliki karakteristik:

1. Berisi konfigurasi yang berbeda-beda untuk setiap programmer, misalnya `.env`.

1. Semua folder untuk menyimpan hasil upload file dari user.

1. Semua folder yang digenerate otomatis oleh aplikasi, misalnya hasil kompilasi JS ataupun CSS.

1. Semua folder yang digenerate oleh OS dan editor/IDE seperti Sublime Text, Visual Studio Code, atau PHPStorm.

1. Untuk kemudahan, bisa menggunakan https://www.gitignore.io/ untuk mendapatkan `.gitignore` yang umum digunakan.

    

## Kesalahan Umum

#### Default Branch ke `main`

Ketika programmer melakukan *cloning* repository, maka seharusnya dia langsung mendapatkan kode yang sedang aktif dikembangkan, yaitu branch `develop`. Ingat, branch `main` untuk deploy ke production, branch `develop` untuk active development.

#### Menamai Default Branch `dev`

`develop` lebih umum dipakai. `dev` sendiri memiliki [makna khusus](https://getcomposer.org/doc/articles/aliases.md) di composer sehingga lebih baik dihindari.

#### Branch Yang Sudah *Merged* Tidak Dihapus

*Merged branch* yang tidak dihapus hanya menjadi sampah dan mengganggu *developer experience*.

![image-20191024221020936](../assets/uploads/image-20191024221020936-1929823-1930387.png)

![image-20191024221112561](../assets/uploads/image-20191024221112561-1929874.png)

Jumlah ideal branch adalah 2 + (2 x jumlah programmer). Contoh, jika dalam satu waktu ada 3 programmer yang terlibat, maka jumlah branch seharusnya tidak lebih dari 8.

#### Duplikasi *Author Name*

Ada programmer yang memakai beberapa tools untuk melakukan commit: git command line, git kraken, sourcetree, atau fork. Permasalahan muncul ketika masing-masing tools tersebut mempunyai konfigurasi yang berbeda terkait identitas yang dipakai untuk commit.

Melihat gambar di bawah, apakah Anda bisa menghitung berapa jumlah programmer sebenarnya?

![image-20191024221515563](../assets/uploads/image-20191024221515563-1930117.png)

Pastikan setiap tools sudah diatur dengan nama dan email yang seragam. Cara lain, [atur konfigurasi git agar memakai identitas yang sama](https://crunchify.com/how-to-set-github-user-name-and-user-email-per-repository-different-config-for-different-repository/).

## Referensi

- [git - the simple guide](https://rogerdudler.github.io/git-guide/)
- [Mastering Git by thoughbot](https://thoughtbot.com/upcase/mastering-git?utm_campaign=ad&utm_medium=referral&utm_source=robots.thoughtbot.com&utm_term=https://thoughtbot.com/blog/5-useful-tips-for-a-better-commit-message)
- [Source Code management untuk Pemula by Dicoding](https://www.dicoding.com/academies/116)
- [GitFlow Workflow Best Practices](https://vitalflux.com/gitflow-workflow-best-practices-quiz-questions/)
- [Git and Release Management Workflow](https://rubygarage.org/blog/git-and-release-management-workflow)
