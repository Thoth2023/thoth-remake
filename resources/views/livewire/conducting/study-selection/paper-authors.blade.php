
<div>
    <span>
        <b>{{ translationConducting("study-selection.modal.author")}}:</b>
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
