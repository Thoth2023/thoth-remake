<div class="d-flex gap-1 mb-3">
    <b>{{ __('project/conducting.quality-assessment.modal.status-quality' )}}: </b>
    <b class="{{ 'text-' . strtolower($status_paper) }}">
        {{ __("project/conducting.quality-assessment.status." . strtolower($status_paper)) }}
    </b>
     |
    <b>{{ __('project/conducting.quality-assessment.modal.quality-score' )}}: </b>
    <b class="{{ 'text-' . strtolower($status_paper) }}">
        {{ $score ?? 'N/A' }}
    </b>
     |
    <b>{{ __('project/conducting.quality-assessment.modal.quality-description' )}}: </b>
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
