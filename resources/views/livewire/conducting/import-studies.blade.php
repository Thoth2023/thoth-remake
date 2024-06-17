<div class="d-flex flex-column gap-4">
<div class="card">
    <div class="card-header mb-0 pb-0">
        <x-helpers.modal
            target="import-studies"
            modalTitle="{{ __('project/conducting.import-studies.title') }}"
            modalContent="{{ __('project/conducting.import-studies.help.content') }}"
        />
    </div>
    <div class="card-body">
        <form wire:submit.prevent="import" class="d-flex flex-column">
            <div class="d-flex flex-column gap-2 form-group">
                <x-select
                    class="w-md-25 w-100"
                    id="databaseSelect"
                    label="{{ __('project/conducting.import-studies.form.database') }}"
                    wire:model="selectedDatabase"
                >
                    <option value="">
                        {{ __("project/conducting.import-studies.form.selected-database") }}
                    </option>
                    @foreach ($databases as $database)
                        <option value="{{ $database->id }}">
                            {{ $database->name }}
                        </option>
                    @endforeach
                </x-select>
                @error("selectedDatabase")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror

                <div class="d-flex flex-column">
                    <label
                        for="fileUpload"
                        class="form-control-label mx-0 mb-1"

                    >
                        {{ __("project/conducting.import-studies.form.upload") }}
                    </label>
                    <input
                        type="file"
                        class="form-control"
                        id="fileUpload"
                        wire:model="file"
                        accept=".bib,.csv,.txt"
                    />
                </div>
                @error("file")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <x-helpers.submit-button>
                {{ __("project/conducting.import-studies.form.add") }}
                <div wire:loading>
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
            </x-helpers.submit-button>
        </form>

        <div class="mt-3">
            @if (session()->has("message"))
                <div class="alert alert-success">
                    {{ session("message") }}
                </div>
            @endif

            @if (session()->has("error"))
                <div class="alert alert-danger">
                    {{ session("error") }}
                </div>
            @endif
        </div>

        <hr style="opacity: 10%" />

        <div class="overflow-auto px-2 py-1" style="max-height: 300px">
            <table class="table table-responsive table-hover">
                <thead
                    class="table-light sticky-top custom-gray-text"
                    style="color: #676a72"
                >
                    <th
                        style="
                            border-radius: 0.75rem 0 0 0;
                            padding: 0.5rem 1rem;
                        "
                    >
                        {{ __("project/conducting.import-studies.table.database") }}
                    </th>
                    <th style="padding: 0.5rem 0.75rem">
                        {{ __("project/conducting.import-studies.table.studies-imported") }}
                    </th>
                    <th
                        style="
                            border-radius: 0 0.75rem 0 0;
                            padding: 0.5rem 1rem;
                        "
                    >
                        {{ __("project/conducting.import-studies.table.actions") }}
                    </th>
                </thead>
                <tbody>
                    @foreach ($databases as $database)
                        <tr>
                            <td>{{ $database->name }}</td>
                            <td>{{ $database->studies_imported }}</td>
                            <td>
                                <button
                                    class="btn py-1 px-3 btn-outline-danger"
                                    wire:click="confirmDelete('{{ $database->id }}')"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@script
    <script>
        $wire.on('import-studies', ([{ message, type }]) => {
            toasty({ message, type });
        });
    </script>
@endscript
