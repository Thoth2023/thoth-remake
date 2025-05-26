<div class="card">
    <div class="card-header mb-0 pb-0">
        <x-helpers.modal
            target="search-questions"
            modalTitle="{{ __('project/planning.research-questions.title') }}"
            modalContent="{!! __('project/planning.research-questions.help.content') !!}"
        />
    </div>
    <div class="card-body">
        <form wire:submit="submit" class="d-flex flex-column">
            <div class="d-flex flex-column gap-2 form-group">
                <x-input
                    class="w-md-25 w-100"
                    maxlength="20"
                    id="questionId"
                    label="{{ __('project/planning.research-questions.form.id') }}"
                    wire:model="questionId"
                    placeholder="ID"
                    required
                    autocomplete="on"
                    name="research_question_id"
                    list="research_questionId_suggestions"
                />
                @error("questionId")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror

                <div class="d-flex flex-column">
                    <label
                        for="description"
                        class="form-control-label mx-0 mb-1 required"
                    >
                        {{ __("project/planning.research-questions.form.description") }}
                    </label>
                    <textarea
                        class="form-control"
                        maxlength="255"
                        rows="4"
                        id="description"
                        wire:model="description"
                        placeholder="{{ __("project/planning.research-questions.form.enter_description") }}"
                        pattern="[A-Za-zÀ-ÿ\s]+"
                        title="A descrição deve conter apenas letras e espaços."
                        required
                    ></textarea>
                </div>
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
                    <th style="padding: 0.5rem 0.75rem">
                        {{ __("project/planning.research-questions.table.description") }}
                    </th>
                    <th
                        style="
                            border-radius: 0 0.75rem 0 0;
                            padding: 0.5rem 1rem;
                        "
                    >
                        {{ __("project/planning.research-questions.table.actions") }}
                    </th>
                </thead>
                <tbody>
                    @forelse ($questions as $question)
                        <tr
                            class="px-4"
                            data-item="search-questions"
                            wire:key="{{ $question->id_research_question }}"
                        >
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
                                    wire:target="delete('{{ $question->id_research_question }}')"
                                    wire:loading.attr="disabled"
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

@script
    <script>
        $wire.on('research-questions', ([{ message, type }]) => {
            toasty({ message, type });
        });
    </script>
@endscript

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[wire\\:submit]');
    const input = document.querySelector('#questionId');
    
    if (form && input) {
        form.addEventListener('submit', function() {
            // Force save the current input value to suggestions
            const value = input.value.trim();
            if (value) {
                const storageKey = `suggestions_${input.id || input.name}`;
                let suggestions = [];
                
                if (localStorage.getItem(storageKey)) {
                    suggestions = JSON.parse(localStorage.getItem(storageKey));
                }
                
                if (!suggestions.includes(value)) {
                    suggestions.push(value);
                    localStorage.setItem(storageKey, JSON.stringify(suggestions));
                }
                
                // Automatically refresh suggestions without showing an alert
                setTimeout(() => {
                    refreshSuggestions('questionId', 'research_question_id', 'research_questionId_suggestions', false);
                }, 200);
            }
        });
    }
});
</script>
