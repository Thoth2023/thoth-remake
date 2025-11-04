{{-- AVALIAÇÃO DE QUALIDADE --}}
<div class="row">
<h6 class="mb-2 text-uppercase" id="toc-quality">{{ __('project/public_protocol.quality_assessment') }}</h6>
</div>
<div class="row">
    <div class="col-12">
        <div class="protocol-box">
            <strong>{{ __('project/public_protocol.quality_questions') }}</strong>
            <table class="table mt-2">
                <thead>
                <tr>
                    <th style="width:40px">#</th>
                    <th style="width:30%">{{ __('project/public_protocol.description') }}</th>
                    <th style="width:50px">{{ __('project/public_protocol.weight') }}</th>
                    <th style="width:60px">{{ __('project/public_protocol.min_approval') }}</th>
                    <th style="width:150px">{{ __('project/public_protocol.options_and_scores') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($qualityQuestions as $q)
                    <tr>
                        <td>{{ $q->id }}</td>
                        <td class="text-break">{{ $q->description }}</td>
                        <td>{{ $q->weight }}</td>
                        <td>{{ $q->min_score_value ? $q->min_score_value.'%' : ($q->min_to_app ? $q->min_to_app.'%' : '—') }}</td>
                        <td class="text-break">
                            @foreach(($q->qualityScores ?? []) as $s)
                                <div><strong>{{ $s->description }}</strong> — {{ $s->score }}%</div>
                            @endforeach
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">— {{ __('project/public_protocol.no_quality_questions') }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="protocol-box">
            <strong>{{ __('project/public_protocol.general_score_ranges') }}</strong>
            <table class="table mt-2">
                <thead>
                <tr>
                    <th>{{ __('project/public_protocol.min') }}</th>
                    <th>{{ __('project/public_protocol.max') }}</th>
                    <th>{{ __('project/public_protocol.category') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($qualityRanges as $r)
                    <tr @if($qualityCutoff && $qualityCutoff->id_general_score == $r->id_general_score) class="highlight-approval" @endif>
                        <td>{{ number_format($r->start,2) }}</td>
                        <td>{{ number_format($r->end,2) }}</td>
                        <td class="text-break">{{ $r->description }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3">—</td></tr>
                @endforelse
                </tbody>
            </table>

            @if($qualityCutoff)
                <div class="small" style="color:#107569;font-weight:700">
                    {{ __('project/public_protocol.min_general_score_to_pass') }}:
                    {{ optional($qualityRanges->firstWhere('id_general_score',$qualityCutoff->id_general_score))->description }}
                </div>
            @endif
        </div>
    </div>
</div>
