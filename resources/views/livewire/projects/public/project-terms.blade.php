<div class="row g-3 mt-3">

    {{-- Coluna Termos & Sinônimos --}}
    <div class="col-12 col-lg-6">
        <h6 class="text-uppercase mb-2">{{ __('project/public_protocol.terms_synonyms') }}</h6>

        <div class="protocol-box p-0">

            @if($terms->count())
                <div class="table-responsive mt-0">
                    <table class="table table-striped align-items-center mb-0">
                        <thead class="bg-light">
                        <tr>
                            <th class="text-muted small" style="width: 30%">
                                {{ __('project/public_protocol.term') }}
                            </th>
                            <th class="text-muted small">
                                {{ __('project/public_protocol.synonyms') }}
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($terms as $term)
                            <tr>
                                <td class="fw-bold criteria-wrap">
                                    {{ $term->description }}
                                </td>
                                <td class="criteria-wrap">
                                    @if($term->synonyms->count())
                                        @foreach($term->synonyms as $syn)
                                            <span class="d-block text-wrap">{{ $syn->description }}@if(!$loop->last);@endif</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted small">
                                    {{ __('project/public_protocol.no_terms') }}
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            @else
                <p class="text-muted small m-2">{{ __('project/public_protocol.no_terms') }}</p>
            @endif

        </div>

    </div>

    {{-- Coluna String Genérica --}}
    <div class="col-12 col-lg-6">
        <h6 class="text-uppercase mb-2">{{ __('project/public_protocol.generic_search_string') }}</h6>

        <div class="protocol-box">
            @if(!empty($genericString))
                <div class="text-wrap">{{ $genericString }}</div>
            @else
                <p class="text-muted small">{{ __('project/public_protocol.no_generic_string') }}</p>
            @endif
        </div>
    </div>

</div>
