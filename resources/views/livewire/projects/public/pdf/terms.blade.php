{{-- TERMOS & STRING GENÉRICA --}}
<div class="row">
    <div class="col-12">
        <h6 class="mb-2 text-uppercase" id="toc-terms">{{ __('project/public_protocol.terms_synonyms') }}</h6>
        <div class="protocol-box p-0">
            @php $terms = $project->terms()->with('synonyms')->get(); @endphp
            @if($terms->count())
                <table class="table">
                    <thead>
                    <tr>
                        <th style="width:30%">{{ __('project/public_protocol.term') }}</th>
                        <th>{{ __('project/public_protocol.synonyms') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($terms as $t)
                        <tr>
                            <td class="text-break">{{ $t->description }}</td>
                            <td class="text-break">
                                @if($t->synonyms->count())
                                    @foreach($t->synonyms as $s)
                                        <span>{{ $s->description }}@if(!$loop->last); @endif</span>
                                    @endforeach
                                @else — @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="small text-muted p-2">{{ __('project/public_protocol.no_terms') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <h6 class="mb-2 text-uppercase" id="toc-generic">{{ __('project/public_protocol.generic_search_string') }}</h6>
        <div class="protocol-box">
            @if(!empty($project->generic_search_string))
                <div class="text-break">{{ $project->generic_search_string }}</div>
            @else
                <div class="small text-muted">{{ __('project/public_protocol.no_generic_string') }}</div>
            @endif
        </div>
    </div>
</div>
