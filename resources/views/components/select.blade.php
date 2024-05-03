<?php $target = "select-" . rand(); ?>

@props([
    "sorted" => "false",
    "search" => "false",
    "label" => "",
])

<div
    wire:ignore
    class="d-flex flex-column"
>
    <label class="form-control-label mx-0 mb-1" for="{{ $target }}">
        {{ $label }}
    </label>
    <select
        {{
            $attributes->merge([
                "class" => "form-control",
            ])
        }}
        data-ref="{{ $target }}"
    >
        {{ $slot }}
    </select>
</div>

@push("scripts")
    <script>
        const select = document.querySelector('[data-ref=\'{{ $target }}\']');
        const hasSearch = {{ $search }};
        const isSorted = {{ $sorted }};

        new Choices(select, {
            noResultsText: 'Nenhum resultado encontrado',
            noChoicesText: 'Nenhuma opção selecionada',
            itemSelectText: 'Clique para selecionar',
            searchEnabled: hasSearch,
            shouldSort: isSorted,
        });
    </script>
@endpush
