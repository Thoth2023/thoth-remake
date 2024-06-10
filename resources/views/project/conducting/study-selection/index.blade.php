@props(['$papers'])

<div class='card card-body col-md-12 mt-3'>
<div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <button class="btn btn-secondary" wire:click="exportCsv">Exportar CSV</button>
            <button class="btn btn-secondary" wire:click="exportXml">Exportar XML</button>
            <button class="btn btn-secondary" wire:click="exportPdf">Exportar PDF</button>
            <button class="btn btn-secondary" wire:click="printStudies">Imprimir</button>
            <button class="btn btn-danger" wire:click="removeDuplicates">Remover Duplicados</button>
        </div>
    </div>
    @livewire("conducting.study-selection.table")
</div>