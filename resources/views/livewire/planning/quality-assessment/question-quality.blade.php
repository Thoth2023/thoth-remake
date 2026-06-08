<div class="card">
    <div class="card-header thoth-card-header mb-0 pb-0">
        <div class="thoth-card-badge"><b>13</b></div>
        <x-helpers.modal
            target="question-quality"
            modalTitle="{{ __('project/planning.quality-assessment.question-quality.title') }}"
            modalContent="{!! __('project/planning.quality-assessment.question-quality.help.content') !!}"
        />
    </div>
    <div class="card-body pb-1">
        <form wire:submit="submit" novalidate>
            <div class="d-flex flex-wrap gap-2">
                <div class="d-flex flex-column gap-1">
                    <x-input
                        id="question-quality-id"
                        label="{{ __('project/planning.quality-assessment.question-quality.id') }}"
                        placeholder="QA01"
                        wire:model="questionId"
                        required
                        autocomplete="on"
                        name="quality_question_id"
                        list="quality_questionId_suggestions"
                    />
                    @error('questionId')
                    <span class="text-xs text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="d-flex flex-column gap-1">
                    <x-input
                        id="weight"
                        label="{{ __('project/planning.quality-assessment.question-quality.weight') }}"
                        type="number"
                        min="0"
                        placeholder="2"
                        wire:model="weight"
                        required
                    />
                    @error('weight')
                    <span class="text-xs text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="d-flex flex-column mt-2">
                <label for="question" class="mb-1 mx-0 required">
                    {{ __('project/planning.research-questions.form.description') }}
                </label>
                <textarea
                    id="question"
                    class="form-control"
                    maxlength="255"
                    rows="2"
                    placeholder="{{ __('project/planning.research-questions.form.enter_description') }}"
                    wire:model="description"
                    required
                ></textarea>
                @error('description')
                <span class="text-xs text-danger">{{ $message }}</span>
                @enderror
            </div>
            <x-helpers.submit-button isEditing="{{ $form['isEditing'] }}" class="mt-3">
                {{ $form['isEditing']
                    ? __('project/planning.quality-assessment.question-quality.update')
                    : __('project/planning.quality-assessment.question-quality.add') }}
                <div wire:loading>
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
            </x-helpers.submit-button>
        </form>
    </div>

    {{-- Modal: confirmação de submit (peso alterado) --}}
    <div wire:ignore>
        <div id="qaSubmitConfirmModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ __('project/planning.quality-assessment.question-quality.submit.warning_title') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning d-flex align-items-center gap-2">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>{{ __('project/planning.quality-assessment.question-quality.submit.warning_evaluations') }}</span>
                        </div>
                        <p>{{ __('project/planning.quality-assessment.question-quality.submit.confirm_message') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                wire:click="resetFields">
                            {{ __('project/planning.quality-assessment.question-quality.submit.cancel') }}
                        </button>
                        <button type="button" class="btn btn-danger"
                                wire:click="confirmSubmit"
                                data-bs-dismiss="modal">
                            {{ __('project/planning.quality-assessment.question-quality.submit.confirm') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: confirmação de exclusão de questão --}}
    <div wire:ignore>
        <div id="qaDeleteConfirmModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ __('project/planning.quality-assessment.question-quality.delete.title') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @if ($deletionHasEvaluations)
                            <div class="alert alert-warning d-flex align-items-center gap-2">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>{{ __('project/planning.quality-assessment.question-quality.delete.warning_evaluations') }}</span>
                            </div>
                        @endif
                        <p>{{ __('project/planning.quality-assessment.question-quality.delete.confirm_message') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('project/planning.quality-assessment.question-quality.delete.cancel') }}
                        </button>
                        <button type="button"
                                class="btn {{ $deletionHasEvaluations ? 'btn-danger' : 'btn-outline-danger' }}"
                                wire:click="delete('{{ $confirmingDeleteId }}')"
                                data-bs-dismiss="modal">
                            {{ __('project/planning.quality-assessment.question-quality.delete.confirm') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('input[id="question-quality-id"]')
        ?.addEventListener('input', function () { limit(this, 15); });

    document.querySelector('input[id="weight"]')
        ?.addEventListener('input', function () { limit(this, 10); });

    function limit(element, maxLength = 10) {
        const value = element.value.toString();
        if (value.length > maxLength) element.value = value.slice(0, maxLength);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const form  = document.querySelector('form[wire\\:submit]');
        const input = document.querySelector('#question-quality-id');

        if (form && input) {
            form.addEventListener('submit', function () {
                const value = input.value.trim();
                if (value) {
                    const storageKey = `suggestions_${input.id || input.name}`;
                    let suggestions  = JSON.parse(localStorage.getItem(storageKey) || '[]');
                    if (!suggestions.includes(value)) {
                        suggestions.push(value);
                        localStorage.setItem(storageKey, JSON.stringify(suggestions));
                    }
                    setTimeout(() => {
                        refreshSuggestions('question-quality-id', 'quality_question_id', 'quality_questionId_suggestions', false);
                    }, 200);
                }
            });
        }
    });
</script>

@script
<script>
    $wire.on('question-quality', ([{ message, type }]) => {
        toasty({ message, type });
    });

    $wire.on('openQaSubmitConfirm', () => {
        new bootstrap.Modal(document.getElementById('qaSubmitConfirmModal')).show();
    });

    $wire.on('openQaDeleteConfirm', () => {
        new bootstrap.Modal(document.getElementById('qaDeleteConfirmModal')).show();
    });
</script>
@endscript
