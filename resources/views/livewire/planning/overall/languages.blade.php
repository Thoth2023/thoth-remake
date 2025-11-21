<div class="card">
    <div class="card-header thoth-card-header mb-0 pb-0">

        <!-- Badge numérico moderno -->
        <div class="thoth-card-badge"><b>2</b></div>
        <x-helpers.modal
            target="search-domains"
            modalTitle="{{ __('project/planning.overall.language.help.title') }}"
            modalContent="{{ __('project/planning.overall.language.help.content') }}"
        />
    </div>
    <div class="card-body">
        <form wire:submit="submit" class="d-flex flex-column">
            <div class="form-group">
                <x-select
                    wire:model="language"
                    label="{{ __('project/planning.overall.language.help.title') }}"
                    required
                >
                    <option selected disabled>
                        {{ __("project/planning.overall.language.list.select.placeholder") }}
                    </option>
                    @foreach ($languages as $language)
                        <option value="{{ $language->id_language }}">
                            {{ $language->description }}
                        </option>
                    @endforeach
                </x-select>
                @error("language")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div>
                <x-helpers.submit-button>
                    {{ __("project/planning.overall.language.add") }}
                    <div wire:loading>
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </x-helpers.submit-button>
            </div>
        </form>
        <hr style="opacity: 10%" />
        <div class="overflow-auto px-2 py-1" style="max-height: 300px">
            @forelse ($project->languages as $projectLanguage)
                <div class="d-flex justify-content-between">
                    <span data-search>
                        {{ $projectLanguage->description }}
                    </span>
                    <div>
                        <button
                            class="btn py-1 px-3 btn-outline-danger"
                            wire:click="delete({{ $projectLanguage->id_language }})"
                            wire:target="delete({{ $projectLanguage->id_language }})"
                            wire:loading.attr="disabled"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            @empty
                <x-helpers.description>
                    {{ __("project/planning.overall.study_type.list.empty") }}
                </x-helpers.description>
            @endforelse
        </div>
    </div>
</div>

@script
    <script>
        $wire.on('languages', ([{ message, type }]) => {
            toasty({ message, type });
        });
    </script>
@endscript
