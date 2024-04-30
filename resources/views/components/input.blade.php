@props([
    "id",
    "label" => "",
])

<div class="d-flex flex-column">
    <label for="{{ $id }}" class="form-control-label mx-0 mb-1">
        {{ $label }}
    </label>
    <input
        id="{{ $id }}"
        class="form-control"
        type="text"
        {{ $attributes->merge(["class" => "form-control"]) }}
    />
</div>
