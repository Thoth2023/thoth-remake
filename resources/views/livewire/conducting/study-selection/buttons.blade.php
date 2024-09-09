<div>
    <!-- Botões de exportação e remoção de duplicados -->
    <a class="btn py-1 px-3 btn-outline-secondary ms-auto" wire:click.prevent="exportCsv">
        <i class="fa-solid fa-file-csv"></i>
        {{ __('project/conducting.study-selection.buttons.csv' )}}
    </a>
    <a class="btn py-1 px-3 btn-outline-secondary ms-auto" wire:click.prevent="exportXml">
        <i class="fa-regular fa-file-code"></i>
        {{ __('project/conducting.study-selection.buttons.xml' )}}
    </a>
    <a class="btn py-1 px-3 btn-outline-secondary ms-auto" wire:click.prevent="exportPdf">
        <i class="fa-regular fa-file-pdf"></i>
        {{ __('project/conducting.study-selection.buttons.pdf' )}}
    </a>
    <a class="btn py-1 px-3 btn-outline-secondary ms-auto" wire:click.prevent="printStudies">
        <i class="fa-solid fa-print"></i>
        {{ __('project/conducting.study-selection.buttons.print' )}}
    </a>
    <a class="btn py-1 px-3 btn-outline-primary" wire:click.prevent="removeDuplicates">
        <i class="fa-solid fa-magnifying-glass"></i>
        {{ __('project/conducting.study-selection.buttons.duplicates' )}}
    </a>

    <!-- Modal para mostrar papers duplicados -->
    <div class="modal fade" id="duplicatesModal" tabindex="-1" role="dialog" aria-labelledby="duplicatesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="duplicatesModalLabel">Review Duplicated Papers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                        @foreach($uniquePapers as $uniquePaper)
                            <div class="text-start"><p> <strong>ID: {{ $uniquePaper->id }} - {{ $uniquePaper->title }}</strong></p></div>
                                @if(isset($duplicates[$uniquePaper->title]))
                                <ul class='list-group'>
                                    <li class='list-group-item d-flex text-start'>
                                        <div class='w-5 pl-2 '>
                                            <b>ID</b>
                                        </div>
                                        <div class='w-60 pl-2 '>
                                            <b>Título</b>
                                        </div>
                                        <div class='w-5 pl-2 '>
                                            <b>Ano</b>
                                        </div>
                                        <div class='w-15 pl-2 '>
                                            <b>Base de Dados</b>
                                        </div>
                                        <div class='w-15 pl-2'>
                                            <b>Duplicado?</b>
                                        </div>
                                    </li>
                                </ul>
                            <ul class='list-group list-group-flush text-start'>

                                @foreach($duplicates[$uniquePaper->title] as $duplicate)
                                    <li class='list-group-item d-flex text-start'>
                                                <div class='w-5 pl-2'>
                                                    <span>{{ $duplicate->id_paper }}</span>
                                                </div>
                                                <div class="w-60">
                                                    <span>{{ $duplicate->title }}</span>
                                                </div>
                                                <div class="w-5">
                                                    <span>{{ $duplicate->year }}</span>
                                                </div>
                                                <div class="w-15">
                                                    <span>{{ $duplicate->data_base }}</span>
                                                </div>
                                                <div class="w-15 ">
                                                    <button class="btn btn-success " wire:click="confirmDuplicate({{ $duplicate->id_paper }})">
                                                        SIM
                                                    </button>
                                                    <button class="btn btn-danger" wire:click="rejectDuplicate({{ $duplicate->id_paper }})">
                                                        NÃO
                                                    </button>
                                                </div>
                                        </li>
                                        @endforeach
                                </ul>
                            <hr />
                                @endif
                        @endforeach

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('project/conducting.study-selection.modal.close' )}}</button>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    $(document).ready(function(){
        $wire.on('show-duplicates-modal', () => {
            $('#duplicatesModal').modal('show');
        });

        Livewire.on('show-success', () => {
            $('#duplicatesModal').modal('hide');
            $('#successModal').modal('show');
        });

        $('#successModal').on('hidden.bs.modal', function () {
            $('#duplicatesModal').modal('show');
        });
    });

    $wire.on('buttons', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
