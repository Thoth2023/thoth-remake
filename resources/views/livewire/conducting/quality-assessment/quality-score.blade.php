<div class="d-flex gap-1 mb-3">
    <b>{{ translationConducting('quality-assessment.modal.status-quality' )}}: </b>
    <b class="{{ 'text-' . strtolower($status_paper) }}">
        {{ translationConducting("quality-assessment.status." . strtolower($status_paper)) }}
    </b>
     |
    <b>{{ translationConducting('quality-assessment.modal.quality-score' )}}: </b>
    <b class="{{ 'text-' . strtolower($status_paper) }}">
        {{ $score ?? 'N/A' }}
    </b>
     |
    <b>{{ translationConducting('quality-assessment.modal.quality-description' )}}: </b>
    <b class="{{ 'text-' . strtolower($status_paper) }}">
        {{ $quality_description }}
    </b>
</div>
@script
<script>
    $wire.on('quality-score', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
