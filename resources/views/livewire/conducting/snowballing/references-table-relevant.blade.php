<div>
    <h5 class="text-primary">
        {{ __('project/conducting.snowballing.references.relevant-children') }}
        <small class="text-muted">({{ count($references) }})</small>
    </h5>

    <ul class="list-group list-group-flush mt-2">
        @forelse($references as $reference)
            <li class="list-group-item">
                <div class="fw-semibold">{{ $reference->title ?? 'Sem título' }}</div>
                <div class="text-muted fst-italic small">{{ $reference->authors }}</div>

                <div class="mt-2 d-flex flex-wrap gap-2 justify-content-between align-items-center">
                    <div>
                        @if($reference->doi)
                            <a class="btn py-1 px-3 btn-outline-dark" href="https://doi.org/{{ $reference->doi }}" target="_blank">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i> DOI
                            </a>
                        @endif
                        @if($reference->url)
                            <a class="btn py-1 px-3 btn-outline-success" href="{{ $reference->url }}" target="_blank">
                                <i class="fa-solid fa-link"></i> URL
                            </a>
                        @endif
                        <a class="btn py-1 px-3 btn-outline-primary"
                           href="https://scholar.google.com/scholar?q={{ urlencode($reference->title) }}"
                           target="_blank">
                            <i class="fa-solid fa-graduation-cap"></i> Scholar
                        </a>
                    </div>
                    <div class="text-muted small">{{ $reference->year }}</div>
                </div>
            </li>
        @empty
            <li class="list-group-item text-center text-muted">
                {{ __('project/conducting.snowballing.references.none') }}
            </li>
        @endforelse
    </ul>
</div>
