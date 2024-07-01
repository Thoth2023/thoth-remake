<div class="card">
    <div class="card-header mb-0 pb-0">
        <x-helpers.modal
            target="data-extraction.question-form"
            modalTitle="{{ __('project/planning.data-extraction.question-form.title') }}"
            modalContent="{{ __('project/planning.data-extraction.question-form.help.content') }}"
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
                            ? __("project/planning.data-extraction.question-form.edit-question")
                            : __("project/planning.data-extraction.question-form.add-question")
                    }}
                    <div wire:loading>
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </x-helpers.submit-button>
            </div>
        </form>
        {{--
            <div class="mt-2 mx-0" style="border-radius: 20px">
            <div class="table-container">
            <table class="table table-custom-hover">
            <thead class="table-light">
            <tr class="p-0 m-0">
            <th
            class="p-1 rounded-l-sm"
            style="width: 20px"
            ></th>
            <th scope="col" class="p-1">
            {{ __("project/planning.data-extraction.table.header.id") }}
            </th>
            <th scope="col" class="p-1">
            {{ __("project/planning.data-extraction.table.header.description") }}
            </th>
            <th scope="col" class="p-1">
            {{ __("project/planning.data-extraction.table.header.question-type") }}
            </th>
            <th scope="col" class="p-1 rounded-r-sm">
            {{ __("project/planning.data-extraction.table.header.actions") }}
            </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($project->questions as $question)
            <tr>
            <td>
            @if ($question->options->isNotEmpty())
            <x-table.accordion-button />
            @endif
            </td>
            <td>{{ $question->id }}</td>
            <td>{{ $question->description }}</td>
            <td>
            {{ $question->question_type->type }}
            </td>
            <td>
            <div style="min-width: fit-content">
            <button
            class="btn btn-outline-secondary py-1 px-3 m-0"
            >
            <i class="fas fa-edit"></i>
            </button>
            <button
            class="btn btn-outline-danger py-1 px-3 m-0"
            >
            <i class="fas fa-trash"></i>
            </button>
            </div>
            </td>
            </tr>
            <x-table.accordion-content>
            <td colspan="5">
            <div class="d-grid gap-3">
            @foreach ($question->options as $option)
            <div class="table-accordion-item">
            <span class="d-flex text-break">
            {{ $option->description }}
            </span>
            <div>
            <button
            class="btn btn-outline-secondary py-0 px-3 m-0"
            >
            <i
            class="fas fa-edit"
            ></i>
            </button>
            <button
            class="btn btn-outline-danger py-0 px-3 m-0"
            >
            <i
            class="fas fa-trash"
            ></i>
            </button>
            </div>
            </div>
            @endforeach
            </div>
            </td>
            </x-table.accordion-content>
            @endforeach
            </tbody>
            </table>
            </div>
            </div>
        --}}
    </div>
</div>

@script
    <script>
        $wire.on('questions', ([{ message, type }]) => {
            toasty({ message, type });
        });
    </script>
@endscript
