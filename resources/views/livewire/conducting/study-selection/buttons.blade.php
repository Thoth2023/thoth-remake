
<div>
    <button class="btn btn-secondary" wire:click.prevent="exportCsv">Exportar CSV</button>
    <button class="btn btn-secondary" wire:click.prevent="exportXml">Exportar XML</button>
    <button class="btn btn-secondary" wire:click.prevent="exportPdf">Exportar PDF</button>
    <button class="btn btn-secondary" wire:click.prevent="printStudies">Imprimir</button>
    <button class="btn btn-danger" wire:click.prevent="removeDuplicates">Encontrar Duplicados</button>
</div>
@script
<script>
    $wire.on('buttons', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
