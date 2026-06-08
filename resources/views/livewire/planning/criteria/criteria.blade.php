<div class="card">
    <div class="card-header thoth-card-header mb-0 pb-0">
        <div class="thoth-card-badge"><b>12</b></div>
        <x-helpers.modal target="criteria" modalTitle="{{ __('project/planning.criteria.title') }}"
                         modalContent="{!! __('project/planning.criteria.help.content') !!}" />
    </div>
    <div class="card-body">

        {{-- Formulário de criação/edição --}}
        <form wire:submit="submit" class="d-flex flex-column">
            <div class="d-flex flex-column gap-2 form-group">
                <div class="gap-2 form-group">
                    <div class="w-25">
                        <x-input maxlength="20" id="criteriaId"
                                 label="{{ __('project/planning.criteria.form.id') }}"
                                 wire:model="criteriaId" placeholder="ID" required />
                        @error('criteriaId')
                        <span class="text-xs text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-75">
                        <x-input id="description"
                                 label="{{ __('project/planning.criteria.form.description') }}"
                                 wire:model="description"
                                 placeholder="{{ __('project/planning.criteria.form.enter_description') }}" required />
                        @error('description')
                        <span class="text-xs text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="d-flex flex-column w-40">
                    <x-select wire:model="type"
                              label="{{ __('project/planning.criteria.form.type') }}" search required>
                        <option selected disabled>
                            {{ __('project/planning.criteria.form.select-placeholder') }}
                        </option>
                        <option <?= ($type['value'] ?? '') === 'Inclusion' ? 'selected' : '' ?> value="Inclusion">
                            {{ __('project/planning.criteria.form.select-inclusion') }}
                        </option>
                        <option <?= ($type['value'] ?? '') === 'Exclusion' ? 'selected' : '' ?> value="Exclusion">
                            {{ __('project/planning.criteria.form.select-exclusion') }}
                        </option>
                    </x-select>
                    @error('type.value')
                    <span class="text-xs text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-helpers.submit-button isEditing="{{ $form['isEditing'] }}" fitContent>
                        {{ $form['isEditing']
                            ? __('project/planning.criteria.form.update')
                            : __('project/planning.criteria.form.add') }}
                        <div wire:loading>
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </x-helpers.submit-button>
                </div>
            </div>
        </form>

        {{-- Tabelas --}}
        <div class="d-flex flex-column gap-4">

            {{-- Tabela de inclusão --}}
            <div class="flex-column d-flex px-2 py-1">
                <h6 class="px-2">
                    {{ __('project/planning.criteria.inclusion-table.title') }}
                </h6>
                <div class="overflow-auto" style="max-height: 300px">
                    <table class="table table-responsive table-hover">
                        <thead class="table-light sticky-top custom-gray-text" style="color: #676a72">
                        <tr>
                            <th style="border-radius: 0.75rem 0 0 0; padding: 0.5rem 1rem;"></th>
                            <th style="padding: 0.5rem 1rem;">ID</th>
                            <th style="padding: 0.5rem 0.75rem">
                                {{ __('project/planning.criteria.inclusion-table.description') }}
                            </th>
                            <th style="border-radius: 0 0.75rem 0 0; padding: 0.5rem 1rem;">
                                {{ __('project/planning.criteria.table.actions') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($criterias as $criteria)
                            @if ($criteria->type === 'Inclusion')
                                <tr class="px-4" data-item="search-criterias"
                                    wire:key="{{ $criteria->id_criteria }}">
                                    <td>
                                        <input type="checkbox"
                                               wire:key="{{ $criteria->pre_selected }}"
                                               wire:change="changePreSelected({{ $criteria->id_criteria }}, 'Inclusion')"
                                                <?= $criteria->pre_selected === 1 ? 'checked' : '' ?> />
                                    </td>
                                    <td>{{ $criteria->id }}</td>
                                    <td>
                                            <span class="block text-wrap text-break" data-search>
                                                {{ $criteria->description }}
                                            </span>
                                    </td>
                                    <td>
                                        <button class="btn py-1 px-3 btn-outline-secondary"
                                                wire:click="edit('{{ $criteria->id_criteria }}')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn py-1 px-3 btn-outline-danger"
                                                wire:click="confirmDelete('{{ $criteria->id_criteria }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <x-helpers.description>
                                        {{ __('project/planning.criteria.table.empty') }}
                                    </x-helpers.description>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="w-50">
                    <x-select wire:model="inclusion_rule"
                              label="{{ __('project/planning.criteria.inclusion-table.rule') }}"
                              style="max-width: 100px"
                              wire:change="selectRule($event.target.value, 'Inclusion')" search>
                        <option value="ALL"
                                <?= ($inclusion_rule['value'] ?? '') === 'ALL' ? 'selected' : '' ?>>
                            {{ __('project/planning.criteria.table.all') }}
                        </option>
                        <option value="ANY"
                                <?= ($inclusion_rule['value'] ?? '') === 'ANY' ? 'selected' : '' ?>>
                            {{ __('project/planning.criteria.table.any') }}
                        </option>
                        <option value="AT_LEAST"
                                <?= ($inclusion_rule['value'] ?? '') === 'AT_LEAST' ? 'selected' : '' ?>>
                            {{ __('project/planning.criteria.table.at-least') }}
                        </option>
                    </x-select>
                </div>
            </div>

            {{-- Tabela de exclusão --}}
            <div class="d-flex flex-column gap-1">
                <h6 class="px-2">
                    {{ __('project/planning.criteria.exclusion-table.title') }}
                </h6>
                <div class="overflow-auto" style="max-height: 300px">
                    <table class="table table-responsive table-hover">
                        <thead class="table-light sticky-top custom-gray-text" style="color: #676a72">
                        <tr>
                            <th style="border-radius: 0.75rem 0 0 0; padding: 0.5rem 1rem;"></th>
                            <th style="padding: 0.5rem 1rem;">ID</th>
                            <th style="padding: 0.5rem 0.75rem">
                                {{ __('project/planning.criteria.inclusion-table.description') }}
                            </th>
                            <th style="border-radius: 0 0.75rem 0 0; padding: 0.5rem 1rem;">
                                {{ __('project/planning.criteria.table.actions') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($criterias as $criteria)
                            @if ($criteria->type === 'Exclusion')
                                <tr class="px-4" data-item="search-criterias"
                                    wire:key="{{ $criteria->id_criteria }}">
                                    <td>
                                        <input type="checkbox"
                                               wire:key="{{ $criteria->pre_selected }}"
                                               wire:change="changePreSelected({{ $criteria->id_criteria }}, 'Exclusion')"
                                                <?= $criteria->pre_selected === 1 ? 'checked' : '' ?> />
                                    </td>
                                    <td>{{ $criteria->id }}</td>
                                    <td>
                                            <span class="block text-wrap text-break" data-search>
                                                {{ $criteria->description }}
                                            </span>
                                    </td>
                                    <td>
                                        <button class="btn py-1 px-3 btn-outline-secondary"
                                                wire:click="edit('{{ $criteria->id_criteria }}')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn py-1 px-3 btn-outline-danger"
                                                wire:click="confirmDelete('{{ $criteria->id_criteria }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <x-helpers.description>
                                        {{ __('project/planning.criteria.table.empty') }}
                                    </x-helpers.description>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="w-50">
                    <x-select wire:model="exclusion_rule"
                              label="{{ __('project/planning.criteria.exclusion-table.rule') }}"
                              style="width: 100px"
                              wire:change="selectRule($event.target.value, 'Exclusion')" search>
                        <option value="ALL"
                                <?= ($exclusion_rule['value'] ?? '') === 'ALL' ? 'selected' : '' ?>>
                            {{ __('project/planning.criteria.table.all') }}
                        </option>
                        <option value="ANY"
                                <?= ($exclusion_rule['value'] ?? '') === 'ANY' ? 'selected' : '' ?>>
                            {{ __('project/planning.criteria.table.any') }}
                        </option>
                        <option value="AT_LEAST"
                                <?= ($exclusion_rule['value'] ?? '') === 'AT_LEAST' ? 'selected' : '' ?>>
                            {{ __('project/planning.criteria.table.at-least') }}
                        </option>
                    </x-select>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: confirmação de exclusão --}}
    <div wire:ignore>
        <div id="deleteConfirmModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ __('project/planning.criteria.delete.title') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @if ($deletionHasEvaluations)
                            <div class="alert alert-warning d-flex align-items-center gap-2">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>{{ __('project/planning.criteria.delete.warning_evaluations') }}</span>
                            </div>
                        @endif
                        <p>{{ __('project/planning.criteria.delete.confirm_message') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('project/planning.criteria.delete.cancel') }}
                        </button>
                        <button type="button"
                                class="btn {{ $deletionHasEvaluations ? 'btn-danger' : 'btn-outline-danger' }}"
                                wire:click="delete('{{ $confirmingDeleteId }}')"
                                data-bs-dismiss="modal">
                            {{ __('project/planning.criteria.delete.confirm') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: confirmação de submit com impacto em avaliações --}}
    <div wire:ignore>
        <div id="submitConfirmModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ __('project/planning.criteria.submit.warning_title') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning d-flex align-items-center gap-2">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>{{ __('project/planning.criteria.submit.warning_evaluations') }}</span>
                        </div>
                        <p>{{ __('project/planning.criteria.submit.confirm_message') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                wire:click="resetFields">
                            {{ __('project/planning.criteria.submit.cancel') }}
                        </button>
                        <button type="button" class="btn btn-danger"
                                wire:click="confirmSubmit"
                                data-bs-dismiss="modal">
                            {{ __('project/planning.criteria.submit.confirm') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        $wire.on('criteria', ([{ message, type }]) => {
            toasty({ message, type });
        });

        $wire.on('openDeleteConfirm', () => {
            const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            modal.show();
        });

        $wire.on('openSubmitConfirm', () => {
            const modal = new bootstrap.Modal(document.getElementById('submitConfirmModal'));
            modal.show();
        });
    </script>
    @endscript
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form  = document.querySelector('form[wire\\:submit]');
        const input = document.querySelector('#criteriaId');

        if (form && input) {
            form.addEventListener('submit', function () {
                const value = input.value.trim();
                if (value) {
                    const storageKey  = `suggestions_${input.id || input.name}`;
                    let suggestions   = [];

                    if (localStorage.getItem(storageKey)) {
                        suggestions = JSON.parse(localStorage.getItem(storageKey));
                    }

                    if (!suggestions.includes(value)) {
                        suggestions.push(value);
                        localStorage.setItem(storageKey, JSON.stringify(suggestions));
                    }

                    setTimeout(() => {
                        refreshSuggestions('criteriaId', 'criteria_id', 'criteriaId_suggestions', false);
                    }, 200);
                }
            });
        }
    });
</script>
