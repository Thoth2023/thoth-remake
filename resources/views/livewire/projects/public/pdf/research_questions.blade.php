{{-- QUESTÕES DE PESQUISA --}}
<h6 class="mb-2 text-uppercase" id="toc-rq">{{ __('project/public_protocol.research_questions') }}</h6>
@if(($researchQuestions ?? collect())->count())
    <table class="table">
        <thead>
        <tr>
            <th style="width:60px">#</th>
            <th>{{ __('project/public_protocol.description') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($researchQuestions as $rq)
            <tr>
                <td>{{ $rq->id }}</td>
                <td class="text-break">{{ $rq->description }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <div class="small text-muted">— {{ __('project/public_protocol.no_research_questions_defined') }}</div>
@endif
