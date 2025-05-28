<div class="d-flex flex-column gap-4">
    <div class="card">
        <div class="card-header mb-2 pb-0">
            <x-helpers.modal
                target="search-string"
                modalTitle="{{ __('project/planning.search-string.term.title') }}"
                modalContent="{{ __('project/planning.search-string.term.help') }}"
            />
        </div>
        <div class="card-body">
            <form wire:submit.prevent="submit" class="d-flex flex-column">
                <div class="d-flex flex-column gap-2 form-group">
                    <x-input
                        class="w-md-25 w-100"
                        maxlength="50"
                        id="description"
                        label="{{ __('project/planning.search-string.term.form.title') }}"
                        wire:model="description"
                        placeholder="{{ __('project/planning.search-string.term.form.placeholder') }}"
                        pattern="[A-Za-zÀ-ÿ\s]+"
                        required
                    />
                    @error("description")
                        <span class="text-xs text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div>
                    <x-helpers.submit-button
                        isEditing="{{ $form['isEditing'] }}"
                    >
                        {{
                            $form["isEditing"]
                                ? __("project/planning.search-string.term.form.update")
                                : __("project/planning.search-string.term.form.add")
                        }}
                        <div wire:loading>
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </x-helpers.submit-button>
                </div>
            </form>
            <div class="d-flex gap-3">
                <div class="w-md-50 w-100">
                    <x-select
                        wire:model="termId"
                        label="{{ __('project/planning.search-string.term.form.select') }}"
                        wire:change="getSynonymSuggestions($event.target.value)"
                        required
                    >
                        <option selected disabled>
                            {{ __("project/planning.search-string.term.form.select-placeholder") }}
                        </option>
                        @foreach ($terms as $term)
                            <option
                                value="{{ $term->id_term }}"
                                <?= $term->id_term == ($termId["value"] ?? "") ? "selected" : "" ?>
                            >
                                {{ $term->description }}
                            </option>
                        @endforeach
                    </x-select>
                    @error("termId")
                        <span class="text-xs text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <form
                    wire:submit.prevent="addSynonyms"
                    class="d-flex flex-column w-100"
                >
                    <div class="d-flex gap-3" style="margin-bottom: 5px">
                        <div class="d-flex gap-1">
                            <x-input
                                class="w-100"
                                maxlength="50"
                                id="synonym"
                                label="{{ __('project/planning.search-string.synonym.form.title') }}"
                                wire:model="synonym"
                                placeholder="{{ __('project/planning.search-string.synonym.form.placeholder') }}"
                                pattern="[A-Za-zÀ-ÿ\s]+"
                                required
                            />
                            @error("synonym")
                                <span class="text-xs text-danger">
                                    {{ $message }}
                                </span>
                            @enderror

                            <div style="display: flex; align-items: end">
                                <x-helpers.submit-button
                                    isEditing="{{ $form['isEditing'] }}"
                                    style="
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        width: 38px;
                                        height: 38px;
                                        padding: 5px;
                                        margin-bottom: 6px;
                                    "
                                >
                                    <div wire:loading>
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </div>
                                </x-helpers.submit-button>
                            </div>
                        </div>

                        <div class="w-25" style="margin-bottom: 5px">
                            <x-select
                                wire:model="languageSynonyms"
                                label="{{ __('project/planning.search-string.term.form.language') }}"
                                wire:change="generateSynonyms"
                            >
                                <option
                                    value="en"
                                    <?= $languageSynonyms["value"] == "en" ? "selected" : "" ?>
                                >
                                    English
                                </option>
                                <option
                                    value="pt"
                                    <?= $languageSynonyms["value"] == "pt" ? "selected" : "" ?>
                                >
                                    Português
                                </option>
                            </x-select>
                        </div>
                    </div>
                    <div
                        style="
                            max-height: 150px;
                            overflow-y: auto;
                            margin: 0;
                            margin-bottom: 1rem;
                        "
                    >
                        @if (($termId["value"] ?? null) && count($synonymSuggestions) === 0)
                            <span class="text-sm text-warning">
                                {{ __("project/planning.search-string.term.form.no-suggestions") }}
                            </span>
                        @endif

                        @foreach ($synonymSuggestions as $suggestion)
                            @if ($synonym !== $suggestion)
                                <div
                                    class="d-flex align-items-center gap-2 form-group w-100 my-0"
                                >
                                    <x-input
                                        value="{{ $suggestion }}"
                                        placeholder="{{ __('project/planning.search-string.synonym.form.placeholder') }}"
                                        class="my-0"
                                    />
                                    <button
                                        type="button"
                                        class="btn btn-success"
                                        wire:click="addSuggestionSynonym('{{ $suggestion }}')"
                                        style="
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            width: 38px;
                                            height: 38px;
                                            padding: 5px;
                                            margin: 0;
                                        "
                                    >
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </form>
            </div>
            <div class="overflow-auto px-2 py-1" style="max-height: 500px">
                <table class="table table-responsive table-hover">
                    <thead
                        class="table-light sticky-top custom-gray-text"
                        style="color: #676a72"
                    >
                        <th
                            style="
                                padding: 0.5rem 0.75rem;
                                border-radius: 0.75rem 0 0 0;
                            "
                        ></th>
                        <th>
                            {{ __("project/planning.search-string.term.table.description") }}
                        </th>
                        <th
                            style="
                                border-radius: 0 0.75rem 0 0;
                                padding: 0.5rem 1rem;
                            "
                        >
                            {{ __("project/planning.search-string.term.table.actions") }}
                        </th>
                    </thead>
                    <tbody>
                        @forelse ($terms as $term)
                            <tr class="px-4" data-item="search-terms">
                                <td>
                                    @if ($term->synonyms->isNotEmpty())
                                        <x-table.accordion-button />
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="block text-wrap text-break"
                                        data-search
                                    >
                                        {{ $term->description }}
                                    </span>
                                </td>
                                <td>
                                    <button
                                        class="btn py-1 px-3 btn-outline-secondary"
                                        wire:click="edit('{{ $term->id_term }}')"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button
                                        class="btn py-1 px-3 btn-outline-danger"
                                        wire:click="delete('{{ $term->id_term }}')"
                                        wire:target="delete('{{ $term->id_term }}')"
                                        wire:loading.attr="disabled"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <x-table.accordion-content>
                                <td colspan="5">
                                    <div class="d-grid gap-3">
                                        @foreach ($term->synonyms as $synonym)
                                            <div class="table-accordion-item">
                                                <span class="d-flex text-break">
                                                    {{ $synonym->description }}
                                                </span>
                                                <div>
                                                    <button
                                                        wire:click="editSynonym('{{ $synonym->id_synonym }}')"
                                                        class="btn btn-outline-secondary py-0 px-3 m-0"
                                                    >
                                                        <i
                                                            class="fas fa-edit"
                                                        ></i>
                                                    </button>
                                                    <button
                                                        class="btn btn-outline-danger py-0 px-3 m-0"
                                                        wire:click="deleteSynonym('{{ $synonym->id_synonym }}')"
                                                        wire:target="deleteSynonym('{{ $synonym->id_synonym }}')"
                                                        wire:loading.attr="disabled"
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
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">
                                    <x-helpers.description>
                                        {{ __("project/planning.search-string.term.table.empty") }}
                                    </x-helpers.description>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @livewire("planning.search-string.search-string")
</div>

@script
    <script>
        $wire.on('terms', ([{ message, type }]) => {
            toasty({ message, type });
        });
    </script>
@endscript
