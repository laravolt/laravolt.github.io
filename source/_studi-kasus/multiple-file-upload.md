---
title: Multiple File Upload
description: Contoh (multiple) upload file di Laravolt
extends: _layouts.documentation
section: content
---

# Multiple File Upload

## Intro

Salah satu fitur yang sering dibutuhkan dalam sebuah sistem informasi adalah upload (mengunggah) file. HTML sendiri sebenarnya sudah menyediakan input jenis ini secara default, yaitu menggunakan `<input type="file">` (single file) atau `<input type="file" multiple>` (multiple file).

![Image result for html input file](https://i.stack.imgur.com/UElpZ.png)

Hanya saja biasanya pengguna ingin dibuatkan tampilan yang lebih cantik, misalnya ingin diperlihatkan thumbnail, ditambahkan tombol hapus, bisa drag n drop, atau copy paste gambar dari clipboard.

![Image result for fileuploader](http://vhbs.atauni.edu.tr/tema/cancanUpload/images/image-2.png) 

Dengan kebutuhan seperti itu, fitur upload bawaan HTML sudah pasti tidak bisa mengakomodir. Butuh "sedikit" bantuan dari Javascript. Hanya saja terkadang proses integrasi Javascript ini sedikit merepotkan programmer dan Laravolt memahami kebutuhan ini. Oleh sebab itu, Laravolt `semantic-form` sudah menyediakan sebuah fitur untuk membuat upload file yang cantik, dinamis, dan mudah diintegrasikan.

## Upload File Dengan `semantic-form`

