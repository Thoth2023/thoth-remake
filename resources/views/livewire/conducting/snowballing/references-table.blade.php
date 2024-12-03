<div>
    <h5>Referências Encontradas
        <small class="text-muted">
            (Backward: {{ $backwardCount }} / Forward: {{ $forwardCount }})
        </small>
    </h5>
    <ul class="list-group">
        <li class="list-group-item d-flex">
            <div class="w-10 pl-2"><b>ID</b></div>
            <div class="w-40 pl-2 pr-2"><b>Título</b></div>
            <div class="w-10 pl-2 pr-2"><b>Tipo</b></div>
            <div class="w-10 pl-2 pr-2"><b>Ano</b></div>
            <div class="w-15 pl-2 ms-auto"><b>Ação</b></div>
            <div class="w-15 pl-2 ms-auto"><b>Relevante</b></div>
        </li>
    </ul>

    <ul class="list-group list-group-flush">
        @foreach ($references as $reference)
            <li class="list-group-item d-flex row w-100 align-items-center">
                <div class="w-10 pl-2">{{ $reference->id }}</div>
                <div class="w-40">{{ $reference->title }}</div>
                <div class="w-10">{{ $reference->type_snowballing }}</div>
                <div class="w-10">{{ $reference->year }}</div>
                <div class="w-15 ms-auto">
                    {{-- Botão de DOI (se disponível) --}}
                    @if ($reference->doi)
                        <a
                            href="https://doi.org/{{ $reference->doi }}"
                            target="_blank"
                            class="btn btn-xs py-1 px-3 btn-outline-dark"
                            data-toggle="tooltip"
                            data-original-title="Doi">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            DOI
                        </a>
                    @endif

                    {{-- Botão de Google Scholar (exibe apenas se o título não for "Título desconhecido") --}}
                    @if ($reference->title !== 'unknown')
                        <a
                            href="https://scholar.google.com/scholar?q={{ urlencode($reference->title) }}"
                            target="_blank"
                            class="btn btn-xs py-1 px-3 btn-outline-primary"
                            data-toggle="tooltip"
                            data-original-title="Buscar no Google Scholar">
                            <i class="fa-solid fa-graduation-cap"></i>
                            G.Scholar
                        </a>
                    @endif
                </div>
                <div class="w-15 ms-auto">
                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="reference-{{ $reference->id }}"
                            wire:click="toggleRelevance({{ $reference->id }})"
                            {{ $reference->is_relevant ? 'checked' : '' }}>
                        <label class="form-check-label" for="reference-{{ $reference->id }}">
                            @if ($reference->is_relevant === 1)
                                Sim
                            @elseif ($reference->is_relevant === 0)
                                Não
                            @else
                                Não Avaliado
                            @endif
                        </label>
                    </div>

                </div>
            </li>
        @endforeach
    </ul>
</div>
