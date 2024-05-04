<?php $randomId = rand(); ?>

@props([
    "id" => "input-{{ $randomId }}",
    "label" => "",
])

<div class="d-flex flex-column">
    <label for="{{ $id }}" class="form-control-label mx-0 mb-1">
        {{ $label }}
    </label>
    <input
        id="{{ $id }}"
        {{ $attributes->merge(["class" => "form-control", "type" => "text"]) }}
    />
</div>
