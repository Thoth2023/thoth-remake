<div class="card">
    <div class="card-header mb-0 pb-0">
        <x-helpers.modal
            target="search-questions"
            modalTitle="{{ __('project/planning.research-questions.title') }}"
            modalContent="{{ __('project/planning.research-questions.help.content') }}"
        />
    </div>
    <div class="card-body">
        <form wire:submit="submit" class="d-flex flex-column">
            <div class="d-flex flex-column gap-2 form-group w-md-50 w-100">
                <x-input
                    id="questionId"
                    label="{{ __('project/planning.research-questions.form.id') }}"
                    wire:model="questionId"
                    placeholder="ID"
                />
                @error("questionId")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror

                <x-input
                    id="description"
                    label="{{ __('project/planning.research-questions.form.description') }}"
                    wire:model="description"
                    placeholder="Digite sua questão de pesquisa"
                />
                @error("description")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <x-helpers.submit-button
                isEditing="{{ $form['isEditing'] }}"
                fitContent
            >
                {{
                    $form["isEditing"]
                        ? __("project/planning.research-questions.form.update")
                        : __("project/planning.research-questions.form.add")
                }}
                <div wire:loading>
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
            </x-helpers.submit-button>
        </form>
        <x-search.input
            class="mt-3 w-md-50 w-100"
            target="search-questions"
            isTable
        />
        <hr style="opacity: 10%" />
        <div class="overflow-auto px-2 py-1" style="max-height: 300px">
            <table class="table table-responsive table-hover">
                <thead
                    class="table-light sticky-top custom-gray-text"
                    style="color: #676a72"
                >
                    <th
                        style="
                            border-radius: 0.75rem 0 0 0;
                            padding: 0.5rem 1rem;
                        "
                    >
                        ID
                    </th>
                    <th style="padding: 0.5rem 0.75rem">Descrição</th>
                    <th
                        style="
                            border-radius: 0 0.75rem 0 0;
                            padding: 0.5rem 1rem;
                        "
                    >
                        Ações
                    </th>
                </thead>
                <tbody>
                    @forelse ($questions as $question)
                        <tr class="px-4" data-item="search-questions">
                            <td>{{ $question->id }}</td>
                            <td>
                                <span
                                    class="block text-wrap text-break"
                                    data-search
                                >
                                    {{ $question->description }}
                                </span>
                            </td>
                            <td>
                                <button
                                    class="btn py-1 px-3 btn-outline-secondary"
                                    wire:click="edit('{{ $question->id_research_question }}')"
                                >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button
                                    class="btn py-1 px-3 btn-outline-danger"
                                    wire:click="delete('{{ $question->id_research_question }}')"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4">
                                <x-helpers.description>
                                    {{ __("project/planning.research-questions.table.empty") }}
                                </x-helpers.description>
                            </td>
                        </tr>
                    @endforelse
                    <tr>
                        <td colspan="3" class="text-center py-4">
                            <x-search.empty target="search-questions">
                                {{ __("project/planning.research-questions.table.no-questions") }}
                            </x-search.empty>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
