<div>
    <h5>{{ __('project/conducting.snowballing.table.references-found') }}
        <small class="text-muted">
            ({{ __('project/conducting.snowballing.table.backward') }}: {{ $backwardCount }} /
            {{ __('project/conducting.snowballing.table.forward') }}: {{ $forwardCount }})
        </small>
    </h5>

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

    <ul class="list-group list-group-flush">
        @foreach ($references as $reference)
            @php
                $type = strtolower($reference->type_snowballing ?? '');
                $badgeClass = match ($type) {
                    'backward' => 'bg-info',
                    'forward'  => 'bg-dark',
                    default    => 'bg-primary',
                };
            @endphp

            <li class="list-group-item d-flex row w-100 align-items-center">
                <div class="w-8 pl-2">{{ $reference->id }}</div>

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

                <div class="w-10">
                    <span class="badge {{ $badgeClass }}">{{ ucfirst($reference->type_snowballing ?? __('project/conducting.snowballing.table.none')) }}</span>
                </div>

                <div class="w-7">{{ $reference->year ?? __('project/conducting.snowballing.table.none') }}</div>

                <div class="w-10">
                    @if (!is_null($reference->relevance_score))
                        <span class="badge bg-light text-dark">{{ number_format($reference->relevance_score, 3) }}</span>
                    @else
                        <span class="text-muted">{{ __('project/conducting.snowballing.table.none') }}</span>
                    @endif
                </div>

                <div class="w-5">{{ $reference->duplicate_count ?? 1 }}</div>

                <div class="w-15">
                    <span title="{{ $reference->source }}">{{ $reference->source }}</span>
                </div>

                <div class="w-10">
                    <div class="form-check form-switch d-inline-block ms-2">
                        <input
                            type="checkbox"
                            class="form-check-input"
                            id="ref-{{ $reference->id }}"
                            wire:click="toggleRelevance({{ $reference->id }})"
                            {{ $reference->is_relevant ? 'checked' : '' }}>
                        <label class="form-check-label" for="ref-{{ $reference->id }}"></label>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
