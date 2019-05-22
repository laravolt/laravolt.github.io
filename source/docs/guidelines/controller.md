---
title: Controller
description: Thin controller is the new sexy
extends: _layouts.documentation
section: content
---

# Controller

1. Controller tidak boleh mengandung *business logi*c berat.
2. Controller tidak boleh melakukan validasi form. Sebagai gantinya, gunakan ***Form Request***.
3. Controller hanya boleh melakukan hal-hal dibawah ini:
   1. Memanggil ***Model*** atau ***Service*** lain untuk mendapatkan data.
   2. Melakukan *authorization*.
   3. Melakukan *redirection*.
   4. Mengeset *flash message*.
   5. Aksi lain yang berhubungan dengan HTTP.
4. Wajib menerapkan prinsip ***Resource Controller***.
5. Jika *Resource Controller* tidak cukup, buat ***Single Action Controller***.