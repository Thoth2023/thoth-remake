<div>
    <div class="modal fade" id="paperModalSnowballingRelevant" tabindex="-1" role="dialog" aria-labelledby="paperModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    @if ($paper)
                        <h5 class="modal-title">{{ $paper['title'] }}</h5>
                        <button type="button" data-bs-dismiss="modal" class="btn">
                            <span aria-hidden="true">X</span>
                        </button>
                    @endif
                </div>

                @if ($paper)
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4">
                                <b>{{ __('project/conducting.snowballing.modal.author') }}: </b>
                                <p>{{ $paper['authors'] }}</p>
                            </div>
                            <div class="col-1">
                                <b>{{ __('project/conducting.snowballing.modal.year') }}:</b>
                                <p>{{ $paper['year'] }}</p>
                            </div>
                            <div class="col-4">
                                <b>{{ __('project/conducting.snowballing.modal.database') }}:</b>
                                <p>{{ $paper['database_name'] }}</p>
                            </div>
                            <div class="col-3 text-end">
                                @if($paper['doi'])
                                    <a class="btn py-1 px-3 btn-outline-dark" href="https://doi.org/{{ $paper['doi'] }}" target="_blank">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i> DOI
                                    </a>
                                @endif
                                @if($paper['url'])
                                    <a class="btn py-1 px-3 btn-outline-success" href="{{ $paper['url'] }}" target="_blank">
                                        <i class="fa-solid fa-link"></i> URL
                                    </a>
                                @endif
                                <a class="btn py-1 px-3 btn-outline-primary"
                                   href="https://scholar.google.com/scholar?q={{ urlencode($paper['title']) }}"
                                   target="_blank">
                                    <i class="fa-solid fa-graduation-cap"></i> Scholar
                                </a>
                            </div>
                            @if(!is_null($paper['depth'] ?? null))
                                <div class="small text-muted mt-1">
                                    <i class="fa-solid fa-layer-group"></i>
                                    {{ __('project/conducting.snowballing.depth') }}:
                                    <strong>{{ $paper['depth'] }}</strong>
                                </div>
                            @endif
                            <div class="mt-2">
                                <h6>{{ __('project/conducting.snowballing.modal.manual-title') }}</h6>

                                {{-- Seleção manual --}}
                                <x-select wire:change="handleReferenceType($event.target.value)" class="form-select mb-2">
                                    <option selected disabled>{{ __('project/conducting.snowballing.modal.manual-select') }}</option>
                                    <option value="backward" @if($manualBackwardDone) disabled @endif>
                                        {{ __('project/conducting.snowballing.modal.manual-backward') }}
                                        {{ $manualBackwardDone ? __('project/conducting.snowballing.modal.manual-processed') : '' }}
                                    </option>
                                    <option value="forward" @if($manualForwardDone) disabled @endif>
                                        {{ __('project/conducting.snowballing.modal.manual-forward') }}
                                        {{ $manualForwardDone ? __('project/conducting.snowballing.modal.manual-processed') : '' }}
                                    </option>
                                </x-select>

                                @if($isRunning)
                                    <p class="text-success mt-2">{{ __('project/conducting.snowballing.modal.processing') }}</p>

                                    <div wire:poll.2s="checkJobProgress">
                                        <div class="progress mt-3" style="height: 8px;">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark"
                                                 role="progressbar"
                                                 style="width: {{ $jobProgress }}%;"
                                                 aria-valuenow="{{ $jobProgress }}"
                                                 aria-valuemin="0"
                                                 aria-valuemax="100">
                                            </div>
                                        </div>

                                        <p class="small text-muted mt-2">{{ $jobMessage }}</p>
                                    </div>
                                @endif
                            </div>


                            <div class="col-12 mt-3">
                                <b>{{ __('project/conducting.snowballing.modal.abstract') }}: </b>
                                <p>{{ $paper['abstract'] }}</p>
                            </div>
                            <div class="col-12">
                                <b>{{ __('project/conducting.snowballing.modal.keywords') }}: </b>
                                <p>{{ $paper['keywords'] }}</p>
                            </div>
                        </div>

                        <hr />
                        @livewire('conducting.snowballing.references-table-relevant', ['data' => ['parent_snowballing_id' => $paper['id'] ?? null]])
                    </div>
                @endif

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('project/conducting.snowballing.modal.close') }}
                    </button>
                </div>
            </div>
        </div>

    </div>

    {{-- Modal de sucesso --}}
    <div wire:ignore.self class="modal fade" id="successModalSnowballingRelevant" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">{{ __('project/conducting.snowballing.modal.info') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ session('successMessage') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ __('project/conducting.snowballing.modal.ok') }}</button>
                </div>
            </div>
        </div>
    </div>

</div>
    @script
    <script>

        $(document).ready(function(){
            $wire.on('show-paper-snowballing-relevant', () => {
                setTimeout(() => { $('#paperModalSnowballingRelevant').modal('show'); }, 800);
            });

            Livewire.on('show-success-snowballing-relevant', () => {
                $('#paperModalSnowballingRelevant').modal('hide');
                $('#successModalSnowballingRelevant').modal('show');
            });

            $('#successModalSnowballingRelevant').on('hidden.bs.modal', function () {
                $('#paperModalSnowballingRelevant').modal('show');
                // força o reload das referências
                Livewire.emit('reload-paper-snowballing-relevant');
            });
        });

        Livewire.on('reload-paper-snowballing-relevant', () => {
            Livewire.emit('showPaperSnowballingRelevant', @json($paper));
        });

        // Toast customizado
        $wire.on('snowballing-relevant-toast', ([{ message, type }]) => {
            toasty({ message, type });
        });

    </script>
    @endscript

