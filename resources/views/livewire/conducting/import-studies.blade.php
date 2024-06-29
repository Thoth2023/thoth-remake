<div class="d-flex flex-column gap-4">
    <div class="card">
        <div class="card-header mb-0 pb-0">
            <x-helpers.modal target="import-studies" modalTitle="{{ __('project/conducting.import-studies.title') }}" modalContent="{{ __('project/conducting.import-studies.help.content') }}" />
        </div>
        <div class="card-body">
            <form wire:submit.prevent="import" class="d-flex flex-column">
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

                    <div class="d-flex flex-column">
                        <label for="fileUpload" class="form-control-label mx-0 mb-1">
                            {{ __("project/conducting.import-studies.form.upload") }}
                        </label>
                        <input type="file" class="form-control" id="fileUpload" wire:model="file" accept=".bib,.csv" />
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
                <table class="table table-responsive table-hover" id="study-import-table">
                    <thead class="table-light sticky-top custom-gray-text" style="color: #676a72">
                        <th style="
                            border-radius: 0.75rem 0 0 0;
                            padding: 0.5rem 1rem;
                        ">
                            {{ __("project/conducting.import-studies.table.database") }}
                            <i class="fas fa-sort"></i>
                        </th>
                        <th style="padding: 0.5rem 0.75rem">
                            {{ __("project/conducting.import-studies.table.studies-imported") }}
                            <i class="fas fa-sort"></i>
                        </th>
                        <th class="text-center" style="border-radius: 0 0.75rem 0 0; padding: 0.5rem 0.75rem;">
                            {{ __("project/conducting.import-studies.table.file-imported") }}
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($databases as $database)
                        <tr>
                            <td class="align-middle">{{ $database->name }}</td>
                            <td class="align-middle">{{ $database->imported_study_count }}</td>
                            <td>
                                <table class="table table-responsive table-hover">
                                    <th style="border-radius: 0.75rem 0 0 0; padding: 0.5rem 1rem;">
                                        {{ __("project/conducting.import-studies.table.file") }}
                                    </th>
                                    <th class="text-center" style="border-radius: 0 0.75rem 0 0; padding: 0.5rem 1rem;">
                                        {{ __("project/conducting.import-studies.table.delete") }}

                                    </th>
                                    </thead>
                                    <tbody>
                                        {{-- @forelse ($files as $file)
                                        <td>
                                            {{$file}}
                            </td>
                            <td>
                                <button class="btn py-1 px-3 btn-outline-danger" wire:click="confirmDelete('{{ $database->id }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>

                            @empty

                            @endforelse --}}
                            <td>
                                nome do arquivo
                            </td>
                            <td class="text-center">
                                <button class="btn py-1 px-3 btn-outline-danger " wire:loading.attr="disabled">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                    </tbody>

                </table>
                </td>


                </tr>
                @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>


    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tablesort/5.2.1/tablesort.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Tablesort(document.getElementById('study-import-table'));

            // Filtragem da tabela
            const searchInput = document.getElementById('search-input');
            const table = document.getElementById('study-import-table').getElementsByTagName('tbody')[0];
            const rows = table.getElementsByTagName('tr');

            searchInput.addEventListener('keyup', function() {
                const filter = searchInput.value.toLowerCase();

                for (let i = 0; i < rows.length; i++) {
                    const cells = rows[i].getElementsByTagName('td');
                    let display = false;
                    for (let j = 0; j < cells.length; j++) {
                        if (cells[j].textContent.toLowerCase().indexOf(filter) > -1) {
                            display = true;
                            break;
                        }
                    }
                    rows[i].style.display = display ? '' : 'none';
                }
            });
        });
    </script>

    <style>
        /* Estilo para o cabeçalho da tabela para indicar que é clicável */
        #study-selection-table thead th {
            cursor: pointer;
            transition: color 0.3s;
            position: relative;
        }

        /* Estilo para o cabeçalho da tabela quando o mouse estiver sobre ele */
        #study-selection-table thead th:hover {
            color: #000;
            /* Texto mais escuro */
        }

        /* Estilo para os ícones de ordenação */
        #study-selection-table thead th i {
            margin-left: 5px;
            font-size: 0.8em;
            color: #999;
        }

        /* Estilo para a caixa de pesquisa */
        #search-input {
            margin-bottom: 15px;
        }

        /* Estilo para as células da tabela */
        #study-selection-table tbody td {
            padding-left: 23px;
            /* Adiciona 20px de padding à esquerda */
        }
    </style>

    @script
    <script>
        $wire.on('import-studies', ([{
            message,
            type
        }]) => {
            toasty({
                message,
                type
            });
        });
    </script>
    </script>
    @endscript
