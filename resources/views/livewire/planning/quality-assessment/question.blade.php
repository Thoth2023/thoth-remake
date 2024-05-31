<!-- Question -->
<div class="card">
    <div class="card-header">
        <x-helpers.modal
            target="question-quality"
            modalTitle="{{ __('project/planning.quality-assessment.question-quality.title') }}"
            modalContent="{{ __('project/planning.quality-assessment.question-quality.help.content') }}"
        />
    </div>
    <div class="card-body">
        <form wire:submit="submit">
            @csrf

            <div class="form-group">
                <x-input
                    maxlength="6"
                    id="questionId"
                    label="{{ __('project/planning.quality-assessment.question-quality.id') }}"
                    wire:model="questionId"
                    placeholder="QA01"
                />
                @error("questionId")
                <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <x-input
                    id="description"
                    label="{{ __('project/planning.quality-assessment.question-quality.description') }}"
                    wire:model="description"
                    placeholder="{{ __('project/planning.quality-assessment.question-quality.description') }}"
                    maxlength="255"
                />
                @error("description")
                <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <x-input
                    maxlength="3"
                    id="weight"
                    label="{{ __('project/planning.quality-assessment.question-quality.weight') }}"
                    wire:model="weight"
                    placeholder="0.5"
                />
                @error("questionId")
                <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div>
                <x-helpers.submit-button isEditing="{{ $form['isEditing'] }}">
                    {{
                        $form["isEditing"]
                            ? __("project/planning.quality-assessment.question-quality.update")
                            : __("project/planning.quality-assessment.question-quality.add")
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
    $wire.on('question', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
