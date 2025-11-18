<div>
    <h5>{{ __('project/conducting.snowballing.references.relevant-children') }}
        <small class="text-muted">
            ({{ $references->where('type_snowballing', 'backward')->count() }} {{ __('project/conducting.snowballing.table.backward') }} /
            {{ $references->where('type_snowballing', 'forward')->count() }} {{ __('project/conducting.snowballing.table.forward') }})
        </small>
    </h5>

    {{-- Cabeçalho da tabela --}}
    <ul class="list-group">
        <li class="list-group-item d-flex">
            <div class="w-8 pl-2"><b>{{ __('project/conducting.snowballing.table.id') }}</b></div>
            <div class="w-35 pl-2"><b>{{ __('project/conducting.snowballing.table.title') }} / {{ __('project/conducting.snowballing.modal.author') }}</b></div>
            <div class="w-10"><b>{{ __('project/conducting.snowballing.table.type') }}</b></div>
            <div class="w-7"><b>{{ __('project/conducting.snowballing.table.year') }}</b></div>
            <div class="w-10"><b>{{ __('project/conducting.snowballing.table.score') }}</b></div>
            <div class="w-5"><b>{{ __('project/conducting.snowballing.table.occurrences') }}</b></div>
            <div class="w-15"><b>{{ __('project/conducting.snowballing.table.source') }}</b></div>
            <div class="w-10"><b>{{ __('project/conducting.snowballing.table.relevant') }}</b></div>
        </li>
    </ul>

    {{-- Lista dos itens --}}
    <ul class="list-group list-group-flush">

        @forelse ($references as $reference)
            @php
                $type = strtolower($reference->type_snowballing ?? '');
                $badgeClass = match ($type) {
                    'backward' => 'bg-info',
                    'forward'  => 'bg-dark',
                    default    => 'bg-primary',
                };
            @endphp

            <li class="list-group-item d-flex row w-100 align-items-center">

                {{-- ID --}}
                <div class="w-8 pl-2">{{ $reference->id }}</div>

                {{-- Título / Autores + botões --}}
                <div class="w-35 text-wrap small" style="word-break: break-word;">
                    <div class="fw-semibold" style="font-size: 0.85rem;">
                        <b>{{ $reference->title ?? __('project/conducting.snowballing.table.unknown-title') }}</b>
                    </div>

                    @if(!empty($reference->authors))
                        <div class="text-muted fst-italic" style="font-size: 0.75rem;">
                            {{ $reference->authors }}
                        </div>
                    @endif

                    <div class="d-flex flex-wrap gap-1 mt-1">
                        @if(!is_null($reference->depth))
                            <span class="btn btn-secondary btn-sm py-0 px-2 disabled"
                                  style="pointer-events:none; opacity:1;">
                                {{ __('project/conducting.snowballing.depth') }} {{ $reference->depth }}
                            </span>
                        @endif
                        @if ($reference->doi)
                            <a href="https://doi.org/{{ $reference->doi }}"
                               target="_blank"
                               class="btn btn-outline-dark btn-sm py-0 px-2">
                                {{ __('project/conducting.snowballing.buttons.doi') }}
                            </a>
                        @endif

                        @if ($reference->title && $reference->title !== 'unknown')
                            <a href="https://scholar.google.com/scholar?q={{ urlencode($reference->title) }}"
                               target="_blank"
                               class="btn btn-outline-primary btn-sm py-0 px-2">
                                {{ __('project/conducting.snowballing.buttons.scholar') }}
                            </a>
                        @endif

                        @if ($reference->url)
                            <a href="{{ $reference->url }}"
                               target="_blank"
                               class="btn btn-outline-success btn-sm py-0 px-2">
                                {{ __('project/conducting.snowballing.buttons.url') }}
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Tipo --}}
                <div class="w-10">
                    <span class="badge {{ $badgeClass }}">
                        {{ ucfirst($reference->type_snowballing ?? __('project/conducting.snowballing.table.none')) }}
                    </span>
                </div>

                {{-- Ano --}}
                <div class="w-7">
                    {{ $reference->year ?? __('project/conducting.snowballing.table.none') }}
                </div>

                {{-- Score --}}
                <div class="w-10">
                    @if (!is_null($reference->relevance_score))
                        <span class="badge bg-light text-dark">
                            {{ number_format($reference->relevance_score, 3) }}
                        </span>
                    @else
                        <span class="text-muted">{{ __('project/conducting.snowballing.table.none') }}</span>
                    @endif
                </div>

                {{-- Ocorrências --}}
                <div class="w-5">{{ $reference->duplicate_count ?? 1 }}</div>

                {{-- Fonte --}}
                <div class="w-15">
                    <span title="{{ $reference->source }}">{{ $reference->source }}</span>
                </div>

                {{-- Toggle Relevante --}}
                <div class="w-10">
                    <div class="form-check form-switch d-inline-block ms-2">
                        <input
                            type="checkbox"
                            class="form-check-input"
                            id="ref-rel-{{ $reference->id }}"
                            wire:click="toggleRelevance({{ $reference->id }})"
                            {{ $reference->is_relevant ? 'checked' : '' }}>
                        <label class="form-check-label" for="ref-rel-{{ $reference->id }}"></label>
                    </div>
                </div>
            </li>

        @empty
            <li class="list-group-item text-center text-muted">
                {{ __('project/conducting.snowballing.references.none') }}
            </li>
        @endforelse

    </ul>
</div>
