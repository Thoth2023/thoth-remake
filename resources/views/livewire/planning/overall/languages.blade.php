<div class="card-body w-sm-50">
    <div class="card">
        <div class="card-header mb-0 pb-0">
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
                    >
                        <option value="">
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
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <x-helpers.description>
                        {{ __("project/planning.overall.domain.list.empty") }}
                    </x-helpers.description>
                @endforelse
                <x-search.empty target="search-domains">
                    {{ __("project/planning.overall.domain.list.no-results") }}
                </x-search.empty>
            </div>
        </div>
    </div>
</div>
