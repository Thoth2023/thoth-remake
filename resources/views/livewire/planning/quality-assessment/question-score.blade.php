<div class="d-flex flex-column gap-4">
    <div class="card h-100">
        <div class="card-header pb-0">
            <x-helpers.modal
                target="question-score"
                modalTitle="{{ __('project/planning.quality-assessment.question-score.title') }}"
                modalContent="{!! __('project/planning.quality-assessment.question-score.help.content') !!}"
                class="modal-sm"
            />
        </div>
        <div class="card-body">
            <form wire:submit="submit" novalidate>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex flex-column gap-1">
                        <x-select
                            label="{{ __('project/planning.quality-assessment.question-score.question.title') }}"
                            id="questionId"
                            wire:model="questionId"
                            required
                            search
                            disabled="{{ $form['isEditing'] }}"
                        >
                            <option selected disabled>
                                {{ __("project/planning.quality-assessment.question-score.question.placeholder") }}
                            </option>
                            @foreach ($questions as $question)
                                <option
                                    value="{{ $question->id_qa }}"
                                    <?= $question->id_qa == ($questionId["value"] ?? "") ? "selected" : "" ?>
                                >
                                    {{ $question->id }}
                                </option>
                            @endforeach
                        </x-select>
                        @error("questionId")
                            <span class="text-xs text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <label
                            for="score-rule"
                            class="form-control-label required"
                        >
                            {{ __("project/planning.quality-assessment.question-score.score_rule.title") }}
                        </label>
                        <input
                            id="score-rule"
                            list="score-rule-options"
                            class="form-control"
                            placeholder="{{ __("Selecione ou digite uma regra") }}"
                            wire:model.lazy="scoreRule"
                            onchange="handleScoreRuleChange(this.value)"
                            label="{{ __("project/planning.quality-assessment.question-score.score_rule.title") }}"
                            maxlength="20"
                            min="0"
                            pattern="[a-zA-ZÀ-ÿ\s]+"
                            required
                        />
                        <datalist id="score-rule-options">
                            @foreach ($scoreRuleOptions as $option)
                                <option value="{{ $option }}"></option>
                            @endforeach
                        </datalist>
                        @error("scoreRule")
                            <span class="text-xs text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="d-flex flex-column gap-1">
                        <label
                            for="range-score"
                            class="form-control-label required"
                        >
                            {{ __("project/planning.quality-assessment.question-score.range.score") }}
                        </label>
                        <div class="d-flex align-items-center gap-2">
                            <input
                                id="range-score"
                                type="range"
                                class="form-range my-1"
                                min="0"
                                max="100"
                                step="5"
                                wire:model="score"
                                oninput="updateRangeValue(this.value)"
                                required
                            />
                            <span class="text-xs" id="range-score-label">
                                {{ $score ?? 50 }}%
                            </span>
                        </div>
                        @error("score")
                            <span class="text-xs text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <label
                            for="description"
                            class="form-control-label required"
                        >
                            {{ __("project/planning.research-questions.form.description") }}
                        </label>
                        <textarea
                            id="description"
                            wire:model="description"
                            class="form-control"
                            maxlength="255"
                            rows="2"
                            placeholder="{{ __("project/planning.research-questions.form.enter_description") }}"
                            pattern="[a-zA-ZÀ-ÿ0-9\s]+"
                            required
                        ></textarea>
                        @error("description")
                            <span class="text-xs text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <x-helpers.submit-button
                    isEditing="{{ $form['isEditing'] }}"
                    class="mt-3"
                >
                    {{
                        $form["isEditing"]
                            ? __("project/planning.quality-assessment.question-score.form.update")
                            : __("project/planning.quality-assessment.question-score.form.add")
                    }}
                    <div wire:loading>
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </x-helpers.submit-button>
            </form>
        </div>
    </div>
</div>

@push("scripts")
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function updateRangeValue(value) {
                const rangeLabel = document.getElementById('range-score-label');
                if (rangeLabel) {
                    rangeLabel.textContent = value + '%';
                    @this.set('score', value);
                } else {
                    console.error("Elemento 'range-score-label' não encontrado.");
                }
            }

            function handleScoreRuleChange(value) {
                const rangeInput = document.getElementById('range-score');
                const rangeLabel = document.getElementById('range-score-label');

                if (rangeInput && rangeLabel) {
                    let scoreValue = 50;
                    if (value === 'Sim') {
                        scoreValue = 100;
                    } else if (value === 'Parcial') {
                        scoreValue = 50;
                    } else if (value === 'Não') {
                        scoreValue = 0;
                    }

                    rangeInput.value = scoreValue;
                    rangeLabel.textContent = scoreValue + '%';

                    @this.set('score', scoreValue);
                } else {
                    console.error("Elementos 'range-score' ou 'range-score-label' não encontrados.");
                }
            }

            const scoreRuleDropdown = document.getElementById('score-rule');
            if (scoreRuleDropdown) {
                scoreRuleDropdown.addEventListener('change', function () {
                    handleScoreRuleChange(this.value);
                });
            } else {
                console.error("Elemento 'score-rule' não encontrado.");
            }

            const rangeInput = document.getElementById('range-score');
            if (rangeInput) {
                rangeInput.addEventListener('input', function () {
                    updateRangeValue(this.value);
                });
            } else {
                console.error("Elemento 'range-score' não encontrado.");
            }
        });
    </script>
@endpush

@script
    <script>
        $wire.on('question-score', ([{ message, type }]) => {
            toasty({ message, type });
        });
    </script>
@endscript
