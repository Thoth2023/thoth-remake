<div>
    <!-- Botões de exportação e remoção de duplicados -->
    <a class="btn py-1 px-3 btn-outline-secondary ms-auto {{ !$hasPapers ? 'disabled opacity-50 cursor-not-allowed' : '' }}"
       wire:click.prevent="{{ $hasPapers ? 'exportCsv' : '' }}"
       @if(!$hasPapers) disabled @endif>
        <i class="fa-solid fa-file-csv"></i>
        {{ __('project/conducting.study-selection.buttons.csv' )}}
    </a>
    <a class="btn py-1 px-3 btn-outline-secondary ms-auto {{ !$hasPapers ? 'disabled opacity-50 cursor-not-allowed' : '' }}"
       wire:click.prevent="{{ $hasPapers ? 'exportXml' : '' }}"
       @if(!$hasPapers) disabled @endif>
        <i class="fa-regular fa-file-code"></i>
        {{ __('project/conducting.study-selection.buttons.xml' )}}
    </a>
    <a class="btn py-1 px-3 btn-outline-secondary ms-auto {{ !$hasPapers ? 'disabled opacity-50 cursor-not-allowed' : '' }}"
       wire:click.prevent="{{ $hasPapers ? 'exportPdf' : '' }}"
       @if(!$hasPapers) disabled @endif>
        <i class="fa-regular fa-file-pdf"></i>
        {{ __('project/conducting.study-selection.buttons.pdf' )}}
    </a>
    <a class="btn py-1 px-3 btn-outline-primary" wire:click.prevent="removeDuplicates">
        <i class="fa-solid fa-magnifying-glass"></i>
        {{ __('project/conducting.study-selection.buttons.duplicates' )}}
    </a>

    <!-- Modal para mostrar papers duplicados -->
    <div class="modal fade" id="duplicatesModal" tabindex="-1" role="dialog" aria-labelledby="duplicatesModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="duplicatesModalLabel">{{ __('project/conducting.study-selection.duplicates.title' )}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="align-items-md-start">
                            <li><b class="bg-light">{{count($uniquePapers)}}</b> {{ __('project/conducting.study-selection.duplicates.unique-papers' )}}</li>
                            <li><b class="bg-light">{{ $exactDuplicateCount }}</b> {!! __('project/conducting.study-selection.duplicates.exact-duplicate-count') !!}</li>

                        </div>
                        <div>
                            <button class="btn btn-dark" wire:click="markAllDuplicates">
                                {!! __('project/conducting.study-selection.duplicates.button-mark-all', ['count' => $exactDuplicateCount]) !!}
                            </button>
                        </div>
                    </div>
                    @if(count($uniquePapers) > 0)
                        @foreach($uniquePapers as $uniquePaper)
                            <div class="text-start">
                                <p><strong>ID: {{ $uniquePaper->id }} - {{ $uniquePaper->title }} | {{ $uniquePaper->year }}</strong></p>
                            </div>
                            @if(isset($duplicates[$uniquePaper->title]))
                                <ul class='list-group'>
                                    <li class='list-group-item d-flex text-start'>
                                        <div class='w-5 pl-2'>
                                            <b>ID</b>
                                        </div>
                                        <div class='w-50 pl-2'>
                                            <b>{{ __('project/conducting.study-selection.duplicates.table-title' )}}</b>
                                        </div>
                                        <div class='w-5 pl-2'>
                                            <b>{{ __('project/conducting.study-selection.duplicates.table-year' )}}</b>
                                        </div>
                                        <div class='w-25 pl-2'>
                                            <b>{{ __('project/conducting.study-selection.duplicates.table-database' )}}</b>
                                        </div>
                                        <div class='w-15 pl-2'>
                                            <b>{{ __('project/conducting.study-selection.duplicates.table-duplicate' )}} ?</b>
                                        </div>
                                    </li>
                                </ul>
                                <ul class='list-group list-group-flush text-start'>

                                    @foreach($duplicates[$uniquePaper->title] as $duplicate)
                                        <li class='list-group-item d-flex text-start'>
                                            <div class='w-5 pl-2'>
                                                <span>{{ $duplicate->id }}</span>
                                            </div>
                                            <div class="w-50">
                                                <span>{{ $duplicate->title }}</span>
                                            </div>
                                            <div class="w-5">
                                                <span>{{ $duplicate->year }}</span>
                                            </div>
                                            <div class="w-25">
                                                <span>{{ $duplicate->database ?? 'N/A' }}</span>
                                            </div>
                                            <div class="w-15">
                                                @if ($duplicate->id_status == 4 )
                                                    <!-- Exibe a badge "Duplicado" se o paper foi marcado como duplicado pelo membro atual -->
                                                    <span class="badge bg-warning">{{ __('project/conducting.study-selection.duplicates.table-duplicate' )}}</span>
                                                @else
                                                    <!-- Exibe os botões de confirmação/rejeição caso o paper ainda não seja duplicado -->
                                                    <button class="btn btn-success" wire:click="confirmDuplicate({{ $duplicate->id_paper }})">
                                                        {{ __('project/conducting.study-selection.duplicates.table-duplicate-yes' )}}
                                                    </button>
                                                    <button class="btn btn-danger" wire:click="rejectDuplicate({{ $duplicate->id_paper }})">
                                                        {{ __('project/conducting.study-selection.duplicates.table-duplicate-no' )}}
                                                    </button>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <hr />
                            @endif
                        @endforeach
                    @else
                        <p>{{ __('project/conducting.study-selection.duplicates.no-duplicates' )}}</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('project/conducting.study-selection.modal.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="successModalDuplicates" tabindex="-1" role="dialog"
         aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">{{ __('project/conducting.study-selection.modal.success' )}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('project/conducting.study-selection.duplicates.success-message') }}</p>
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
    document.addEventListener('livewire:initialized', () => {
        const $wire = Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'));

        // Mostrar modal principal
        Livewire.on('show-duplicates-modal', () => {
            $('#duplicatesModal').modal('show');
        });

        // Mostrar modal de sucesso
        Livewire.on('show-success-duplicates', () => {
            $('#duplicatesModal').modal('hide');
            $('#successModalDuplicates').modal('show');
        });

        // Reabrir modal principal ao fechar o de sucesso
        $('#successModalDuplicates').on('hidden.bs.modal', function () {
            $wire.$refresh(); //
            setTimeout(() => {
                $('#duplicatesModal').modal('show');
            }, 400);
        });

        Livewire.on('duplicates-refreshed', () => {
            console.log('Duplicates reloaded from backend');
        });

        // Toasts
        Livewire.on('buttons', ([{ message, type }]) => {
            toasty({ message, type });
        });
    });


</script>
@endscript

