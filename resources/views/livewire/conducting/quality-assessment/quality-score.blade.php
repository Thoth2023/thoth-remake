{{-- Última atualização realizada por Luiza Velasque em abril/2025
     Alteração: melhoria na exibição da pontuação de qualidade com comentários explicativos --}}

     <div class="d-flex gap-1 mb-3">
    {{-- Exibe o status da avaliação do artigo --}}
    <b>{{ __('project/conducting.quality-assessment.modal.status-quality' ) }}: </b>
    <b class="{{ 'text-' . strtolower($status_paper) }}">
        {{ __("project/conducting.quality-assessment.status." . strtolower($status_paper)) }}
    </b>
    |

    {{-- Exibe o score (pontuação) da avaliação de qualidade --}}
    <b>{{ __('project/conducting.quality-assessment.modal.quality-score' ) }}: </b>
    <b class="{{ 'text-' . strtolower($status_paper) }}">
        {{-- Substituição por input numérico interativo --}}
        <input
            type="number"
            class="form-control d-inline w-auto"
            step="0.1"
            min="0"
            max="10"
            wire:model="score"
            style="width: 60px;"
        />
        {{-- Fallback para N/A caso o valor não esteja definido --}}
        {{ $score ?? 'N/A' }}
    </b>
    |
    {{-- Exibe a descrição da avaliação de qualidade --}}
    <b>{{ __('project/conducting.quality-assessment.modal.quality-description' ) }}: </b>
    <b class="{{ 'text-' . strtolower($status_paper) }}">
        {{ $quality_description }}
    </b>
</div>

@script
<script>
    // Escuta eventos Livewire e exibe notificações (toasty)
    $wire.on('quality-score', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
