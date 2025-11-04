{{-- ============================
     INFO DO PROJETO (PDF VIEW)
   ============================ --}}
<div class="card">

            {{-- Título do Projeto --}}
            <h4 class="text-uppercase text-break mb-2">{{ $project->title }}</h4>

            {{-- Descrição --}}
            <div class="mb-2">
                <strong>{{ __('project/public_protocol.description') }}:</strong><br>
                <span class="text-break">{{ $project->description }}</span>
            </div>

            {{-- Objetivos --}}
            <div class="mb-2">
                <strong>{{ __('project/public_protocol.objectives') }}:</strong><br>
                <span class="text-break">{{ $project->objectives }}</span>
            </div>

            {{-- Datas do Projeto --}}
            <div class="mb-2">
                    <strong>{{ __('project/public_protocol.start_date') }}:</strong>
                    <span class="text-break">{{ $project->start_date ?? '—' }}</span>
            </div>

            {{-- Data Final --}}
            <div class="mb-2">
                    <strong>{{ __('project/public_protocol.end_date') }}:</strong>
                    <span class="text-break">{{ $project->end_date ?? '—' }}</span>
            </div>

    {{-- Abordagem da Revisão / Feature Review --}}
    @php
        // Garante leitura seja string (alguns projetos antigos armazenaram array)
        $feature = is_array($project->feature_review)
            ? ($project->feature_review[0] ?? '')
            : $project->feature_review;

        // Tradução dinâmica
        $label = __('project/public_protocol.feature_review_options.' . $feature);

        // Fallback se o valor não existir na tradução
        if ($label === 'project/public_protocol.feature_review_options.' . $feature) {
            $label = $feature;
        }
    @endphp

    @if(!empty($feature))
            <div class="mb-2">
                <strong>{{ __('project/public_protocol.feature_review') }}:</strong><br>
                <span class="text-break">{{ $label }}</span>
            </div>
    @endif

</div>

