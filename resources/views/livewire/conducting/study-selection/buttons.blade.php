<div >
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
</div>
@script
<script>
    $wire.on('buttons', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
