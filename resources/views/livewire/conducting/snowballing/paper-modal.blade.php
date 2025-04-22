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
                    @endif
                </div>
                @if ($paper) {{-- Certifique-se de que a div do modal body esteja dentro do bloco do $paper --}}
                <div class="modal-body">
                    <!-- O restante do conteúdo do paperModal -->
                    <div class="row">
                        <div class="col-4">
                            <b>{{ translationConducting('snowballing.modal.author') }}: </b>
                            <p>{{ $paper['author'] }}</p>
                        </div>
                        <div class="col-1">
                            <b>{{ translationConducting('snowballing.modal.year') }}:</b>
                            <p>{{ $paper['year'] }}</p>
                        </div>
                        <div class="col-4">
                            <b>{{ translationConducting('snowballing.modal.database') }}:</b>
                            <p>{{ $paper['database_name'] }}</p>
                        </div>
                        <div class="col-3">
                            <a class="btn py-1 px-3 btn-outline-dark" data-toggle="tooltip" data-original-title="Doi" href="https://doi.org/{{ $paper['doi'] }}" target="_blank">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                DOI
                            </a>
                            <a class="btn py-1 px-3 btn-outline-success" data-toggle="tooltip" data-original-title="URL" href="{{ $paper['url'] }}" target="_blank">
                                <i class="fa-solid fa-link"></i>
                                URL
                            </a>
                            <a class="btn py-1 px-3 btn-outline-primary"
                               data-toggle="tooltip"
                               data-original-title="Buscar no Google Scholar"
                               href="https://scholar.google.com/scholar?q={{ urlencode($paper['title']) }}"
                               target="_blank">
                                <i class="fa-solid fa-graduation-cap"></i>
                                Google Scholar
                            </a>
                            <div>
                                <h6>Snowballing</h6>
                                <x-select wire:change="handleReferenceType($event.target.value)">
                                    <option selected disabled>Selecione...</option>
                                    <option value="backward">Backward</option>
                                    <option value="forward">Forward</option>
                                </x-select>
                            </div>
                            <p class="text-success" wire:loading>Processando...</p>
                        </div>

                        <div class="d-flex gap-1 mb-3">
                            <b>{{ translationConducting('snowballing.modal.status-snowballing') }}: </b>
                            <b class="{{ 'text-' . strtolower($paper['status_description']) }}">
                                {{ translationConducting('snowballing.status." . strtolower($paper['status_description'])) }}
                            </b>
                        </div>
                        <div class="col-12">
                            <b>{{ translationConducting('snowballing.modal.abstract') }}: </b>
                            <p>{{ $paper['abstract'] }}</p>
                        </div>
                        <div class="col-12">
                            <b>{{ translationConducting('snowballing.modal.keywords') }}: </b>
                            <p>{{ $paper['keywords'] }}</p>
                        </div>
                    </div>

                    <!-- Aqui vai os dados do snowballing -->
                    <hr />
                    @livewire('conducting.snowballing.references-table', ['data' => ['paper_reference_id' => $paper['id_paper'] ?? null]])



                </div>
                @endif
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ translationConducting('snowballing.modal.close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="successModalSnowballing" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">
                       INFO
                    </h5>
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
        // Mostrar o modal do paper
        Livewire.on('show-paper-snowballing', () => {
            $('#paperModalSnowballing').modal('show');
        });

        // Mostrar o modal de sucesso
        Livewire.on('show-success-snowballing', () => {
            $('#paperModalSnowballing').modal('hide');
            $('#successModalSnowballing').modal('show');
        });

        // Reabrir o modal do paper após o modal de sucesso ser fechado
        $('#successModalSnowballing').on('hidden.bs.modal', function () {
            $('#paperModalSnowballing').modal('show');
        });
    });

    // Recarga do modal de paper
    Livewire.on('reload-paper-snowballing', () => {
        Livewire.emit('showPaperSnowballing', @json($paper));
    });
</script>
@endscript
