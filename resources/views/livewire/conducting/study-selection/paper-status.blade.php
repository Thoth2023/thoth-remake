@php
    $studySelectionPath = 'project/conducting.study-selection';
@endphp

<div class="d-flex gap-1 mb-3">
    <b>{{ translationConducting("study-selection.modal.status-selection")}}: </b>
    <b class="{{ 'text-' . strtolower($status_description) }}">
        {{ translationConducting("study-selection.status." . strtolower($status_description)) }}
    </b>
</div>
@script
<script>
    $wire.on('paper-status', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
