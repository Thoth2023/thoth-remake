@props([
    "target",
])

<span data-empty="{{ $target }}" style="display: none" {{ $attributes() }}>
    {{ $slot }}
</span>
