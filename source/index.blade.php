@extends('_layouts.master')

@section('body')
<section class="container max-w-6xl mx-auto px-6 py-10 md:py-12">
    <div class="flex flex-col-reverse mb-10 lg:flex-row lg:mb-24">
        <div class="mt-8 mr-20">
            <h1 id="intro-docs-template">{{ $page->siteName }}</h1>

            <h2 id="intro-powered-by-jigsaw" class="font-light mt-4">{{ $page->siteDescription }}</h2>

            <p class="text-lg">Laravolt menyediakan fitur standard sebuah sistem informasi dan membantu mempercepat pembuatan fitur baru dengan <i>code generator</i> yang disediakan. Jika kamu sudah kenal Laravel, maka kamu sudah bisa Laravolt. </p>

            <div class="flex my-10">
                <a href="/docs/{{ $page->selectedVersion() }}" title="{{ $page->siteName }} getting started" class="bg-indigo-700 hover:bg-indigo-800 text-white hover:text-white rounded mr-4 py-2 px-6">Baca Dokumentasi</a>
            </div>
        </div>

        <img src="/assets/img/process.svg" alt="{{ $page->siteName }} large logo" class="mx-auto w-1/4 mb-6 lg:mb-0 ">
    </div>

    <hr class="block my-8 border lg:hidden">

    <div class="md:flex">
        <div class="mb-8 mx-3 px-2 md:w-1/3">
            <img src="/assets/img/icons8-program-100.png" class="h-16 w-16" alt="window icon">

            <h3 id="intro-laravel" class="text-2xl text-indigo-darkest mb-0">CRUD Builder</h3>

            <p>Membuat CRUD hanya dalam hitungan detik, lengkap dengan <i>full featured datatable</i> dan SPA-like navigation.</p>
        </div>

        <div class="mb-8 mx-3 px-2 md:w-1/3">
            <img src="/assets/img/icons8-template-100.png" class="h-16 w-16" alt="terminal icon">

            <h3 id="intro-markdown" class="text-2xl text-indigo-darkest mb-0">Unified Interface</h3>

            <p>Admin panel yang minimalis, ringan, dan elegan, didukung puluhan komponen siap pakai. Laravolt menyediakan standard UI sehingga Kamu bisa fokus pada UX.</p>
        </div>

        <div class="mx-3 px-2 md:w-1/3">
            <img src="/assets/img/icons8-module-100.png" class="h-16 w-16" alt="stack icon">

            <h3 id="intro-mix" class="text-2xl text-indigo-darkest mb-0">Plug n Play</h3>

            <p>Puluhan modul yang sudah teruji dan siap pakai. Bahkan, Kamu bisa membuat modulmu sendiri dan membaginya ke tim dengan mudah. <i>It's just work</i>.</p>
        </div>

        <div class="mx-3 px-2 md:w-1/3">
            <img src="/assets/img/icons8-workflow-100.png" class="h-16 w-16" alt="stack icon">

            <h3 id="intro-mix" class="text-2xl text-indigo-darkest mb-0">BPMN Integration</h3>

            <p>Ketika proses bisnis aplikasi tidak lagi sederhana, Laravolt menyediakan dukungan untuk BPMN <i>engine</i> seperti Camunda.</p>
        </div>
    </div>
</section>
@endsection
