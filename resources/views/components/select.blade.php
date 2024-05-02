<?php $target = "select-" . rand(); ?>

@props([
    "search" => "false",
])

<select
    {{
        $attributes->merge([
            "class" => "form-control",
        ])
    }}
    date-type="select-multiple"
    data-select="{{ $target }}"
>
    {{ $slot }}
</select>

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
