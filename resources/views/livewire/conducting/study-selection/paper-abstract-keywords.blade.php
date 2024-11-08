<div>
    <div class="col-12">
        <b>{{ __('project/conducting.study-selection.modal.abstract') }}: </b>
        <p>{{ $abstract }}</p>
    </div>
    <div class="col-12">
        <b>{{ __('project/conducting.study-selection.modal.keywords') }}: </b>
        <p>{{ $keywords }}</p>
    </div>
</div>
@script
<script>
    $wire.on('paper-abstract-keywords', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
