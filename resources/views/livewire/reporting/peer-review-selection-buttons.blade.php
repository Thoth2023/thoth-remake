<div>
    <!-- Botões de exportação e remoção de duplicados -->
    <a class="btn py-1 px-3 btn-outline-secondary ms-auto" wire:click.prevent="exportCsv">
        <i class="fa-solid fa-file-csv"></i>
        {{ translationPlanning('study-selection.buttons.csv' )}}
    </a>
    <a class="btn py-1 px-3 btn-outline-secondary ms-auto" wire:click.prevent="exportXml">
        <i class="fa-regular fa-file-code"></i>
        {{ translationPlanning('study-selection.buttons.xml' )}}
    </a>
    <a class="btn py-1 px-3 btn-outline-secondary ms-auto" wire:click.prevent="exportPdf">
        <i class="fa-regular fa-file-pdf"></i>
        {{ translationPlanning('study-selection.buttons.pdf' )}}
    </a>

</div>

@script
<script>
    $(document).ready(function(){

        $wire.on('buttons', ([{ message, type }]) => {
            toasty({ message, type });
        });

    });
</script>
@endscript
