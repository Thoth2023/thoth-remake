<div>
    <div class="modal fade" id="paperModalSnowballing" tabindex="-1" role="dialog" aria-labelledby="paperModalLabel" aria-hidden="true">
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
                            <b>{{ __('project/conducting.snowballing.modal.author' )}}: </b>
                            <p>{{ $paper['author'] }}</p>
                        </div>
                        <div class="col-2">
                            <b>{{ __('project/conducting.snowballing.modal.year' )}}:</b>
                            <p>{{ $paper['year'] }}</p>
                        </div>
                        <div class="col-4">
                            <b>{{ __('project/conducting.snowballing.modal.database' )}}:</b>
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
                            <b>{{ __('project/conducting.snowballing.modal.status-snowballing' )}}: </b>
                            <b class="{{ 'text-' . strtolower($paper['status_description']) }}">
                                {{ __("project/conducting.snowballing.status." . strtolower($paper['status_description'])) }}
                            </b>
                        </div>
                        <div class="col-12">
                            <b>{{ __('project/conducting.snowballing.modal.abstract' )}}: </b>
                            <p>{{ $paper['abstract'] }}</p>
                        </div>
                        <div class="col-12">
                            <b>{{ __('project/conducting.snowballing.modal.keywords' )}}: </b>
                            <p>{{ $paper['keywords'] }}</p>
                        </div>
                    </div>

                    <!--Aqui vai os dados do snowballing -->

                    <hr />

                    <p>{{ __('project/conducting.snowballing.modal.option.select' )}}</p>

                    <div class="btn-group mt-2" role="group">
                        <input type="radio" class="btn-check" wire:model="selected_status" value="Unclassified" name="btnradio" id="btnradio2" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio2">{{ __('project/conducting.snowballing.modal.option.unclassified' )}}</label>

                        <input type="radio" class="btn-check" wire:model="selected_status" value="Removed" name="btnradio" id="btnradio1" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio1">{{ __('project/conducting.snowballing.modal.option.remove' )}}</label>

                        <input type="radio" class="btn-check" wire:model="selected_status" value="Duplicate" name="btnradio" id="btnradio4" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio4">{{ __('project/conducting.snowballing.modal.option.duplicated' )}}</label>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('project/conducting.snowballing.modal.close' )}}</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="successModalSnowballing" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
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
        // mostrar o paper
        $wire.on('show-paper-snowballing', () => {
            $('#paperModalSnowballing').modal('show');
        });
        //mostrar msg de sucesso
        Livewire.on('show-success-snowballing', () => {
            $('#paperModalSnowballing').modal('hide'); // Hide the paper modal
            $('#successModalSnowballing').modal('show'); // Show the success modal
        });

        // fechar modal paper
        $('#successModalSnowballing').on('hidden.bs.modal', function () {
            $('#paperModalSnowballing').modal('show'); // Reopen the paper modal after success modal is closed
        });
    });
    Livewire.on('reload-paper-snowballing', () => {
        // Recarregar o componente Livewire para refletir as mudanças
        Livewire.emit('showPaperSnowballing', @json($paper));
    });

    $wire.on('paper-modal', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
