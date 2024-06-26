<?php $randomId = rand(); ?>

@props([
    "id" => "input-{{ $randomId }}",
    "label" => "",
    "required" => false,
    "disabled" => false,
])

<div class="d-flex flex-column flex-shrink">
    <label
        for="{{ $id }}"
        class="form-control-label mx-0 mb-1 {{ $required ? "required" : "" }}"
    >
        {{ $label }}
    </label>
    <input
        id="{{ $id }}"
        {{
            $attributes->merge([
                "class" => "form-control",
                "type" => "text",
            ])
        }}
        {{ $disabled ? "disabled" : "" }}
    />
</div>
