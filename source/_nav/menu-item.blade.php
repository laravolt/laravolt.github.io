<li class="lvl-{{ $level }} {{ $level == 0 ? 'mb-8' : '' }}">
    @if ($url = is_string($item) ? $item : $item->url)
        {{-- Menu item with URL--}}
        <a href="{{ $page->url($url) }}"
            class="{{ 'lvl' . $level }} {{ $page->isActiveParent($item) ? 'lvl' . $level . '-active' : '' }} {{ $page->isActive($url) ? 'active bg-indigo-100' : '' }} nav-menu__item block text-gray-900 py-1 px-2 hover:text-indigo"
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
