<div>
    <!-- Minimum General Score for Approval Form -->
    <form wire:submit.prevent="submit" class="d-flex flex-column">
        <div class="form-group">
            <!-- Question Selector -->
            <div class="d-flex gap-3 flex-column w-200 w-md-100">
                <x-select
                    label="{{ __('project/planning.quality-assessment.min-general-score.title') }}"
                    wire:model="selectedGeneralScore"
                >
                    <option selected disabled>
                        {{ __("project/planning.quality-assessment.min-general-score.form.select-placeholder") }}
                    </option>
                    @if(!empty($generalScores))
                        @foreach ($generalScores as $generalScore)
                            <option value="{{ $generalScore->id_general_score }}">
                                {{ $generalScore->description }} ({{ $generalScore->start }} - {{ $generalScore->end }})
                            </option>
                        @endforeach
                    @else
                        <option disabled>{{ __('No General Scores available') }}</option>
                    @endif
                </x-select>
                @error('selectedGeneralScore')
                <span class="text-xs text-danger">
                    {{ $message }}
                </span>
                @enderror
            </div>
        </div>
        <div>
            <x-helpers.submit-button isEditing="{{ $form['isEditing'] }}">
                {{
                    $form['isEditing']
                        ? __("project/planning.quality-assessment.min-general-score.form.update")
                        : __("project/planning.quality-assessment.min-general-score.form.add")
                }}
                <div wire:loading>
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
            </x-helpers.submit-button>
        </div>
    </form>
</div>
@script
<script>
    $wire.on('min-general-score', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
