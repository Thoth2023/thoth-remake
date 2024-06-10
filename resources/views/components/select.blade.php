<?php $target = "select-" . rand(); ?>

@props([
    "sorted" => "false",
    "search" => "false",
    "label" => "",
])

<div
    class="d-flex flex-column"
    x-init="() => {
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
    }"
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
