<div class="card">
    <div class="card-header mb-0 pb-0">
        <x-helpers.modal
            target="criteria"
            modalTitle="{{ __('project/planning.criteria.title') }}"
            modalContent="{!!  __('project/planning.criteria.help.content') !!}"
        />
    </div>
    <div class="card-body">
        <form wire:submit="submit" class="d-flex flex-column">
            <div class="d-flex flex-column gap-2 form-group">
                <div class="d-flex gap-2 form-group">
                    <!-- Primeira Div -->
                    <div class="w-25">
                        <x-input
                            maxlength="20"
                            id="criteriaId"
                            label="{{ __('project/planning.criteria.form.id') }}"
                            wire:model="criteriaId"
                            placeholder="ID"
                            required
                            autocomplete="on"
                            name="criteria_id"
                            list="criteriaId_suggestions"
                        />
                        @error("criteriaId")
                        <span class="text-xs text-danger">
                {{ $message }}
            </span>
                        @enderror
                    </div>

                    <!-- Segunda Div -->
                    <div class="w-75">
                        <x-input
                            id="description"
                            label="{{ __('project/planning.criteria.form.description') }}"
                            wire:model="description"
                            placeholder="{{ __('project/planning.criteria.form.enter_description') }}"
                            required
                        />
                        @error("description")
                        <span class="text-xs text-danger">
                {{ $message }}
            </span>
                        @enderror
                    </div>
                </div>

                <div class="d-flex flex-column w-40 ">
                    <x-select
                        wire:model="type"
                        label="{{ __('project/planning.criteria.form.type') }}"
                        search
                        required
                    >
                        <option selected disabled>
                            {{ __("project/planning.criteria.form.select-placeholder") }}
                        </option>
                        <option
                            <?= ($type["value"] ?? "") === "Inclusion" ? "selected" : "" ?>
                            value="Inclusion"
                        >
                            {{ __("project/planning.criteria.form.select-inclusion") }}
                        </option>
                        <option
                            <?= ($type["value"] ?? "") === "Exclusion" ? "selected" : "" ?>
                            value="Exclusion"
                        >
                            {{ __("project/planning.criteria.form.select-exclusion") }}
                        </option>
                    </x-select>
                </div>
                <div>
                    <x-helpers.submit-button
                        isEditing="{{ $form['isEditing'] }}"
                        fitContent
                    >
                        {{
                            $form["isEditing"]
                                ? __("project/planning.criteria.form.update")
                                : __("project/planning.criteria.form.add")
                        }}
                        <div wire:loading>
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </x-helpers.submit-button>
                </div>
            </div>

        </form>
        <div class="grid-items-2 gap-4">
            <div class="flex-column d-flex px-2 py-1">
                <h6 class="px-2">
                    {{ __("project/planning.criteria.inclusion-table.title") }}
                </h6>
                <div class="overflow-auto" style="max-height: 300px">
                    <table class="table table-responsive table-hover">
                        <thead
                            class="table-light sticky-top custom-gray-text"
                            style="color: #676a72"
                        >
                            <tr>
                                <th
                                    style="
                                        border-radius: 0.75rem 0 0 0;
                                        padding: 0.5rem 1rem;
                                    "
                                ></th>
                                <th
                                    style="
                                        border-radius: 0 0 0 0;
                                        padding: 0.5rem 1rem;
                                    "
                                >
                                    ID
                                </th>
                                <th style="padding: 0.5rem 0.75rem">
                                    {{ __("project/planning.criteria.inclusion-table.description") }}
                                </th>
                                <th
                                    style="
                                        border-radius: 0 0.75rem 0 0;
                                        padding: 0.5rem 1rem;
                                    "
                                >
                                    {{ __("project/planning.criteria.table.actions") }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($criterias as $criteria)
                                @if ($criteria->type === "Inclusion")
                                    <tr
                                        class="px-4"
                                        data-item="search-criterias"
                                        wire:key="{{ $criteria->id_research_criteria }}"
                                    >
                                        <td>
                                            <input
                                                wire:key="{{ $criteria->pre_selected }}"
                                                type="checkbox"
                                                wire:model="selectedRows"
                                                wire:change="changePreSelected({{ $criteria->id_criteria }}, 'Inclusion')"
                                                <?= $criteria->pre_selected === 1 ? "checked" : "" ?>
                                            />
                                        </td>
                                        <td>{{ $criteria->id }}</td>
                                        <td>
                                            <span
                                                class="block text-wrap text-break"
                                                data-search
                                            >
                                                {{ $criteria->description }}
                                            </span>
                                        </td>
                                        <td>
                                            <button
                                                class="btn py-1 px-3 btn-outline-secondary"
                                                wire:click="edit('{{ $criteria->id_criteria }}')"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button
                                                class="btn py-1 px-3 btn-outline-danger"
                                                wire:click="delete('{{ $criteria->id_criteria }}')"
                                                wire:target="delete('{{ $criteria->id_criteria }}')"
                                                wire:loading.attr="disabled"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <x-helpers.description>
                                            {{ __("project/planning.criteria.table.empty") }}
                                        </x-helpers.description>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="w-50">
                    <x-select
                        wire:model="inclusion_rule"
                        label="{{ __('project/planning.criteria.inclusion-table.rule') }}"
                        style="max-width: 100px"
                        wire:change="selectRule($event.target.value, 'Inclusion')"
                        search
                    >
                        <option
                            value="ALL"
                            <?= ($inclusion_rule["value"] ?? "") === "ALL" ? "selected" : "" ?>
                        >
                            {{ __("project/planning.criteria.table.all") }}
                        </option>
                        <option
                            value="ANY"
                            <?= ($inclusion_rule["value"] ?? "") === "ANY" ? "selected" : "" ?>
                        >
                            {{ __("project/planning.criteria.table.any") }}
                        </option>
                        <option
                            value="AT_LEAST"
                            <?= ($inclusion_rule["value"] ?? "") === "AT_LEAST" ? "selected" : "" ?>
                        >
                            {{ __("project/planning.criteria.table.at-least") }}
                        </option>
                    </x-select>
                </div>
            </div>
            <div class="d-flex flex-column gap-1">
                <h6 class="px-2">
                    {{ __("project/planning.criteria.exclusion-table.title") }}
                </h6>
                <div class="overflow-auto" style="max-height: 300px">
                    <table class="table table-responsive table-hover">
                        <thead
                            class="table-light sticky-top custom-gray-text"
                            style="color: #676a72"
                        >
                            <tr>
                                <th
                                    style="
                                        border-radius: 0.75rem 0 0 0;
                                        padding: 0.5rem 1rem;
                                    "
                                ></th>
                                <th
                                    style="
                                        border-radius: 0 0 0 0;
                                        padding: 0.5rem 1rem;
                                    "
                                >
                                    ID
                                </th>
                                <th style="padding: 0.5rem 0.75rem">
                                    {{ __("project/planning.criteria.inclusion-table.description") }}
                                </th>
                                <th
                                    style="
                                        border-radius: 0 0.75rem 0 0;
                                        padding: 0.5rem 1rem;
                                    "
                                >
                                    {{ __("project/planning.criteria.table.actions") }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($criterias as $criteria)
                                @if ($criteria->type === "Exclusion")
                                    <tr
                                        class="px-4"
                                        data-item="search-criterias"
                                        wire:key="{{ $criteria->id_research_criteria }}"
                                    >
                                        <td>
                                            <input
                                                wire:key="{{ $criteria->pre_selected }}"
                                                type="checkbox"
                                                wire:change="changePreSelected({{ $criteria->id_criteria }}, 'Exclusion')"
                                                <?= $criteria->pre_selected === 1 ? "checked" : "" ?>
                                            />
                                        </td>
                                        <td>
                                            {{ $criteria->id }}
                                        </td>
                                        <td>
                                            <span
                                                class="block text-wrap text-break"
                                                data-search
                                            >
                                                {{ $criteria->description }}
                                            </span>
                                        </td>
                                        <td>
                                            <button
                                                class="btn py-1 px-3 btn-outline-secondary"
                                                wire:click="edit('{{ $criteria->id_criteria }}')"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button
                                                class="btn py-1 px-3 btn-outline-danger"
                                                wire:click="delete('{{ $criteria->id_criteria }}')"
                                                wire:target="delete('{{ $criteria->id_criteria }}')"
                                                wire:loading.attr="disabled"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <x-helpers.description>
                                            {{ __("project/planning.criteria.table.empty") }}
                                        </x-helpers.description>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="w-50">
                    <x-select
                        wire:model="exclusion_rule"
                        label="{{ __('project/planning.criteria.exclusion-table.rule') }}"
                        style="width: 100px"
                        wire:change="selectRule($event.target.value, 'Exclusion')"
                        search
                    >
                        <option
                            value="ALL"
                            <?= ($exclusion_rule["value"] ?? "") === "ALL" ? "selected" : "" ?>
                        >
                            {{ __("project/planning.criteria.table.all") }}
                        </option>
                        <option
                            value="ANY"
                            <?= ($exclusion_rule["value"] ?? "") === "ANY" ? "selected" : "" ?>
                        >
                            {{ __("project/planning.criteria.table.any") }}
                        </option>
                        <option
                            value="AT_LEAST"
                            <?= ($exclusion_rule["value"] ?? "") === "AT_LEAST" ? "selected" : "" ?>
                        >
                            {{ __("project/planning.criteria.table.at-least") }}
                        </option>
                    </x-select>
                </div>
            </div>
        </div>
    </div>
    @script
        <script>
            $wire.on('criteria', ([{ message, type }]) => {
                toasty({ message, type });
            });
        </script>
    @endscript
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[wire\\:submit]');
    const input = document.querySelector('#criteriaId');
    
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
                    refreshSuggestions('criteriaId', 'criteria_id', 'criteriaId_suggestions', false);
                }, 200);
            }
        });
    }
});
</script>
