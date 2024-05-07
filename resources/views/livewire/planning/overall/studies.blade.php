<div class="card">
    <div class="card-header mb-0 pb-0">
        <x-helpers.modal
            target="search-domains"
            modalTitle="{{ __('project/planning.overall.study_type.help.title') }}"
            modalContent="{{ __('project/planning.overall.study_type.help.content') }}"
        />
    </div>
    <div class="card-body">
        <form wire:submit="submit" class="d-flex flex-column">
            <div class="form-group">
                <x-select
                    wire:model="studyType"
                    label="{{ __('project/planning.overall.study_type.help.title') }}"
                >
                    <option selected disabled>
                        {{ __("project/planning.overall.study_type.list.select.placeholder") }}
                    </option>
                    @foreach ($studies as $studyType)
                        <option value="{{ $studyType->id_study_type }}">
                            {{ $studyType->description }}
                        </option>
                    @endforeach
                </x-select>
                @error("studyType")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div>
                <x-helpers.submit-button>
                    {{ __("project/planning.overall.study_type.add") }}
                    <div wire:loading>
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </x-helpers.submit-button>
            </div>
        </form>
        <hr style="opacity: 10%" />
        <div class="overflow-auto px-2 py-1" style="max-height: 300px">
            @forelse ($project->studyTypes as $projectStudyType)
                <div class="d-flex justify-content-between">
                    <span data-search>
                        {{ $projectStudyType->description }}
                    </span>
                    <div>
                        <button
                            class="btn py-1 px-3 btn-outline-danger"
                            wire:click="delete({{ $projectStudyType->id_study_type }})"
                            wire:target="delete({{ $projectStudyType->id_study_type }})"
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
        $wire.on('studies', ([{ message, type }]) => {
            toasty({ message, type });
        });
    </script>
@endscript
