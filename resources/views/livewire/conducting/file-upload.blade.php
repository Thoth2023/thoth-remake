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
            <div class="d-flex flex-column gap-2 form-group">
                <x-select
                    class="w-md-25 w-50"
                    id="databaseSelect"
                    label="{{ __('project/conducting.import-studies.form.selected-database') }}"
                    wire:model="selectedDatabase"
                >
                    <option selected disabled>
                        {{ __("project/conducting.import-studies.form.selected-database") }}
                    </option>
                    @foreach ($databases as $database)
                        <option
                            value="{{ $database->id_database }}"
                                <?= ($selectedDatabase["value"] ?? "") == $database->id_database ? "selected" : "" ?>
                        >
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
                    <form wire:submit.prevent="save">
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
                            accept=".bib,.csv"
                        />
                        @error("file")
                        <span class="text-xs text-danger">
                                {{ $message }}
                            </span>
                        @enderror

                        <x-helpers.submit-button
                            class="mt-3"
                            type="submit"
                            wire:loading.attr="disabled"
                        >
                            Enviar arquivo
                        </x-helpers.submit-button>
                    </form>
                </div>
            </div>
            <hr style="opacity: 10%" />
            <div class="overflow-auto px-2 py-1" style="max-height: 500px">
                <table class="table table-responsive table-hover">
                    <thead
                        class="table-light sticky-top custom-gray-text"
                        style="color: #676a72"
                    >
                    <tr>
                        <th
                            style="
                                    border-radius: 0.75rem 0 0 0;
                                    padding: 0.5rem 1rem;
                                "
                        >
                            {{ __("project/conducting.import-studies.table.database") }}
                        </th>
                        <th style="padding: 0.5rem 0.75rem">
                            Files uploaded
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($databases as $database)
                        @php
                            $dbFiles = $files->where("id_database", $database->id_database);
                            $rowCount = $dbFiles->count();
                        @endphp

                        <tr>
                            <td class="align-middle">
                                {{ $database->name }}
                            </td>
                            <td class="align-middle">
                                @if ($rowCount > 0)
                                    <ul class="list-group">
                                        @foreach ($dbFiles as $file)
                                            <li class="list-group-item ml-4">
                                                {{ $file->file_name }}
                                                <button
                                                    class="pl-4 btn py-1 px-3 btn-outline-danger"
                                                    wire:click="deleteFile('{{ $file->id }}')"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
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
    $wire.on('file-upload', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
