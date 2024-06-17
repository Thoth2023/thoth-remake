<div class="d-flex flex-column gap-4">
    <div class="card">
        <div class="card-header pb-0">
            <x-helpers.modal
                target="question-score"
                modalTitle="{{ __('project/planning.quality-assessment.question-score.title') }}"
                modalContent="{{ __('project/planning.quality-assessment.question-score.help.content') }}"
            />
        </div>
        <div class="card-body">
            <form wire:submit="submit">
                <div class="d-flex flex-wrap gap-2">
                    <div class="d-flex flex-column gap-1">
                        <div style="min-width: 250px">
                            <x-select
                                label="Question"
                                wire:model="questionId"
                                search
                            >
                                <option selected disabled>
                                    Selecione uma questão
                                </option>
                                @foreach ($questions as $question)
                                    <option value="{{ $question->id_qa }}">
                                        {{ $question->id }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>
                        @error("questionId")
                            <span class="text-xs text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <x-input
                            id="score-rule"
                            label="Score Rule"
                            maxlength="25"
                            min="0"
                            placeholder="Partial"
                            wire:model="scoreRule"
                        />
                        @error("scoreRule")
                            <span class="text-xs text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="d-flex align-items-center flex-wrap gap-3 mt-3">
                    <div class="d-flex flex-column gap-1">
                        <div style="min-width: 150px">
                            <div
                                class="d-flex align-items-start justify-content-between"
                            >
                                <label for="range-score" class="m-0 p-0">
                                    Score
                                </label>
                                <span class="text-xs" id="range-score">
                                    50%
                                </span>
                            </div>
                            <input
                                id="range-score"
                                type="range"
                                class="form-range my-1"
                                min="0"
                                max="100"
                                step="5"
                                wire:model="score"
                                oninput="updateRangeValue(this.value)"
                            />
                        </div>
                        @error("score")
                            <span class="text-xs text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <x-input
                            id="weight-score"
                            label="Weight"
                            type="number"
                            maxlength="3"
                            min="0"
                            placeholder="2"
                            wire:model="weight"
                        />
                        @error("weight")
                            <span class="text-xs text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="d-flex flex-column mt-2">
                    <label for="question" class="mb-1 mx-0">
                        {{ __("project/planning.research-questions.form.description") }}
                    </label>
                    <textarea
                        id="question"
                        wire:model="description"
                        class="form-control"
                        maxlength="255"
                        rows="2"
                        placeholder="{{ __("project/planning.research-questions.form.enter_description") }}"
                    ></textarea>
                    @error("description")
                        <span class="text-xs text-danger mt-1">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <x-helpers.submit-button
                    isEditing="{{ $form['isEditing'] }}"
                    class="mt-3"
                >
                    {{
                        $form["isEditing"]
                            ? __("project/planning.quality-assessment.quality-score.form.update")
                            : __("project/planning.quality-assessment.quality-score.form.add")
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
