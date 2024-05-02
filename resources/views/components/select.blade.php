<?php $target = "select-" . rand(); ?>

@props([
    "search" => "false",
    "label" => "",
])

<div class="d-flex flex-column">
    <label class="form-control-label mx-0 mb-1" for="{{ $target }}">
        {{ $label }}
    </label>
    <select
        id="{{ $target }}"
        {{
            $attributes->merge([
                "class" => "form-control",
            ])
        }}
        data-select="{{ $target }}"
    >
        {{ $slot }}
    </select>
</div>

<script>
    const select = document.querySelector('[data-select="{{ $target }}"]');
    const hasSearch = {{ $search }};

    new Choices(select, {
        noResultsText: 'Nenhum resultado encontrado',
        noChoicesText: 'Nenhuma opção selecionada',
        itemSelectText: 'Clique para selecionar',
        searchEnabled: hasSearch,
    });
</script>
