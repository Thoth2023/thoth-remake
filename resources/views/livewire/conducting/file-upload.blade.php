<div class="d-flex flex-column gap-4">
    <div class="card">
        <div class="card-header mb-0 pb-0">
            <x-helpers.modal target="import-studies" modalTitle="{{ __('project/conducting.import-studies.title') }}" modalContent="{{ __('project/conducting.import-studies.help.content') }}" />
        </div>
        <div class="card-body">
                <div class="d-flex flex-column gap-2 form-group">
                    <x-select class="w-md-25 w-100" id="databaseSelect" label="{{ __('project/conducting.import-studies.form.selected-database') }}" wire:model="selectedDatabase">
                        <option value="">
                            {{ __("project/conducting.import-studies.form.selected-database") }}
                        </option>
                        @foreach ($databases as $database)
                        <option value="{{ $database->id_database }}">
                            {{ $database->name }}
                        </option>
                        @endforeach
                    </x-select>
                    @error("selectedDatabase")
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
<div class="w-full mt-12">
    <div class="container mx-auto max-w-2xl">
        @if (session()->has('message'))
            <div class="flex items-center bg-green-500 text-white text-sm font-bold px-4 py-3 mb-6 rounded" role="alert">
                <p>{{ session('message') }}</p>
            </div>
        @endif
        <div class="mb-12 p-6 bg-white border rounded-md shadow-xl">
            <form wire:submit.prevent="save">
                <div class="mb-3">
                    <input type="file" wire:model="file" class="">
                    <div>
                        @error('file') <span class="text-sm text-red-500 italic">{{ $message }}</span>@enderror
                    </div>
                    <div wire:loading wire:target="file" class="text-sm text-gray-500 italic">Uploading...</div>
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save File</button>
            </form>
        </div>
        <div class="flex flex-wrap -mx-2">
            @foreach($files as $file)
                <div class="w-1/2 p-2">
                    <div class="w-full h-full border">
                        <img src="{{ asset('storage/files/' . $file->file_name) }}">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <hr style="opacity: 10%" />

    <div class="overflow-auto px-2 py-1" style="max-height: 300px">
        <table class="table table-responsive table-hover">
            <thead
                class="table-light sticky-top custom-gray-text"
                style="color: #676a72"
            >
                <th style="border-radius: 0.75rem 0 0 0; padding: 0.5rem 1rem;">
                    {{ __("project/conducting.import-studies.table.database") }}
                </th>
                <th style="padding: 0.5rem 0.75rem">
                    {{ __("project/conducting.import-studies.table.studies-imported") }}
                </th>
                <th style="border-radius: 0 0.75rem 0 0; padding: 0.5rem 1rem;">
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

