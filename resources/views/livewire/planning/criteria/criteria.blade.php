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

                <div class="d-flex flex-column w-75">
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

                <div class="d-flex flex-column w-100 w-md-25">
                    <x-select
                        wire:model="type"
                        label="{{ __('project/planning.criteria.form.type') }}"
                        search
                    >
                        <option selected disabled>
                            {{ __("project/planning.criteria.form.select-placeholder") }}
                        </option>
                        <option
                            <?= $type["value"] === "Inclusion" ? "selected" : "" ?>
                            value="Inclusion"
                        >
                            {{ __("project/planning.criteria.form.select-inclusion") }}
                        </option>
                        <option
                            <?= $type["value"] === "Exclusion" ? "selected" : "" ?>
                            value="Exclusion"
                        >
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
                </div>
                <div class="w-50">
                    <x-select
                        wire:model="pre_selected_inclusion"
                        label="{{ __('project/planning.criteria.inclusion-table.rule') }}"
                        style="max-width: 100px"
                        search
                    >
                        <option
                            value="0"
                            <?= $pre_selected_inclusion["value"] === 0 ? "selected" : "" ?>
                        >
                            {{ __("project/planning.criteria.table.all") }}
                        </option>
                        <option
                            value="1"
                            <?= $pre_selected_inclusion["value"] === 1 ? "selected" : "" ?>
                        >
                            {{ __("project/planning.criteria.table.any") }}
                        </option>
                        <option
                            value="2"
                            <?= $pre_selected_inclusion["value"] === 2 ? "selected" : "" ?>
                        >
                            {{ __("project/planning.criteria.table.at-least") }}
                        </option>
                    </x-select>
                    <button
                        type="button"
                        class="mt-2 btn-sm btn btn-primary px-3"
                        wire:click="updateCriteriaRule('Inclusion')"
                    >
                        <i class="fa fa-plus"></i>
                    </button>
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
                <div class="w-50">
                    <x-select
                        wire:model="pre_selected_exclusion"
                        label="{{ __('project/planning.criteria.exclusion-table.rule') }}"
                        style="width: 100px"
                        search
                    >
                        <option
                            value="0"
                            <?= $pre_selected_exclusion["value"] === 0 ? "selected" : "" ?>
                        >
                            {{ __("project/planning.criteria.table.all") }}
                        </option>
                        <option
                            value="1"
                            <?= $pre_selected_exclusion["value"] === 1 ? "selected" : "" ?>
                        >
                            {{ __("project/planning.criteria.table.any") }}
                        </option>
                        <option
                            value="2"
                            <?= $pre_selected_exclusion["value"] === 2 ? "selected" : "" ?>
                        >
                            {{ __("project/planning.criteria.table.at-least") }}
                        </option>
                    </x-select>
                    <button
                        type="button"
                        class="mt-2 btn-sm btn btn-primary px-3"
                        wire:click="updateCriteriaRule('Exclusion')"
                    >
                        <i class="fa fa-plus"></i>
                    </button>
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
