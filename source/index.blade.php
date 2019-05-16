@extends('_layouts.master')

@section('body')
<section class="container max-w-6xl mx-auto px-6 py-10 md:py-12">
    <div class="flex flex-col-reverse mb-10 lg:flex-row lg:mb-24">
        <div class="mt-8 mr-20">
            <h1 id="intro-docs-template">{{ $page->siteName }}</h1>

            <h2 id="intro-powered-by-jigsaw" class="font-light mt-4">{{ $page->siteDescription }}</h2>

            <p class="text-lg">Laravolt menyediakan fitur standard sebuah sistem informasi. Arsitektur Laravolt memaksamu berpikir modular sehingga sebuah fitur (modul) bisa digunakan di proyek lain dengan mudah. </p>

            <div class="flex my-10">
                <a href="/docs/getting-started" title="{{ $page->siteName }} getting started" class="bg-indigo-700 hover:bg-indigo-800 text-white hover:text-white rounded mr-4 py-2 px-6">Coba Sekarang</a>

                <a href="https://jigsaw.tighten.co" title="Jigsaw by Tighten" class="border border-indigo-700 hover:border-indigo-900 text-indigo-700 hover:text-indigo-800 rounded py-2 px-6">Kenapa Laravolt?</a>
            </div>
        </div>

        <img src="/assets/img/logo-large.svg" alt="{{ $page->siteName }} large logo" class="mx-auto mb-6 lg:mb-0 ">
    </div>

    <hr class="block my-8 border lg:hidden">

    <div class="md:flex">
        <div class="mb-8 mx-3 px-2 md:w-1/3">
            <img src="/assets/img/icon-terminal.svg" class="h-12 w-12" alt="window icon">

            <h3 id="intro-laravel" class="text-2xl text-indigo-darkest mb-0">Code Generator</h3>

            <p>Membuat CRUD hanya dalam hitungan detik. Kode yang dihasilkan sangat eksplisit, mudah dimodifikasi, dan <i>developer friendly</i>.</p>
        </div>

        <div class="mb-8 mx-3 px-2 md:w-1/3">
            <img src="/assets/img/icon-window.svg" class="h-12 w-12" alt="terminal icon">

            <h3 id="intro-markdown" class="text-2xl text-indigo-darkest mb-0">Unified Interface</h3>

            <p>Admin panel yang minimalis, ringan, dan elegan, didukung puluhan komponen siap pakai. Laravolt menjanjikan kenyamanan penggunaan bagi <i>end user</i>.</p>
        </div>

        <div class="mx-3 px-2 md:w-1/3">
            <img src="/assets/img/icon-stack.svg" class="h-12 w-12" alt="stack icon">

            <h3 id="intro-mix" class="text-2xl text-indigo-darkest mb-0">Plug n Play</h3>

            <p>Laravolt memaksa developer untuk berpikir modular. Satu fitur satu folder. Cukup salin satu folder tersebut ke proyek sebelah dan <i>it's just work</i>.</p>
        </div>
    </div>
</section>
@endsection
