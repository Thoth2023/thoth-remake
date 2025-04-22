<div class="card">
    <div class="card-header mt-2 mb-0 pb-0">
        <x-helpers.modal
            target="search-string"
            modalTitle="{{ translationPlanning('search-string.title') }}"
            modalContent="{{ translationPlanning('search-string.help') }}"
        />
        <button
            class="btn btn-sm btn-primary mt-2"
            wire:click="generateAllSearchStrings"
        >
            <i class="fa fa-plus"></i>
            {{ translationPlanning('search-string.generate-all') }}
        </button>
    </div>
    <div class="card-body">
        <div>
            <div class="d-flex flex-column">
                <label for="description" class="form-control-label mx-0 mb-1">
                    {{ translationPlanning('search-string.form.description') }}
                </label>
                <textarea
                    class="form-control"
                    maxlength="750"
                    rows="4"
                    id="description"
                    wire:model="genericDescription"
                    placeholder="{{ translationPlanning('search-string.form.enter-description') }}"
                    wire:change="saveGenericSearchString"
                ></textarea>
            </div>
            @forelse ($project->databases as $projectDatabase)
                <div class="d-flex flex-column mt-3">
                    <label
                        for="database-{{ $loop->index }}"
                        class="form-control-label mx-0 mb-1"
                    >
                        {{ $projectDatabase->name }}
                    </label>
                    <textarea
                        id="database-{{ $loop->index }}"
                        class="form-control"
                        maxlength="750"
                        rows="4"
                        wire:model="descriptions.{{ $loop->index }}"
                        placeholder="{{ translationPlanning('search-string.form.enter-description') }}"
                        wire:change="saveSearchString({{ $projectDatabase->id_database }}, {{ $loop->index }})"
                    ></textarea>
                </div>
            @empty
                <p>{{ __("No databases found for this project.") }}</p>
            @endforelse
            @error("description")
                <span class="text-xs text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>

@script
    <script>
        $wire.on('search-string', ([{ message, type }]) => {
            toasty({ message, type });
        });
    </script>
@endscript
