<?php $target = "select-" . rand(); ?>

@props([
    "sorted" => "false",
    "search" => "false",
    "label" => "",
    "defaultSelected" => "",
])

<div
    class="d-flex flex-column"
    x-init="() => {
        const select = document.querySelector('[data-ref=\'{{ $target }}\']');
        const hasSearch = {{ $search }};
        const isSorted = {{ $sorted }};

        const test = new Choices(select, {
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
        data-selected="{{ $defaultSelected }}"
        data-ref="{{ $target }}"
    >
        {{ $slot }}
    </select>
</div>
