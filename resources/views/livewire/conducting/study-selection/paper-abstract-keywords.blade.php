@php
    $studySelectionPath = 'project/conducting.study-selection';
@endphp

<div>
    <div class="col-12">
        <b>{{ translationStudySelection("{$studySelectionPath}.modal.abstract") }}: </b>
        <p>{{ $abstract }}</p>
    </div>
    <div class="col-12">
        <b>{{ translationStudySelection("{$studySelectionPath}.modal.keywords") }}: </b>
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
