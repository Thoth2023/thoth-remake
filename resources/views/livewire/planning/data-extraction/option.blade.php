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
                <x-select
                    id="questionId"
                    label="{{ __('project/planning.data-extraction.option-form.question') }}"
                    wire:model="questionId"
                >
                    <option selected disabled>
                        {{ __("Selecione uma pergunta") }}
                    </option>
                    @foreach ($project->questions as $question)
                        @if (in_array($question->question_type->type, ["Multiple Choice List", "Pick One List"]))
                            <option value="{{ $question->id_de }}">
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

                <x-input
                    id="description"
                    label="{{ __('project/planning.data-extraction.option-form.option') }}"
                    wire:model="description"
                    placeholder=""
                    maxlength="255"
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
                            ? __("project/planning.data-extraction.option-form.update")
                            : __("project/planning.data-extraction.option-form.add-option")
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
            {{ __("project/planning.data-extraction.table.header.actions") }}
            </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($options as $option)
            <tr>
            <td>
            <x-table.accordion-button />
            </td>
            <td>{{ $option->id }}</td>
            <td>{{ $option->description }}</td>
            <td>
            <div style="min-width: fit-content">
            <button wire:click="edit({{ $option->id_option }})"
            class="btn btn-outline-secondary py-1 px-3 m-0">
            <i class="fas fa-edit"></i>
            </button>
            <button wire:click="delete({{ $option->id_option }})"
            class="btn btn-outline-danger py-1 px-3 m-0">
            <i class="fas fa-trash"></i>
            </button>
            </div>
            </td>
            </tr>
            <x-table.accordion-content>
            <td colspan="4">
            <div class="d-grid gap-3">
            @foreach ($option->subOptions as $subOption)
            <div class="table-accordion-item">
            <span class="d-flex text-break">
            {{ $subOption->description }}
            </span>
            <div>
            <button wire:click="editSubOption({{ $subOption->id }})"
            class="btn btn-outline-secondary py-0 px-3 m-0">
            <i class="fas fa-edit"></i>
            </button>
            <button wire:click="deleteSubOption({{ $subOption->id }})"
            class="btn btn-outline-danger py-0 px-3 m-0">
            <i class="fas fa-trash"></i>
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
        $wire.on('options', ([{ message, type }]) => {
            toasty({ message, type, timer: 50000 });
        });
    </script>
@endscript
