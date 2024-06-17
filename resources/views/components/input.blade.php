<?php $randomId = rand(); ?>

@props([
    "id" => "input-{{ $randomId }}",
    "label" => "",
    "size" => "auto",
])

<div class="d-flex flex-column flex-shrink">
    <label for="{{ $id }}" class="form-control-label mx-0 mb-1">
        {{ $label }}
    </label>
    <input
        id="{{ $id }}"
        style="width: {{ $size }}"
        {{ $attributes->merge(["class" => "form-control", "type" => "text"]) }}
    />
</div>
