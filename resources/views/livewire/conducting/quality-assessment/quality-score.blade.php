{{-- Última atualização feita por Luiza Velasque --}}
<div class="d-flex flex-column gap-2 mb-3">
    {{-- Status do artigo --}}
    <div>
        <b>{{ __('project/conducting.quality-assessment.modal.status-quality') }}:</b>
        <span class="{{ 'text-' . strtolower($status_paper) }}">
            {{ __("project/conducting.quality-assessment.status." . strtolower($status_paper)) }}
        </span>
    </div>

    {{-- Score de qualidade (editável) --}}
    <div>
        <b>{{ __('project/conducting.quality-assessment.modal.quality-score') }}:</b>
        <input type="number"
               class="form-control d-inline w-auto {{ 'text-' . strtolower($status_paper) }}"
               wire:model.lazy="score"
               min="0"
               step="0.1"
               placeholder="Digite o score" />
    </div>

    {{-- Descrição do score --}}
    <div>
        <b>{{ __('project/conducting.quality-assessment.modal.quality-description') }}:</b>
        <span class="{{ 'text-' . strtolower($status_paper) }}">
            {{ $quality_description }}
        </span>
    </div>
</div>

@script
<script>
    $wire.on('quality-score', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
