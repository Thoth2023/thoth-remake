@props([
    "isEditing" => false,
    "fitContent" => false,
])

<button
    type="submit"
    {{
        $attributes->merge([
            "class" => "d-flex gap-2 align-items-center btn " . ($isEditing ? "btn-secondary" : "btn-success"),
            "style" => $fitContent ? "max-width: fit-content;" : "",
        ])
    }}
>
    <i
        wire:loading.remove
        class="fa {{ $isEditing ? "fa-edit" : "fa-plus" }}"
    ></i>
    {{ $slot }}
</button>
