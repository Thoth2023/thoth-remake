<div>

    {{-- Botão DOI --}}
    @if(!empty($doi))
        @php
            // Se o DOI já contiver "http", usar direto. Caso contrário, montar o link completo
            $doiLink = str_contains($doi, 'http') ? $doi : 'https://doi.org/' . ltrim($doi);
        @endphp

        <a class="btn py-1 px-3 btn-outline-dark"
           data-toggle="tooltip"
           data-original-title="DOI"
           href="{{ $doiLink }}"
           target="_blank">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            DOI
        </a>
    @endif

    {{-- Botão URL --}}
    @php
        // Se a URL estiver vazia, usar o link do DOI (se existir)
        $urlLink = !empty($url)
            ? $url
            : (!empty($doi) ? (str_contains($doi, 'http') ? $doi : 'https://doi.org/' . ltrim($doi)) : null);
    @endphp

    @if(!empty($urlLink))
        <a class="btn py-1 px-3 btn-outline-success"
           data-toggle="tooltip"
           data-original-title="URL"
           href="{{ $urlLink }}"
           target="_blank">
            <i class="fa-solid fa-link"></i>
            URL
        </a>
    @endif

</div>

@script
<script>
    $wire.on('paper-doi-url', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
