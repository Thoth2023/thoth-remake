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
                <div class="row">
                    <div class="col-4">
                        <b>{{ __('project/conducting.study-selection.modal.author' )}}: </b>
                        <p>{{ $paper['author'] }}</p>
                    </div>
                    <div class="col-2">
                        <b>{{ __('project/conducting.study-selection.modal.year' )}}:</b>
                        <p>{{ $paper['year'] }}</p>
                    </div><div class="col-4">
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
                    <div class="d-flex gap-1 mb-3">
                        <b>{{ __('project/conducting.study-selection.modal.status-selection' )}}: </b>
                        <b class="{{ 'text-' . strtolower($paper['status_description']) }}">
                            {{ __("project/conducting.study-selection.status." . strtolower($paper['status_description'])) }}
                        </b>
                    </div>
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
                                <td class="d-flex align-items-center justify-content-center">
                                    <input type="checkbox" wire:model="selected_criterias" value="{{ $criteria['id_criteria'] }}">
                                </td>
                                <td>{{ $criteria['id'] }}</td>
                                <td>{{ $criteria['description'] }}</td>
                                <td>{{ $criteria['type'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <hr />

                    <p>{{ __('project/conducting.study-selection.modal.option.select' )}}</p>

                    <div class="btn-group mt-2" role="group">
                        <input type="radio" class="btn-check" wire:model="selected_status" value="Removed" name="btnradio" id="btnradio1" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio1">{{ __('project/conducting.study-selection.modal.option.remove' )}}</label>

                        <input type="radio" class="btn-check" wire:model="selected_status" value="Accepted" name="btnradio" id="btnradio2" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio2">{{ __('project/conducting.study-selection.modal.option.accepted' )}}</label>

                        <input type="radio" class="btn-check" wire:model="selected_status" value="Rejected" name="btnradio" id="btnradio3" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio3">{{ __('project/conducting.study-selection.modal.option.rejected' )}}</label>

                        <input type="radio" class="btn-check" wire:model="selected_status" value="Duplicate" name="btnradio" id="btnradio4" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio4">{{ __('project/conducting.study-selection.modal.option.duplicated' )}}</label>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" wire:click="save">{{ __('project/conducting.study-selection.modal.save' )}}</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('project/conducting.study-selection.modal.close' )}}</button>
            </div>
        </div>
    </div>
</div>

@script
<script>
    $(document).ready(function(){
        // Show the modal
        $wire.on('show-paper', () => {
            $('#paperModal').modal('show');
        });

        // Handle saving and showing toast
        $wire.on('paperSaved', ([{ message, type }]) => {
            // Show a toast message
            toasty({ message, type });

            // Hide the modal
            $('#paperModal').modal('hide');

        });

        // Refresh papers on the client side when the event is fired
        window.addEventListener('papersUpdated', () => {
            // Trigger Livewire's refresh or reload method
            Livewire.dispatch('refreshPapers');
        });
    });
</script>
@endscript

@script
<script>
    $wire.on('paper-modal', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
