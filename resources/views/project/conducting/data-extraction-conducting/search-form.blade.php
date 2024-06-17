<div class="card mb-0 mt-5">
    <div class="card-header mb-0 pb-0">
        <x-helpers.modal target="search-domains" modalTitle="{{ __('project/conducting.search.help.title') }}"
            modalContent="{{ __('project/conducting.search.help.content') }}" />
    </div>
    <div class="card-body">
        <form wire:submit="submit" class="d-flex flex-column">
            <div class="form-group">
                <x-select wire:model="study" label="{{ __('project/conducting.search.help.title') }}">
                    <option selected disabled>{{ __('project/conducting.search.placeholder') }}</option>
                </x-select>
                @error('study')
                    <span class="text-xs text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <x-helpers.submit-button>
                    {{ __('project/conducting.search.add') }}
                    <div wire:loading><i class="fas fa-spinner fa-spin"></i></div>
                </x-helpers.submit-button>
            </div>
        </form>
        <hr style="opacity: 10%" />
        <div class="overflow-auto px-2 py-1" style="max-height: 300px">
            <div class="d-flex justify-content-between">
            </div>
            <div class="d-flex justify-content-between">
                <span data-search>Estudo 3</span>
                <div>
                    <button href="#" class="btn py-1 px-3 btn-outline-primary" title="Cópia CSV"><i
                            class="fas fa-file-csv"></i></a>
                    <button href="#" class="btn py-1 px-3 btn-outline-primary" title="Cópia XML"><i
                            class="fas fa-file-code"></i></a>
                    <button href="#" class="btn py-1 px-3 btn-outline-primary" title="Exportar para PDF"><i
                            class="fas fa-file-pdf"></i></a>
                    <button href="#" class="btn py-1 px-3 btn-outline-primary" title="Imprimir"><i
                            class="fas fa-print"></i></a>
                    <button class="btn py-1 px-3 btn-outline-danger" wire:click="delete(3)" wire:target="delete(3)"
                        wire:loading.attr="disabled">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
