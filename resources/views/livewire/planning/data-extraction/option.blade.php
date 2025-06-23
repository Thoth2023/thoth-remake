<div class="card">
    <div class="card-header mb-0 pb-0">
        <x-helpers.modal
            target="data-extraction"
            modalTitle="{{ translationPlanning('data-extraction.option-form.title') }}"
            modalContent="{!! translationPlanning('data-extraction.option-form.help.content') !!}"
        />
    </div>
    <div class="card-body">
        <form wire:submit="submit" class="d-flex flex-column">
            <div class="form-group mt-3 d-flex flex-column gap-4">
                <div class="d-flex flex-column gap-1">
                    <x-select
                        id="questionId"
                        label="{{ translationPlanning('data-extraction.option-form.question') }}"
                        wire:model="questionId"
                        required
                    >
                        <option selected disabled>
                        {{ __('project/planning.data-extraction.option-form.question-selection.title') }}
                        </option>
                        @foreach ($project->dataExtractionQuestions as $question)
                            @if (in_array($question->question_type->type, ["Multiple Choice List", "Pick One List"]))
                                <option
                                    value="{{ $question->id_de }}"
                                    <?= $question->id_de === ($currentOption->id_de ?? "") ? "selected" : "" ?>
                                >
                                    {{ $question->id }}
                                </option>
                            @endif
                        @endforeach
                    </x-select>
                    @error("questionId")
                        <span class="text-xs text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <x-input
                    id="description"
                    label="{{ translationPlanning('data-extraction.option-form.option') }}"
                    wire:model="description"
                    placeholder=""
                    maxlength="255"
                    pattern="[a-zA-ZÀ-ÿ0-9\s]+"
                    required
                />
                @error("description")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div>
                <x-helpers.submit-button :isEditing="$form['isEditing']">
                    {{
                        $form["isEditing"]
                            ? translationPlanning('data-extraction.option-form.edit-option')
                            : translationPlanning('data-extraction.option-form.add-option')
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
        $wire.on('options', ([{ message, type }]) => {
            toasty({ message, type });
        });
    </script>
@endscript
