---
title: View
description: Dumb view is the best view in the world
extends: _layouts.documentation
section: content
---

# View

1. View tidak boleh mengandung *logic*.
2. Jika view sudah terlalu kompleks, manfaatkan `@include` dan `@component` untuk memecahnya.
3. Manfaatkan ***Service Injection*** ketika:
   - View akan dipakai di beberapa tempat.
   - Ada bagian view yang kadang perlu ditampilkan kadang tidak, tergantung role atau kondisi lainnya.
