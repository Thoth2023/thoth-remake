<style>
    .protocol-box {
        background: #f9fafb;
        border: 1px solid #e3e6ea;
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 0.9rem;
    }

    .protocol-table {
        font-size: .82rem; /* menor */
        border: 1px solid #e3e6ea;
        border-radius: 8px;
        overflow: hidden;
    }

    .protocol-table thead {
        background: #f9fafb;
        font-weight: bold;
        color: #344767;
        border-bottom: 1px solid #e3e6ea;
    }

    .protocol-table td,
    .protocol-table th {
        padding: 6px 8px; /* menor padding */
        vertical-align: top;
        word-break: break-word;
        white-space: normal;
    }

    .protocol-table tbody tr:nth-child(odd) {
        background: #ffffff;
    }

    .protocol-table tbody tr:nth-child(even) {
        background: #f3f6fa;
    }

    .highlight-approval {
        background-color: #d1fae5;
        font-weight: bold;
    }
</style>



<div class="row g-3 mt-2">

    {{-- Quality Questions --}}
    <div class="col-12 col-md-8">
        <div class="protocol-box">
            <strong>{{ __('project/public_protocol.quality_questions') }}</strong>

            <div class="protocol-table mt-2">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('project/public_protocol.description') }}</th>
                        <th>{{ __('project/public_protocol.weight') }}</th>
                        <th>{{ __('project/public_protocol.min_approval') }}</th>
                        <th>{{ __('project/public_protocol.options_and_scores') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse(($questions ?? []) as $q)
                        <tr>
                            <td>{{ $q->id }}</td>
                            <td class="w-35 text-break text-small">{{ $q->description }}</td>
                            <td>{{ $q->weight }}</td>
                            <td>{{ $q->min_score_value ? $q->min_score_value.'%' : '—' }}</td>
                            <td class="text-break text-sm">
                                @foreach(($q->qualityScores ?? []) as $score)
                                    <div><strong>{{ $score->description }}</strong> — {{ $score->score }}%</div>
                                @endforeach
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">— {{ __('project/public_protocol.no_quality_questions') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Score Ranges --}}
    <div class="col-12 col-md-4">
        <div class="protocol-box">
            <strong>{{ __('project/public_protocol.general_score_ranges') }}</strong>

            <div class="protocol-table mt-2">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th>{{ __('project/public_protocol.min') }}</th>
                        <th>{{ __('project/public_protocol.max') }}</th>
                        <th>{{ __('project/public_protocol.category') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse(($ranges ?? []) as $r)
                        <tr @if($cutoff && $cutoff->id_general_score == $r->id_general_score) class="highlight-approval" @endif>
                            <td>{{ number_format($r->start, 2) }}</td>
                            <td>{{ number_format($r->end, 2) }}</td>
                            <td class="text-break text-small">{{ $r->description }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3">—</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($cutoff)
                <div class="mt-2 text-success fw-bold text-small">
                    {{ __('project/public_protocol.min_general_score_to_pass') }}:
                    {{ $ranges->firstWhere('id_general_score', $cutoff->id_general_score)?->description }}
                </div>
            @endif
        </div>
    </div>

</div>
