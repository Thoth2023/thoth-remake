{{-- CRITÉRIOS --}}
<div class="row">
    <br/>
<h6 class="mb-2 text-uppercase" id="toc-criteria">{{ __('project/public_protocol.criteria') }}</h6>
</div>
@php
    // Normaliza para minúsculo antes de filtrar
    $inc = ($criteria ?? collect())->filter(fn($c) => strtolower($c->type) === 'inclusion');
    $exc = ($criteria ?? collect())->filter(fn($c) => strtolower($c->type) === 'exclusion');
@endphp

@if(($criteria ?? collect())->isEmpty())
    <div class="small text-muted">{{ __('project/public_protocol.no_criteria') }}</div>
@else
    <table class="table">
        <thead>
        <tr>
            <th style="width:60px">#</th>
            <th>{{ __('project/public_protocol.description') }}</th>
            <th style="width:120px" class="text-center">{{ __('project/public_protocol.type') }}</th>
            <th style="width:90px" class="text-center">{{ __('project/public_protocol.rule') }}</th>
        </tr>
        </thead>
        <tbody>

        {{-- INCLUSION --}}
        @foreach($inc as $c)
            <tr>
                <td>{{ $c->id_criteria ?? $c->id }}</td>
                <td class="text-break">{{ $c->description }}</td>
                <td class="text-success text-center">{{ __('project/public_protocol.inclusion') }}</td>
                <td class="text-center">{{ strtoupper($c->rule ?? 'ALL') }}</td>
            </tr>
        @endforeach

        {{-- EXCLUSION --}}
        @foreach($exc as $c)
            <tr>
                <td>{{ $c->id_criteria ?? $c->id }}</td>
                <td class="text-break">{{ $c->description }}</td>
                <td class="text-danger text-center">{{ __('project/public_protocol.exclusion') }}</td>
                <td class="text-center">{{ strtoupper($c->rule ?? 'ANY') }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endif
