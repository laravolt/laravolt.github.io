<form class="relative hidden lg:block">
    <label>
        <select onchange="window.location = this.options[this.selectedIndex].value"
                class="appearance-none block bg-transparent pr-7 py-1 text-gray-500 font-medium text-sm focus:outline-none focus:text-gray-900 transition-colors duration-200">
            @foreach($page->versions as $version => $label)
                <option
                    @if($version == $page->selectedVersion()) selected @endif
                    value="{{ $page->baseUrl . "/docs/" . $version }}">{{ $label }}
                </option>
            @endforeach
        </select>
        <svg class="w-5 h-5 text-gray-400 absolute top-1/2 right-0 -mt-2.5 pointer-events-none" fill="currentColor">
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"></path>
        </svg>
    </label>
</form>

@push('scripts')
    <script>

    </script>
@endpush
