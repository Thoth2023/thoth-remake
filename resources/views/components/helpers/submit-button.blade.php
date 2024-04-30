@props([
    "isEditing" => "false",
])

<button
    type="submit"
    {{
        $attributes->merge([
            "class" => "d-flex gap-2 align-items-center btn " . ($isEditing ? "btn-secondary" : "btn-success"),
        ])
    }}
>
    <i class="fa {{ $isEditing ? "fa-edit" : "fa-plus" }}"></i>
    {{ $slot }}
</button>
