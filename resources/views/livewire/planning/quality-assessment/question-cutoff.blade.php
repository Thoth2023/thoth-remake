<div>
    <hr class="mt-0" />
    <div class="card-header py-0">
        <x-helpers.modal
            target="question-quality"
            modalTitle="{{ __('project/planning.quality-assessment.min-general-score.title') }}"
            modalContent="hahaha"
        />
    </div>
    <div class="card-body">
        <div class="d-flex flex-wrap gap-2">
            <x-input
                id="sum"
                label="{{ __('project/planning.quality-assessment.min-general-score.sum') }}"
                placeholder="0"
                pattern="[A-Za-z]{3}"
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
                <option value="">Select a general score</option>
                @foreach ($generalScores as $score)
                    <option value="{{ $score->id_general_score }}" {{ $selectedGeneralScore == $score->id_general_score ? 'selected' : '' }}>{{ $score->description }}  ({{ $score->start }} - {{ $score->end }})</option>
                @endforeach

            </x-select>
        </div>
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
        .querySelector('input[id="weight"]')
        .addEventListener('input', function () {
            limit(this, 10);
        });
</script>

@script
<script>
    $wire.on('question-cutoff', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
