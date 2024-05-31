<div class="d-flex flex-column gap-4">
    <div class="card">
        <div class="card-header mb-0 pb-0">
            <x-helpers.modal
                target="search-domains"
                modalTitle="{{ __('project/planning.databases.title') }}"
                modalContent="{{ __('project/planning.databases.help.content') }}"
            />
        </div>
        <div class="card-body">
            <form wire:submit="submit" class="d-flex flex-column">
                <div class="form-group">
                    <div class="d-flex gap-3 flex-column w-100 w-md-50">
                        <x-select
                            wire:model="database"
                            label="{{ __('project/planning.databases.form.select-placeholder') }}"
                            search
                        >
                            <option selected disabled>
                                {{ __("project/planning.databases.form.select-placeholder") }}
                            </option>
                            @foreach ($databases as $database)
                                <option value="{{ $database->id_database }}">
                                    {{ $database->name }}
                                </option>
                            @endforeach
                        </x-select>
                        <div class="align-self">
                            <x-helpers.submit-button class="mb-0">
                                {{ __("project/planning.databases.form.add-button") }}
                            </x-helpers.submit-button>
                        </div>
                    </div>
                    @error("database")
                        <span class="text-xs text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </form>
        </div>
        <div class="overflow-auto px-4 py-1" style="max-height: 300px">
            <table class="table table-responsive table-hover">
                <thead
                    class="table-light sticky-top custom-gray-text"
                    style="color: #58545b"
                >
                    <th
                        style="
                            border-radius: 0.75rem 0 0 0;
                            padding: 0.5rem 1rem;
                        "
                    >
                    {{ __("project/planning.databases.table.name") }}
                    </th>
                    <th style="padding: 0.5rem 0.75rem">Link</th>
                    <th
                        style="
                            border-radius: 0 0.75rem 0 0;
                            padding: 0.5rem 1rem;
                        "
                    >
                    {{ __("project/planning.databases.table.actions") }}
                    </th>
                </thead>
                <tbody>
                    @forelse ($project->databases as $projectDatabase)
                        <tr>
                            <td class="px-3" data-search>
                                {{ $projectDatabase->name }}
                            </td>
                            <td class="px-2">
                                <a
                                    href="{{ $projectDatabase->link }}"
                                    target="_blank"
                                >
                                    {{ $projectDatabase->link }}
                                </a>
                            </td>
                            <td class="px-3">
                                <x-helpers.confirm-modal
                                    modalTitle="Delete Database"
                                    modalContent="This action <strong>cannot</strong> be undone. This will remove the <b>{{ $projectDatabase->name }}</b> source, and permanently delete all imported articles associated with it."
                                    class="btn py-1 px-3 btn-outline-danger"
                                    onConfirm="delete({{ $projectDatabase->id_database }})"
                                >
                                    <i class="fas fa-trash"></i>
                                </x-helpers.confirm-modal>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4">
                                <x-helpers.description>
                                    {{ __("project/planning.databases.table.empty") }}
                                </x-helpers.description>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @livewire("planning.databases.suggest-database")
</div>

@script
    <script>
        $wire.on('databases', ([{ message, type }]) => {
            toasty({ message, type });
        });
    </script>
@endscript
