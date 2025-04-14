@php
    $studySelectionPath = 'project/conducting.study-selection';
@endphp

<div>
    <span>
        <b>{{ translationStudySelection("{$studySelectionPath}.modal.author" )}}: </b>
        <p>{{ $author }}</p>
    </span>
</div>
@script
<script>
    $wire.on('paper-authors', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
