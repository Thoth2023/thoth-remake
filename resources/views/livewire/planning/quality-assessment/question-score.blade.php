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
                        <label for="score-rule" class="form-control-label required">
                            {{ __('project/planning.quality-assessment.question-score.score_rule.title') }}
                        </label>
                        <select
                            id="score-rule"
                            wire:model.lazy="scoreRule"
                            class="form-control"
                            required
                        >
                            <option value="">{{ __('Selecione uma regra') }}</option>
                            <option value="sim">{{ __('Sim') }}</option>
                            <option value="partial">{{ __('Parcial') }}</option>
                            <option value="nao">{{ __('Não') }}</option>
                        </select>
                        @error("scoreRule")
                            <span class="text-xs text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <label for="range-score" class="form-control-label required">
                            {{ __("project/planning.quality-assessment.question-score.range.score") }}
                        </label>
                        <div class="d-flex align-items-center gap-2">
                            <input
                                id="range-score"
                                type="range"
                                class="form-range"
                                min="0"
                                max="100"
                                step="5"
                                wire:model="score"
                                oninput="updateRangeValue(this.value)"
                                required
                            />
                            <span class="text-xs" id="range-score">
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
                        <label for="description" class="form-control-label required">
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
        function updateRangeValue(value) {
            const labelText = document.getElementById('range-score');
            document.getElementById('range-score').textContent = value + '%';
        }
    </script>
@endpush

@script
    <script>
        $wire.on('question-score', ([{ message, type }]) => {
            toasty({ message, type });
        });
    </script>
@endscript
