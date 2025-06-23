<div class="card">
    <div class="card-header mb-0 pb-0">
        <x-helpers.modal
            target="data-extraction"
            modalTitle="{{ __('project/planning.data-extraction.question-form.title') }}"
            modalContent="{!!   __('project/planning.data-extraction.question-form.help.content') !!}"
            modalclass="modal-xl"
        />
    </div>
    <div class="card-body">
        <form wire:submit="submit" class="d-flex flex-column">
            <div class="form-group mt-3 d-flex flex-column gap-4">
                <x-input
                    id="questionId"
                    class="form-control w-md-25 w-100"
                    type="text"
                    maxlength="20"
                    wire:model="questionId"
                    placeholder="ID"
                    autocomplete="on"
                    name="de_question_id"
                    list="de_questionId_suggestions"
                    maxlength="255"
                    pattern="\d+"
                    required

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
                    pattern="[a-zA-ZÀ-ÿ0-9\s]+"
                    required
                />
                @error("description")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror

                <x-select
                    wire:model="type"
                    label="{{ __('project/planning.data-extraction.question-form.type') }}"
                    required
                >
                    <option
                        <?= $currentQuestion === null ? "selected" : "" ?>
                        disabled
                    >
                        {{ __('project/planning.data-extraction.question-form.type-selection.title') }}
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
    </div>
</div>

@script
    <script>
        $wire.on('questions', ([{ message, type }]) => {
            toasty({ message, type });
        });
    </script>
@endscript

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[wire\\:submit]');
    const input = document.querySelector('#questionId');
    
    if (form && input) {
        // Save every keypress, not just on submit
        input.addEventListener('input', function() {
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
                    
                    // Force immediate refresh of suggestions
                    const datalist = document.getElementById('de_questionId_suggestions');
                    if (datalist) {
                        // Clear existing options and re-add them
                        datalist.innerHTML = '';
                        suggestions.forEach(suggestion => {
                            const option = document.createElement('option');
                            option.value = suggestion;
                            datalist.appendChild(option);
                        });
                    }
                    
                    // Hack: force browser to "reset" its autocomplete understanding
                    input.setAttribute('autocomplete', 'off');
                    setTimeout(() => input.setAttribute('autocomplete', 'on'), 10);
                }
            }
        });
        
        form.addEventListener('submit', function() {
            // Save the current value
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
                    refreshSuggestions('questionId', 'de_question_id', 'de_questionId_suggestions', false);
                }, 200);
            }
        });
    }
});
</script>
