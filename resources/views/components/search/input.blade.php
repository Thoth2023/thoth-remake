@props([
    "target",
])

<input
    type="text"
    {{ $attributes->merge(["class" => "form-control search-input"]) }}
    data-target="{{ $target }}"
    placeholder="Search..."
/>
