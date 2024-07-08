<div class="card">
    <div class="card-header mt-2 mb-0 pb-0">
        <x-helpers.modal
            target="search-string"
            modalTitle="{{ __('project/planning.search-string.title') }}"
            modalContent="{{ __('project/planning.search-string.help') }}"
        />
    </div>
    <div class="card-body">
        <div>
            <div class="d-flex flex-column">
                <label for="description" class="form-control-label mx-0 mb-1">
                    {{ __("project/planning.search-string.form.description") }}
                </label>
                <textarea
                    class="form-control"
                    maxlength="255"
                    rows="4"
                    id="description"
                    wire:blur="lulu"
                    placeholder="{{ __("project/planning.search-string.form.enter-description") }}"
                ></textarea>
            </div>
            @forelse ($project->databases as $projectDatabase)
                <div class="d-flex flex-column mt-3">
                    <label
                        for="database-{{ $projectDatabase->id }}"
                        class="form-control-label mx-0 mb-1"
                    >
                        {{ $projectDatabase->name }}
                    </label>
                    <textarea
                        class="form-control"
                        maxlength="255"
                        rows="4"
                        id="database-{{ $projectDatabase->id }}"
                        wire:model="databases.{{ $projectDatabase->id }}"
                        placeholder="{{ __("project/planning.search-string.form.enter-description") }}"
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
