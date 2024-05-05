<div class="card">
    <div class="card-header mb-0 pb-0">
        <x-helpers.modal
            target="search-domains"
            modalTitle="{{ __('project/planning.overall.keyword.help.title') }}"
            modalContent="{{ __('project/planning.overall.keyword.help.content') }}"
        />
    </div>
    <div class="card-body">
        <form wire:submit="submit" class="d-flex flex-column">
            <div class="form-group">
                <x-input
                    id="description"
                    label="{{ __('project/planning.overall.keyword.description') }}"
                    wire:model="description"
                    placeholder="Digite a descrição da palavra-chave"
                />
                @error("description")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div>
                <x-helpers.submit-button isEditing="{{ $form['isEditing'] }}">
                    {{
                        $form["isEditing"]
                            ? __("project/planning.overall.domain.update")
                            : __("project/planning.overall.domain.add")
                    }}
                    <div wire:loading>
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </x-helpers.submit-button>
            </div>
        </form>
        <x-search.input class="mt-3" target="search-keywords" />
        <hr style="opacity: 10%" />
        <div class="overflow-auto px-2 py-1" style="max-height: 300px">
            @forelse ($keywords as $keyword)
                <x-search.item
                    wire:key="{{ $keyword->id_keyword }}"
                    target="search-keywords"
                    class="d-flex justify-content-between"
                >
                    <span class="text-break" data-search>
                        {{ $keyword->description }}
                    </span>
                    <div>
                        <button
                            class="btn py-1 px-3 btn-outline-secondary"
                            wire:click="edit({{ $keyword->id_keyword }})"
                        >
                            <i class="fas fa-edit"></i>
                        </button>
                        <button
                            class="btn py-1 px-3 btn-outline-danger"
                            wire:click="delete({{ $keyword->id_keyword }})"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </x-search.item>
            @empty
                <x-helpers.description>
                    {{ __("project/planning.overall.keyword.list.empty") }}
                </x-helpers.description>
            @endforelse
            <x-search.empty target="search-keywords">
                {{ __("project/planning.overall.no-results") }}
            </x-search.empty>
        </div>
    </div>
</div>
