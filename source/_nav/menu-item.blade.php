<li class="lvl-{{ $level }} {{ $level == 0 ? 'mb-8' : '' }}">
    @if ($url = is_string($item) ? $item : $item->url)
        <a href="{{ $page->isUrl($url) ? $url : $page->link($url) }}"
           class="{{ 'lvl' . $level }} {{ $page->isActiveParent($item) ? 'lvl' . $level . '-active' : '' }} {{ $page->isActive($url) ? 'active' : '' }} nav-menu__item"
        >
            {{ $label }}
        </a>
    @else
        {{-- Menu item without URL--}}
        <h5 class="mb-1 px-2 text-indigo-500 uppercase tracking-wide font-bold text-base">{{ $label }}</h5>
    @endif

    @if (! is_string($item) && $item->children)
        {{-- Recursively handle children --}}
        @include('_nav.menu', ['items' => $item->children, 'level' => ++$level])
    @endif
</li>
