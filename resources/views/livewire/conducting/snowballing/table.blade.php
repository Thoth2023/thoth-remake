<div>
    <br/>
    <div class="row mb-3">
        <div class="col-4">
            <x-search.input
                class="form-control"
                target="search-papers"
                wire:model.debounce.500ms="search"
                placeholder="{{ __('project/conducting.snowballing.buttons.search-papers')}}"
            />
        </div>
        <div class="col-8 text-end">
            @livewire('conducting.snowballing.buttons')
        </div>
    </div>

    {{-- Cabeçalho da tabela --}}
    <ul class="list-group">
        <li class="list-group-item d-flex">
            <div class="w-7 pl-2"><b>#</b></div>
            <div class="w-50 pl-2"><b>{{ __('project/conducting.snowballing.table.title') }}</b></div>
            <div class="w-20"><b>{{ __('project/conducting.snowballing.table.source') }}</b></div>
            <div class="w-7 "><b>{{ __('project/conducting.snowballing.table.year') }}</b></div>
            <div class="w-15 text-center"><b>{{ __('project/conducting.snowballing.table.status') }}</b></div>
        </li>
    </ul>

    @livewire('conducting.snowballing.paper-modal')
    @livewire('conducting.snowballing.paper-modal-relevant')

    {{-- Lista de papers --}}
    <ul class="list-group list-group-flush">
        @forelse ($papers as $paper)
            <li class="list-group-item">
                <div class="d-flex align-items-start">
                    <div class="w-7"><strong>{{ $paper->id_paper }}</strong></div>

                    {{-- Coluna principal (título e autores) --}}
                    <div class="w-50">
                        <div role="button" wire:click.prevent="openPaper({{ $paper }})" class="cursor-pointer">
                            <span class="fw-bold text-secondary d-flex align-items-center" data-search>
                                <i class="fa-solid fa-up-right-from-square me-2 text-muted" style="font-size: 0.85rem;"></i>
                                {{ $paper->title }}
                            </span>

                            @if($paper->authors)
                                <div class="text-muted small fst-italic">{{ $paper->authors }}</div>
                            @endif
                        </div>
                    </div>

                    {{-- Fonte --}}
                    <div class="w-20 text-muted small">{{ $paper->database_name }}</div>

                    {{-- Ano --}}
                    <div class="w-7 ">{{ $paper->year }}</div>

                    {{-- Status --}}
                    <div class="w-15 text-center">
                        <b class="{{ 'text-' . strtolower($paper->status_description) }}">
                            {{ __("project/conducting.snowballing.status." . strtolower($paper->status_description)) }}
                        </b>
                        <div class="small text-muted">Paper Base</div>

                        @if($paper->peer_review_accepted)
                            <i class="fa-solid fa-users text-secondary"
                               title="{{ __('project/conducting.quality-assessment.resolve.resolved-decision') }}"></i>
                        @endif
                    </div>
                </div>

                {{-- Referências relevantes (filhas) --}}
                @if($paper->relevant_children->isNotEmpty())
                    <div class="mt-3 ms-5">
                        <details>
                            <summary class="fw-semibold text-primary">
                                {{ __('project/conducting.snowballing.references.relevant') }}
                                ({{ $paper->relevant_children->count() }})
                            </summary>

                            <ul class="list-group mt-2">
                                @foreach($paper->relevant_children as $ref)
                                    <li class="list-group-item py-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="me-3">
                                                {{-- Título + Badge Snowballing Process --}}
                                                <div class="fw-semibold d-flex align-items-center flex-wrap gap-2">
                                                    <b>{{ $ref->title ?? 'Sem título' }}</b>

                                                    @if($ref->snowballing_process)
                                            <span class="badge bg-secondary small px-3 py-1"><b>{{ $ref->snowballing_process }}</b></span>
                                                    @endif
                                                </div>

                                                {{-- Autores --}}
                                                <div class="text-muted small fst-italic">
                                                    {{ $ref->authors }}
                                                </div>

                                                {{-- Score da referência --}}
                                                @if(!is_null($ref->relevance_score))
                                                    <span class="ms-2 text-muted small">
                                                                <i class="fa-solid fa-star text-warning"></i>
                                                                {{ __('project/conducting.snowballing.table.score') }}
                                                                <strong>{{ number_format($ref->relevance_score, 2) }}</strong>
                                                            </span>
                                                @endif

                                                {{-- Botões DOI / URL / Scholar --}}
                                                <div class="mt-2 d-flex flex-wrap gap-2 align-items-center">
                                                    @if($ref->doi)
                                                        <a class="btn py-1 px-3 btn-outline-dark"
                                                           href="https://doi.org/{{ $ref->doi }}"
                                                           target="_blank">
                                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                                            {{ __('project/conducting.snowballing.buttons.doi') }}
                                                        </a>
                                                    @endif

                                                    @if($ref->url)
                                                        <a class="btn py-1 px-3 btn-outline-success"
                                                           href="{{ $ref->url }}"
                                                           target="_blank">
                                                            <i class="fa-solid fa-link"></i>
                                                            {{ __('project/conducting.snowballing.buttons.url') }}
                                                        </a>
                                                    @endif

                                                    <a class="btn py-1 px-3 btn-outline-primary"
                                                       href="https://scholar.google.com/scholar?q={{ urlencode($ref->title ?? '') }}"
                                                       target="_blank">
                                                        <i class="fa-solid fa-graduation-cap"></i>
                                                        {{ __('project/conducting.snowballing.buttons.scholar') }}
                                                    </a>


                                                </div>
                                            </div>

                                            {{-- Botão Ver Paper --}}
                                            <div class="text-end">
                                                <button wire:click.prevent="openPaperRelevant({{ $ref }})"
                                                        class="btn btn-dark px-3 py-1">
                                                    <i class="fa-solid fa-eye"></i>
                                                    {{ __('project/conducting.snowballing.buttons.view-paper') }}
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </details>
                    </div>
                @endif

            </li>
        @empty
            <x-helpers.description>
                {{ __("project/conducting.snowballing.papers.empty") }}
            </x-helpers.description>
        @endforelse
    </ul>

    {{-- Filtros e paginação --}}
    <div class="mt-3 d-flex justify-content-end">
        <div class="d-flex align-items-center">
            <span class="me-2">{{ __('project/conducting.snowballing.buttons.filter-by') }}</span>
            <select class="form-select me-2" wire:model="selectedStatus" style="width: 250px;">
                <option value="">{{ __('project/conducting.snowballing.buttons.select-status') }}</option>
                @foreach($statuses as $id => $description)
                    <option value="{{ $id }}">{{ __("project/conducting.snowballing.status." . strtolower($description)) }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary" wire:click="applyFilters">
                {{ __('project/conducting.snowballing.buttons.filter') }}
            </button>
        </div>
    </div>

    <br/>
    {{ $papers->links() }}
</div>

@script
<script>
    $wire.on('table', ([{ message, type }]) => toasty({ message, type }));
</script>
@endscript
