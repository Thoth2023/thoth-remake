<div>
    <div class="modal fade" id="paperModal" tabindex="-1" role="dialog" aria-labelledby="paperModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    @if ($paper)
                        <h5 class="modal-title" id="paperModalLabel">{{ $paper['title'] }}</h5>
                        <button type="button" data-bs-dismiss="modal" class="btn">
                            <span aria-hidden="true">X</span>
                        </button>
                </div>
                <div class="modal-body">
                    <!-- O restante do conteúdo do paperModal -->
                    <div class="row">
                        <div class="col-4">
                            <b>{{ __('project/conducting.study-selection.modal.author' )}}: </b>
                            <p>{{ $paper['author'] }}</p>
                        </div>
                        <div class="col-2">
                            <b>{{ __('project/conducting.study-selection.modal.year' )}}:</b>
                            <p>{{ $paper['year'] }}</p>
                        </div>
                        <div class="col-4">
                            <b>{{ __('project/conducting.study-selection.modal.database' )}}:</b>
                            <p>{{ $paper['database_name'] }}</p>
                        </div>
                        <div class="col-2">
                            <a class="btn py-1 px-3 btn-outline-dark" data-toggle="tooltip" data-original-title="Doi" href="https://doi.org/{{ $paper['doi'] }}" target="_blank">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                DOI
                            </a>
                            <a class="btn py-1 px-3 btn-outline-success" data-toggle="tooltip" data-original-title="URL" href="{{ $paper['url'] }}" target="_blank">
                                <i class="fa-solid fa-link"></i>
                                URL
                            </a>
                        </div>
                        @livewire('conducting.study-selection.paper-status', ['paper' => $paper['id_paper']],key($paper['id_paper']))

                        <div class="col-12">
                            <b>{{ __('project/conducting.study-selection.modal.abstract' )}}: </b>
                            <p>{{ $paper['abstract'] }}</p>
                        </div>
                        <div class="col-12">
                            <b>{{ __('project/conducting.study-selection.modal.keywords' )}}: </b>
                            <p>{{ $paper['keywords'] }}</p>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered mb-3">
                        <thead>
                        <tr>
                            <th>{{ __('project/conducting.study-selection.modal.table.select' )}}</th>
                            <th>ID</th>
                            <th>{{ __('project/conducting.study-selection.modal.table.description' )}}</th>
                            <th>{{ __('project/conducting.study-selection.modal.table.type' )}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($criterias as $criteria)
                            <tr>
                                <td class="w-5 align-middle text-center">
                                    <input
                                        type="checkbox"
                                        id="criteria-{{ $criteria['id_criteria'] }}"
                                        wire:key="criteria-{{ $criteria['id_criteria'] }}"
                                        wire:model="selected_criterias"
                                        wire:change="changePreSelected({{ $criteria['id_criteria'] }}, '{{ $criteria['type'] }}')"
                                        value="{{ $criteria['id_criteria'] }}"
                                        @if(in_array($criteria['id_criteria'], $selected_criterias)) checked @endif
                                    >
                                </td>
                                <td>{{ $criteria['id'] }}</td>
                                <td>{{ $criteria['description'] }}</td>
                                <td>{{ $criteria['type'] }}</td>
                                <td>{{ $criteria['rule'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <hr />
                    <!-- Verificação do status -->
                    @if($paper['status_selection'] != 1 && $paper['status_selection'] != 2)
                        <!-- Apenas mostrar se o status não for Accepted (1) ou Rejected (2) -->
                    <p>{{ __('project/conducting.study-selection.modal.option.select' )}}</p>

                    <div class="btn-group mt-2" role="group">
                        <input type="radio" class="btn-check" wire:model="selected_status" wire:change="updateStatusManual" value="Unclassified" name="btnradio" id="btnradio2" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio2">{{ __('project/conducting.study-selection.modal.option.unclassified' )}}</label>

                        <input type="radio" class="btn-check" wire:model="selected_status" wire:change="updateStatusManual" value="Removed" name="btnradio" id="btnradio1" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio1">{{ __('project/conducting.study-selection.modal.option.remove' )}}</label>

                        <input type="radio" class="btn-check" wire:model="selected_status" wire:change="updateStatusManual" value="Duplicate" name="btnradio" id="btnradio4" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio4">{{ __('project/conducting.study-selection.modal.option.duplicated' )}}</label>
                    </div>
                    @endif
                @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('project/conducting.study-selection.modal.close' )}}</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ session('successMessage') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    $(document).ready(function(){
        // Show the paper modal
        $wire.on('show-paper', () => {
            $('#paperModal').modal('show');
        });

        // Show the success modal on success event
        Livewire.on('show-success', () => {
            $('#paperModal').modal('hide'); // Hide the paper modal
            $('#successModal').modal('show'); // Show the success modal
        });

        // Handle the closing of success modal to reopen the paper modal
        $('#successModal').on('hidden.bs.modal', function () {
            $('#paperModal').modal('show'); // Reopen the paper modal after success modal is closed
        });
    });
    Livewire.on('reload-papers', () => {
        // Recarregar o componente Livewire para refletir as mudanças
        Livewire.emit('show-sucess');
    });
    Livewire.on('show-sucess', () => {
        // Recarregar o componente Livewire para refletir as mudanças
        Livewire.emit('show-sucess-quality');
    });

    $wire.on('paper-modal', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
