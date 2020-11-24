@extends('_layouts.master')

@section('nav-toggle')
    @include('_nav.menu-toggle')
@endsection

@section('body')
<section class="container max-w-5xl mx-auto px-6 md:px-8 py-4">
    <div class="flex flex-col lg:flex-row">
        <nav id="js-nav-menu" class="nav-menu hidden lg:block my-0 mr-6">
            @include('_nav.menu', ['items' => $page->navigation])
        </nav>

        <div class="documentation markdown w-full break-words pb-16 lg:pl-4" v-pre>
            {!! $page->content !!}
        </div>
    </div>
</section>
@endsection
