<div>
    <h5>Referências Encontradas</h5>
    <ul class="list-group">
        <li class="list-group-item d-flex">
            <div class="w-10 pl-2"><b>ID</b></div>
            <div class="w-50 pl-2 pr-2"><b>Título</b></div>
            <div class="w-20 pl-2 ms-auto"><b>Ação</b></div>
            <div class="w-20 pl-2 ms-auto"><b>Relevante</b></div>
        </li>
    </ul>

    <ul class="list-group list-group-flush">
        @foreach ($references as $reference)
            <li class="list-group-item d-flex row w-100 align-items-center">
                <div class="w-10 pl-2">{{ $reference->id }}</div>
                <div class="w-50">{{ $reference->title }}</div>
                <div class="w-20 ms-auto">
                    @if ($reference->doi)
                        <a href="https://doi.org/{{ $reference->doi }}" target="_blank" class="btn btn-primary btn-sm">Ver Paper</a>
                    @else
                        <button class="btn btn-secondary btn-sm" disabled>Sem DOI</button>
                    @endif
                </div>
                <div class="w-20 ms-auto">
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
