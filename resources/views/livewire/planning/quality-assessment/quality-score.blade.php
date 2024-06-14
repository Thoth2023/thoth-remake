<!-- Question Score -->
<div class="card">
    <div class="card-header mb-0 pb-0">
        <x-helpers.modal
            target="quality-score"
            modalTitle="{{ __('project/planning.quality-assessment.quality-score.help.title') }}"
            modalContent="{{ __('project/planning.quality-assessment.quality-score.help.content') }}"
        />
    </div>
    <div class="card-body">
        <form wire:submit="submit">
            <div class="form-group">
                <!-- Question Selector -->
                <div class="d-flex gap-3 flex-column w-200 w-md-100">
                    <x-select
                        wire:model="id_qa"
                        label="{{ __('project/planning.quality-assessment.quality-score.id_qa.title') }}"
                    >
                        <option selected disabled>
                            {{ __("project/planning.quality-assessment.quality-score.form.select-qa-placeholder") }}
                        </option>
                        @if(!empty($currentQuestion))
                            @foreach ($currentQuestion as $question)
                                <option value="{{ $question['id_qa'] }}">
                                    {{ $question['id'] }} - {{ $question['description'] }}
                                </option>
                            @endforeach
                        @else
                            <option disabled>{{ __("project/planning.quality-assessment.quality-score.id_qa.no-question-available") }}</option>
                        @endif
                    </x-select>
                    @error("id_qa")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                 <x-input
                        id="score_rule"
                        label="{{ __('project/planning.quality-assessment.quality-score.score_rule.title') }}"
                        wire:model="score_rule"
                        placeholder="{{ __('project/planning.quality-assessment.quality-score.score_rule.placeholder') }}"
                        maxlength="55"

                    />
                    @error("score_rule")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                    @enderror

                    <!-- Score Range Selector -->
                    <div class="form-group">
                        <label for="scoreRange" id="scoreLabel" class="form-label">{{ __('project/planning.quality-assessment.quality-score.range.score') }}</label>
                        <input type="range" class="form-range" id="scoreRange" min="0" max="100" step="5"
                               oninput="updateRangeValue(this.value)">
                        <div class="d-flex justify-content-center">
                            <span id="currentScore">{{ __('project/planning.quality-assessment.quality-score.range.score') }}: 50%</span>
                        </div>
                    </div>
                    <script>
                        function updateRangeValue(value) {
                            const labelText = document.getElementById("scoreLabel").textContent;
                            document.getElementById("currentScore").textContent = labelText + ": " + value + "%";
                        }
                    </script>

                    <x-input
                        id="description"
                        label="{{ __('project/planning.quality-assessment.quality-score.description.title') }}"
                        wire:model="end"
                        placeholder="{{ __('project/planning.quality-assessment.quality-score.description.placeholder') }}"
                        maxlength="55"

                    />
                    @error("description")
                    <span class="text-xs text-danger">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


            <div>
                <x-helpers.submit-button isEditing="{{ $form['isEditing'] }}">
                    {{
                        $form["isEditing"]
                            ? __("project/planning.quality-assessment.quality-score.form.update")
                            : __("project/planning.quality-assessment.quality-score.form.add")
                    }}
                    <div wire:loading>
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </x-helpers.submit-button>
            </div>

        </form>

    </div>
</div>
@script
<script>
    $wire.on('quality-score', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
