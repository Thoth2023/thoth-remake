<div>
    <div wire:ignore.self class="modal fade" id="paperModalSnowballing" tabindex="-1" role="dialog" aria-labelledby="paperModalLabel" aria-hidden="true">
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

                @if ($paper)
                    <div class="modal-body">
                        <div class="row">
                            <div wire:ignore class="col-4">
                                <b>{{ __('project/conducting.snowballing.modal.author') }}: </b>
                                <p>{{ $paper['author'] }}</p>
                            </div>
                            <div wire:ignore class="col-1">
                                <b>{{ __('project/conducting.snowballing.modal.year') }}:</b>
                                <p>{{ $paper['year'] }}</p>
                            </div>
                            <div wire:ignore class="col-4">
                                <b>{{ __('project/conducting.snowballing.modal.database') }}:</b>
                                <p>{{ $paper['database_name'] }}</p>
                            </div>
                            <div class="col-3">
                                <a class="btn py-1 px-3 btn-outline-dark" href="https://doi.org/{{ $paper['doi'] }}" target="_blank">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> {{ __('project/conducting.snowballing.buttons.doi') }}
                                </a>
                                <a class="btn py-1 px-3 btn-outline-success" href="{{ $paper['url'] }}" target="_blank">
                                    <i class="fa-solid fa-link"></i> {{ __('project/conducting.snowballing.buttons.url') }}
                                </a>
                                <a class="btn py-1 px-3 btn-outline-primary"
                                   href="https://scholar.google.com/scholar?q={{ urlencode($paper['title']) }}"
                                   target="_blank">
                                    <i class="fa-solid fa-graduation-cap"></i> {{ __('project/conducting.snowballing.buttons.scholar') }}
                                </a>

                                <div class="mt-2">
                                    <h6>{{ __('project/conducting.snowballing.modal.manual-title') }}</h6>

                                    {{-- Seleção manual --}}
                                    @if($canEdit)
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
                                    @else
                                        <x-select disabled class="form-select">
                                            <option>{{ __('project/conducting.snowballing.modal.manual-readonly') }}</option>
                                        </x-select>
                                    @endif

                                    {{--
                                        Snowballing completo — REMOVIDO TEMPORARIAMENTE

                                        @if($canEdit && !$manualBackwardDone && !$manualForwardDone)
                                            {{ __('project/conducting.snowballing.modal.automated-or') }}
                                            <button wire:click="handleFullSnowballing" class="btn btn-dark w-100 mt-1">
                                                <i class="fa-solid fa-dna"></i> {{ __('project/conducting.snowballing.buttons.automated') }}
                                            </button>
                                        @else
                                            <button class="btn btn-secondary w-100 mt-1" disabled>
                                                <i class="fa-solid fa-lock"></i> {{ __('project/conducting.snowballing.buttons.automated-unavailable') }}
                                            </button>
                                        @endif
                                    --}}


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
                            </div>


                            <div class="col-12">
                                <b>{{ __('project/conducting.snowballing.modal.abstract') }}: </b>
                                <p>{{ $paper['abstract'] }}</p>
                            </div>
                            <div class="col-12">
                                <b>{{ __('project/conducting.snowballing.modal.keywords') }}: </b>
                                <p>{{ $paper['keywords'] }}</p>
                            </div>
                        </div>

                        <hr />
                        @livewire('conducting.snowballing.references-table', ['data' => ['paper_reference_id' => $paper['id_paper'] ?? null]])
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
    <div wire:ignore.self class="modal fade" id="successModalSnowballing" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
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
        $wire.on('show-paper-snowballing', () => {
            setTimeout(() => { $('#paperModalSnowballing').modal('show'); }, 800);
        });

        Livewire.on('show-success-snowballing', () => {
            $('#paperModalSnowballing').modal('hide');
            $('#successModalSnowballing').modal('show');
        });

        $('#successModalSnowballing').on('hidden.bs.modal', function () {
            $('#paperModalSnowballing').modal('show');
        });
    });

    Livewire.on('reload-paper-snowballing', () => {
        Livewire.emit('showPaperSnowballing', @json($paper));
    });

    // Toast customizado
    $wire.on('snowballing-toast', ([{ message, type }]) => {
        toasty({ message, type });
    });

</script>
@endscript



