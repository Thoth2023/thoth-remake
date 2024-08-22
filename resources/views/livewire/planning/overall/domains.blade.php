<div class="card">
    <div class="card-header mb-0 pb-0">
        <x-helpers.modal
            target="search-domains"
            modalTitle="{{ __('project/planning.overall.domain.help.title') }}"
            modalContent="{!! __('project/planning.overall.domain.help.content') !!}"
        />
    </div>
    <div class="card-body">
        <form wire:submit="submit" class="d-flex flex-column">
            <div class="form-group">
                <x-input
                    id="description"
                    label="{{ __('project/planning.overall.domain.description') }}"
                    wire:model="description"
                    placeholder="{{ __('project/planning.overall.domain.list.headers.enter_description') }}"
                    maxlength="255"
                    required
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
        <x-search.input class="mt-3" target="search-domains" />
        <hr style="opacity: 10%" />
        <div class="overflow-auto px-2 py-1" style="max-height: 300px">
            @forelse ($domains as $domain)
                <x-search.item
                    wire:key="{{ $domain->id_domain }}"
                    target="search-domains"
                    class="d-flex justify-content-between gap-2"
                >
                    <span class="text-break" data-search>
                        {{ $domain->description }}
                    </span>
                    <div style="min-width: fit-content">
                        <button
                            class="btn py-1 px-3 btn-outline-secondary"
                            wire:click="edit({{ $domain->id_domain }})"
                        >
                            <i class="fas fa-edit"></i>
                        </button>
                        <button
                            class="btn py-1 px-3 btn-outline-danger"
                            wire:click="delete({{ $domain->id_domain }})"
                            wire:target="delete({{ $domain->id_domain }})"
                            wire:loading.attr="disabled"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </x-search.item>
                @empty
                <x-helpers.description>
                    {{ __("project/planning.overall.domain.list.empty") }}
                </x-helpers.description>
            @endforelse
            <x-search.empty target="search-domains">
                {{ __("project/planning.overall.no-results") }}
            </x-search.empty>
        </div>
    </div>
</div>

@script
    <script>
        $wire.on('domains', ([{ message, type }]) => {
            toasty({ message, type });
        });
    </script>
@endscript
