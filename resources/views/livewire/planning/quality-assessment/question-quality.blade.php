<div class="d-flex flex-column gap-4">
    <div class="card">
        <div class="card-header pb-0">
            <x-helpers.modal
                target="question-quality"
                modalTitle="{{ __('project/planning.quality-assessment.question-quality.title') }}"
                modalContent="{{ __('project/planning.quality-assessment.question-quality.help.content') }}"
            />
        </div>
        <div class="card-body pb-1">
            <form>
                <div class="d-flex flex-wrap gap-2">
                    <x-input
                        id="question-quality-id"
                        label="ID"
                        placeholder="QA01"
                        pattern="[A-Za-z]{3}"
                    />
                    <x-input
                        id="weight"
                        label="{{ __('project/planning.quality-assessment.question-quality.weight') }}"
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
        @livewire("planning.quality-assessment.question-cutoff")
    </div>
</div>

<script>
    function limit(element, maxLength = 10) {
        const value = element.value.toString();

        if (value.length > maxLength) {
            element.value = value.slice(0, maxLength);
        }
    }

    document
        .querySelector('input[id="question-quality-id"]')
        .addEventListener('input', function () {
            limit(this, 15);
        });

    document
        .querySelector('input[id="weight"]')
        .addEventListener('input', function () {
            limit(this, 10);
        });
</script>
