@php
    $studySelectionPath = 'project/conducting.sstudy-selection';
@endphp

<div>
    <div class="col-12">
        <b>{{ translationConducting("study-selection.modal.abstract") }}: </b>
        <p>{{ $abstract }}</p>
    </div>
    <div class="col-12">
        <b>{{ translationConducting("study-selection.modal.keywords") }}: </b>
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
