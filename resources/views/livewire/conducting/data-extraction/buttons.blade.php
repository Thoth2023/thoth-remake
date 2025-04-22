<div >
    <a class="btn py-1 px-3 btn-outline-secondary ms-auto" wire:click.prevent="exportCsv">
        <i class="fa-solid fa-file-csv"></i>
        {{ translationConducting('data-extraction.buttons.csv' )}}
    </a>
    <a class="btn py-1 px-3 btn-outline-secondary ms-auto" wire:click.prevent="exportXml">
        <i class="fa-regular fa-file-code"></i>
        {{ translationConducting('data-extraction.buttons.xml' )}}
    </a>
    <a class="btn py-1 px-3 btn-outline-secondary ms-auto" wire:click.prevent="exportPdf">
        <i class="fa-regular fa-file-pdf"></i>
        {{ translationConducting('data-extraction.buttons.pdf' )}}
    </a>
</div>
@script
<script>
    $wire.on('buttons', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
