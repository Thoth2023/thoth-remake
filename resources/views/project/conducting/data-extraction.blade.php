<body>
    <div class="col-12">
        <div class="card card-frame mt-5">
            <div class="card">
                <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                    <h5>{{ __('project/conducting.progress_bar.title') }}</h5>
                </div>
                <div class="card-body">
                    <div class="progress-wrapper">
                        <div class="progress-info">
                            <div class="progress-percentage">
                                <span
                                    class="text-sm font-weight-bold">{{ __('project/conducting.progress_bar.progress_title') }}</span>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                                aria-valuemax="100" style="width: 60%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-0 mt-5">
            <div class="card-header mb-0 pb-0">
                <x-helpers.modal target="search-domains" modalTitle="{{ __('project/conducting.search.help.title') }}"
                    modalContent="{{ __('project/conducting.search.help.content') }}" />
            </div>
            <div class="card-body">
                <form wire:submit="submit" class="d-flex flex-column">
                    <div class="form-group">
                        <x-select wire:model="study" label="{{ __('project/conducting.search.help.title') }}">
                            <option selected disabled>
                                {{ __('project/conducting.search.placeholder') }}
                            </option>
                        </x-select>
                        @error('study')
                            <span class="text-xs text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div>
                        <x-helpers.submit-button>
                            {{ __('project/conducting.search.add') }}
                            <div wire:loading>
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </x-helpers.submit-button>
                    </div>
                </form>
                <hr style="opacity: 10%" />
                <div class="overflow-auto px-2 py-1" style="max-height: 300px">
                    <div class="d-flex justify-content-between">
                    </div>
                    <div class="d-flex justify-content-between">
                        <span data-search>Estudo 3</span>
                        <div>
                            <a href="#" class="btn py-1 px-3 btn-outline-primary" title="Cópia CSV"><i
                                    class="fas fa-file-csv"></i></a>
                            <a href="#" class="btn py-1 px-3 btn-outline-primary" title="Cópia XML"><i
                                    class="fas fa-file-code"></i></a>
                            <a href="#" class="btn py-1 px-3 btn-outline-primary" title="Exportar para PDF"><i
                                    class="fas fa-file-pdf"></i></a>
                            <a href="#" class="btn py-1 px-3 btn-outline-primary" title="Imprimir"><i
                                    class="fas fa-print"></i></a>
                            <button class="btn py-1 px-3 btn-outline-danger" wire:click="delete(3)"
                                wire:target="delete(3)" wire:loading.attr="disabled">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-0 mt-5">
            <div class="container-fluid py-4">
                <div class="table-responsive">
                    <table class="table align-items-center justify-content-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary">
                                    {{ __('project/conducting.table.id') }}
                                </th>
                                <th class="text-uppercase text-secondary">
                                    {{ __('project/conducting.table.title') }}
                                </th>
                                <th class="text-uppercase text-secondary">
                                    {{ __('project/conducting.table.author') }}
                                </th>
                                <th class="text-uppercase text-secondary">
                                    {{ __('project/conducting.table.year') }}
                                </th>
                                <th class="text-uppercase text-secondary">
                                    {{ __('project/conducting.table.data_base') }}
                                </th>
                                <th class="text-uppercase text-secondary">
                                    {{ __('project/conducting.table.status') }}
                                </th>
                            </tr>
                        </thead>
                        {{-- <tbody>
                            <!-- Aqui você deve iterar sobre os dados da sua tabela e exibi-los -->
                            @foreach ($seusDados as $item)
                                <tr>
                                    <td>
                                        {{ $item->id }}
                                    </td>
                                    <td>
                                        {{ $item->title }}
                                    </td>
                                    <td>
                                        {{ $item->author }}
                                    </td>
                                    <td>
                                        {{ $item->year }}
                                    </td>
                                    <td>
                                        {{ $item->database }}
                                    </td>
                                    <td>
                                        {{ $item->status }}
                                    </td>
                                </tr>
                            @endforeach --}}
                        {{-- </tbody> --}}
                    </table>
                </div>
            </div>
        </div>

    </div>
</body>

</html>
