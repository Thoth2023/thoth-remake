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
            noResultsText: 'No results found',
            noChoicesText: 'No choices available',
            itemSelectText: 'Click to select',
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
