@props([
    "target",
])

<div data-item="{{ $target }}" {{ $attributes() }}>
    {{ $slot }}
</div>
