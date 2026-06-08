<div class="card">
    <div class="card-header thoth-card-header mb-0 pb-0">
        <div class="thoth-card-badge"><b>17</b></div>
        <x-helpers.modal
            target="question-cutoff"
            modalTitle="{{ __('project/planning.quality-assessment.min-general-score.title') }}"
            modalContent="{!! __('project/planning.quality-assessment.min-general-score.help-content') !!}"
        />
    </div>
    <div class="card-body">
        <div class="d-flex flex-wrap gap-2">
            <x-input
                id="sum"
                label="{{ __('project/planning.quality-assessment.min-general-score.sum') }}"
                placeholder="0"
                wire:model="sum"
                disabled
            />
        </div>
        <div class="gap-2">
            <x-select
                id="cutoff"
                label="{{ __('project/planning.quality-assessment.min-general-score.cutoff') }}"
                wire:model="selectedGeneralScore"
                wire:change="updateCutoff"
            >
                <option selected disabled>
                    {{ __('project/planning.quality-assessment.min-general-score.form.select-placeholder') }}
                </option>
                @foreach ($generalScores as $score)
                    <option value="{{ $score->id_general_score }}"
                        {{ $selectedGeneralScore == $score->id_general_score ? 'selected' : '' }}>
                        {{ $score->description }} ({{ $score->start }} - {{ $score->end }})
                    </option>
                @endforeach
            </x-select>
        </div>
    </div>

    {{-- Modal: confirmação de alteração do cutoff --}}
    <div wire:ignore>
        <div id="qaCutoffConfirmModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ __('project/planning.quality-assessment.cutoff.warning_title') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning d-flex align-items-center gap-2">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>{{ __('project/planning.quality-assessment.cutoff.warning_evaluations') }}</span>
                        </div>
                        <p>{{ __('project/planning.quality-assessment.cutoff.confirm_message') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('project/planning.quality-assessment.cutoff.cancel') }}
                        </button>
                        <button type="button" class="btn btn-danger"
                                wire:click="confirmCutoff"
                                data-bs-dismiss="modal">
                            {{ __('project/planning.quality-assessment.cutoff.confirm') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('input[id="weight"]')
        ?.addEventListener('input', function () {
            const value = this.value.toString();
            if (value.length > 10) this.value = value.slice(0, 10);
        });
</script>

@script
<script>
    $wire.on('question-cutoff', ([{ message, type }]) => {
        toasty({ message, type });
    });

    $wire.on('openQaCutoffConfirm', () => {
        new bootstrap.Modal(document.getElementById('qaCutoffConfirmModal')).show();
    });
</script>
@endscript
