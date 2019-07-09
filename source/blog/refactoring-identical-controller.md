---
title: Refactoring Identical Controller
description: Melakukan refactor Controller yang sangat mirip untuk mengurangi duplikasi
extends: _layouts.documentation
section: content

---

# Refactoring Identical Controller

## Contoh Kasus

Jon sedang terlibat dalam proyek pembuatan aplikasi bike sharing. Salah satu fiturnya adalah membuat CRUD sepeda. Singkat cerita, Jon membuat fungsi untuk menyimpan data sepeda seperti di bawah ini:

###### app/Http/Controllers/SepedaController.php

```php
public function store(Request $request)
{
    $sepeda = Sepeda::create($request->all());

    return redirect()->route('sepeda.index')->with('success', 'Data berhasil disimpan.');
}
```

Jon beranggapan kodingannya sudah benar, betul, dan bersahabat. 

Beberapa bulan berikutnya, Jon diminta untuk membuat API terkait CRUD sepeda. Proses bisnisnya sama dengan versi web ditambah adanya perhitungan otomatis untuk mengisi field `pole_id`. Tanpa ba bi bu, Jon langsung menerapkan jurus copy paste edit.

###### app/Http/Controllers/Api/SepedaController.php

```php
public function store(Request $request)
{
    $request->merge([
        'pole_id' => ParkingPole::findByCoordinate($request->latitude, $request->longitude)->id,
    ]);
    $sepeda = Sepeda::create($request->all());
    
    return response()->json($sepeda);

}
```



## Masalah

## Solusi