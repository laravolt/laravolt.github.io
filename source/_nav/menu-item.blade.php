<li class="list-reset lvl-{{ $level }}">
    @if ($url = is_string($item) ? $item : $item->url)
        {{-- Menu item with URL--}}
        <a href="{{ $page->url($url) }}"
            class="{{ 'lvl' . $level }} {{ $page->isActiveParent($item) ? 'lvl' . $level . '-active' : '' }} {{ $page->isActive($url) ? 'active bg-indigo-100' : '' }} nav-menu__item hover:text-indigo"
        >
            {{ $label }}
        </a>
    @else
        {{-- Menu item without URL--}}
        <h5 class="mb-3 lg:mb-2 px-2 text-indigo-500 uppercase tracking-wide font-bold text-sm lg:text-xs">{{ $label }}</h5>
    @endif

    @if (! is_string($item) && $item->children)
        {{-- Recursively handle children --}}
        @include('_nav.menu', ['items' => $item->children, 'level' => ++$level])
    @endif
</li>
