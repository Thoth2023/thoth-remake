<div class="card">
    <div class="card-header mb-0 pb-0">
        <x-helpers.modal
            target="data-extraction.option-form"
            modalTitle="{{ __('project/planning.data-extraction.option-form.title') }}"
            modalContent="{{ __('project/planning.data-extraction.option-form.help.content') }}"
        />
    </div>
    <div class="card-body">
        <form wire:submit="submit" class="d-flex flex-column">
            <div class="form-group mt-3 d-flex flex-column gap-4">
                <x-input
                    id="questionId"
                    label="{{ __('project/planning.data-extraction.question-form.id') }}"
                    wire:model="questionId"
                    placeholder="Não utilize caracteres especiais"
                    maxlength="255"
                />
                @error("questionId")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror

                <x-input
                    id="description"
                    label="{{ __('project/planning.data-extraction.question-form.description') }}"
                    wire:model="description"
                    placeholder=""
                    maxlength="255"
                />
                @error("description")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror

                <x-select
                    wire:model="type"
                    label="{{ __('project/planning.data-extraction.question-form.type') }}"
                >
                    <option selected disabled>
                        {{ __("Selecione um tipo") }}
                    </option>
                    @foreach ($questionTypes as $type)
                        <option value="{{ $type->id_type }}">
                            {{ $type->type }}
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
                            ? __("project/planning.data-extraction.question-form.update")
                            : __("project/planning.data-extraction.question-form.add-question")
                    }}
                    <div wire:loading>
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </x-helpers.submit-button>
            </div>
        </form>
        <ul class="list-group">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-1">
                        <b>{{ __('project/planning.data-extraction.table.header.id') }}</b>
                    </div>
                    <div class="col">
                        <b>{{ __('project/planning.data-extraction.table.header.description') }}</b>
                    </div>
                    <div class="col">
                        <b>{{ __('project/planning.data-extraction.table.header.question-type') }}</b>
                    </div>
                    <div class="col-5">
                        <b>{{ __('project/planning.data-extraction.table.header.options') }}</b>
                    </div>
                    <div class="col-md-auto">
                        <b>{{ __('project/planning.data-extraction.table.header.actions') }}</b>
                    </div>
                </div>
            </li>
            @foreach ($project->questions as $question)
                @include('project.planning.data-extraction.partials.data-extraction-question', [
                    'question' => $question,
                    'project' => $project,
                    'types' => $questionTypes,
                ])
            @endforeach
        </ul>
    </div>
</div>

@script
    <script>
        $wire.on('questions', ([{ message, type }]) => {
            toasty({ message, type });
        });
    </script>
@endscript
