<div class="card">
    <div class="card-header mb-0 pb-0">
        <x-helpers.modal
            target="data-extraction"
            modalTitle="{{ translationPlanning('data-extraction.question-form.title') }}"
            modalContent="{!!   translationPlanning('data-extraction.question-form.help.content') !!}"
            modalclass="modal-xl"
        />
    </div>
    <div class="card-body">
        <form wire:submit="submit" class="d-flex flex-column">
            <div class="form-group mt-3 d-flex flex-column gap-4">
                <x-input
                    id="questionId"
                    label="{{ translationPlanning('data-extraction.question-form.id') }}"
                    wire:model="questionId"
                    placeholder="Não utilize caracteres especiais"
                    maxlength="255"
                    required
                />
                @error("questionId")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror

                <x-input
                    id="description"
                    label="{{ translationPlanning('data-extraction.question-form.description') }}"
                    wire:model="description"
                    placeholder=""
                    maxlength="255"
                    required
                />
                @error("description")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror

                <x-select
                    wire:model="type"
                    label="{{ translationPlanning('data-extraction.question-form.type') }}"
                    required
                >
                    <option
                        <?= $currentQuestion === null ? "selected" : "" ?>
                        disabled
                    >
                        {{ __("Selecione um tipo") }}
                    </option>
                    @foreach ($questionTypes as $questionType)
                        <option
                            <?= ($currentQuestion->type ?? "-1") == $questionType->id_type ? "selected" : "" ?>
                            value="{{ $questionType->id_type }}"
                        >
                            {{ $questionType->type }}
                        </option>
                    @endforeach
                </x-select>
                @error("type")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div>
                <x-helpers.submit-button isEditing="{{ $form['isEditing'] }}">
                    {{
                        $form["isEditing"]
                            ? translationPlanning('data-extraction.question-form.edit-question')
                            : translationPlanning('data-extraction.question-form.add-question')
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
        $wire.on('questions', ([{ message, type }]) => {
            toasty({ message, type });
        });
    </script>
@endscript
