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
            <form>
                <div class="d-flex flex-wrap gap-2">
                    <div style="min-width: 250px">
                        <x-select search label="Question">
                            <option selected disabled>Disabled</option>
                            <option value="1">ASDASDASASDASDA</option>
                            <option value="2">2</option>
                        </x-select>
                    </div>
                    <x-input
                        id="weight"
                        label="Weight"
                        type="number"
                        maxlength="3"
                        min="0"
                        placeholder="2"
                    />
                </div>
                <div class="d-flex align-items-center flex-wrap gap-3 mt-3">
                    <div style="min-width: 150px">
                        <div
                            class="d-flex align-items-start justify-content-between"
                        >
                            <label for="score-rule" class="m-0 p-0">
                                Score
                            </label>
                            <span class="text-xs">50%</span>
                        </div>
                        <input
                            type="range"
                            class="form-range my-1"
                            min="0"
                            max="100"
                            step="5"
                        />
                    </div>
                    <x-input
                        id="weight"
                        label="Weight"
                        type="number"
                        maxlength="3"
                        min="0"
                        placeholder="2"
                    />
                </div>
                <div class="d-flex flex-column mt-2">
                    <label for="question" class="mb-1 mx-0">
                        {{ __("project/planning.research-questions.form.description") }}
                    </label>
                    <textarea
                        id="question"
                        wire:model="question"
                        class="form-control"
                        maxlength="255"
                        rows="2"
                        placeholder="{{ __("project/planning.research-questions.form.enter_description") }}"
                    ></textarea>
                </div>
                <x-helpers.submit-button class="mt-3">
                    {{ __("project/planning.quality-assessment.question-quality.add") }}
                    <div wire:loading>
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </x-helpers.submit-button>
            </form>
        </div>
    </div>
</div>
