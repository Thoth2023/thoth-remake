{{-- ESTRATÉGIA DE BUSCA --}}
<h6 class="mb-2 text-uppercase" id="toc-search">{{ __('project/public_protocol.search_strategy') }}</h6>
@if(!empty($searchStrategy?->description))
    <div class="protocol-box">
        <div class="protocol-text">
            {!! nl2br(strip_tags($searchStrategy->description, '<p><br><b><strong><i><em><ul><ol><li>')) !!}
        </div>
    </div>
@else
    <div class="small text-muted">— {{ __('project/public_protocol.no_search_strategy') }}</div>
@endif
