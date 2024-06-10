<div class="card">
    <div class="card-header mb-0 pb-0">
        <x-helpers.modal
            target="criteria"
            modalTitle="{{ __('project/planning.criteria.title') }}"
            modalContent="{{ __('project/planning.criteria.help.content') }}"
        />
    </div>
    <div class="card-body">
        <form wire:submit="submit" class="d-flex flex-column">
            <div class="d-flex flex-column gap-2 form-group">
                <x-input
                    class="w-md-25 w-100"
                    maxlength="20"
                    id="criteriaId"
                    label="{{ __('project/planning.criteria.form.id') }}"
                    wire:model="criteriaId"
                    placeholder="ID"
                />
                @error("criteriaId")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror

                <div class="d-flex flex-column">
                    <x-input
                        id="description"
                        label="{{ __('project/planning.criteria.form.description') }}"
                        wire:model="description"
                        placeholder="{{ __('project/planning.criteria.form.enter_description') }}"
                    />
                </div>
                @error("description")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror

                <div class="d-flex flex-column">
                    <x-select
                        wire:model="type"
                        label="{{ __('project/planning.criteria.form.type') }}"
                        search
                    >
                        <option selected disabled>
                            {{ __("project/planning.criteria.form.select-placeholder") }}
                        </option>
                        <option value="Inclusion">
                            {{ __("project/planning.criteria.form.select-inclusion") }}
                        </option>
                        <option value="Exclusion">
                            {{ __("project/planning.criteria.form.select-exclusion") }}
                        </option>
                    </x-select>
                </div>
            </div>
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
        </form>
        <h6 class="px-2">
            {{ __("project/planning.criteria.inclusion-table.title") }}
        </h6>
        <div
            class="d-flex gap-4 overflow-auto px-2 py-1"
            style="max-height: 300px"
        >
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
                                    {{ __("project/planning.criterias.table.empty") }}
                                </x-helpers.description>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
        <div class="d-flex gap-2">
            <x-select
                wire:model="pre_selected"
                label="{{ __('project/planning.criteria.inclusion-table.rule') }}"
                search
                wire:click="updateInclusionCriteriaRule()"
            >
                <option value="Todos">
                    {{ __("project/planning.criteria.table.all") }}
                </option>
                <option value="Qualquer">
                    {{ __("project/planning.criteria.table.any") }}
                </option>
                <option value="Pelo menos">
                    {{ __("project/planning.criteria.table.at-least") }}
                </option>
            </x-select>
            <x-select
                wire:model="pre_selected"
                label="{{ __('project/planning.criteria.exclusion-table.rule') }}"
                search
                wire:click="updateExclusionCriteriaRule()"
            >
                <option value="Todos">
                    {{ __("project/planning.criteria.table.all") }}
                </option>
                <option value="Qualquer">
                    {{ __("project/planning.criteria.table.any") }}
                </option>
                <option value="Pelo menos">
                    {{ __("project/planning.criteria.table.at-least") }}
                </option>
            </x-select>
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
