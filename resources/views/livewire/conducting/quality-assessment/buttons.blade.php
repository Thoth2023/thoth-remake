<div >
    <a class="btn py-1 px-3 btn-outline-secondary ms-auto {{ !$hasPapers ? 'disabled opacity-50 cursor-not-allowed' : '' }}" 
       wire:click.prevent="{{ $hasPapers ? 'exportCsv' : '' }}"
       @if(!$hasPapers) disabled @endif>
        <i class="fa-solid fa-file-csv"></i>
        {{ __('project/conducting.quality-assessment.buttons.csv' )}}
    </a>
    <a class="btn py-1 px-3 btn-outline-secondary ms-auto {{ !$hasPapers ? 'disabled opacity-50 cursor-not-allowed' : '' }}" 
       wire:click.prevent="{{ $hasPapers ? 'exportXml' : '' }}"
       @if(!$hasPapers) disabled @endif>
        <i class="fa-regular fa-file-code"></i>
        {{ __('project/conducting.quality-assessment.buttons.xml' )}}
    </a>
    <a class="btn py-1 px-3 btn-outline-secondary ms-auto {{ !$hasPapers ? 'disabled opacity-50 cursor-not-allowed' : '' }}" 
       wire:click.prevent="{{ $hasPapers ? 'exportPdf' : '' }}"
       @if(!$hasPapers) disabled @endif>
        <i class="fa-regular fa-file-pdf"></i>
        {{ __('project/conducting.quality-assessment.buttons.pdf' )}}
    </a>
</div>
@script
<script>
    $wire.on('buttons', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
