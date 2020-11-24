@php $level = $level ?? 0 @endphp

<ul>
    @foreach ($items as $label => $item)
        @include('_nav.menu-item')
    @endforeach
</ul>
