@props([
    "target",
    "isTable" => false,
])

<input
    type="text"
    {{ $attributes->merge(["class" => "form-control search-input"]) }}
    data-target="{{ $target }}"
    data-is-table="{{ $isTable }}"
    placeholder="Search..."
/>
