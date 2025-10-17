<div wire:model="count">
    <div class="mt-1">
        <div class="progress mb-4" style="height: 20px;">
            <div class="progress-bar bg-secondary" role="progressbar"
                 style="width: {{ $todoPercentage }}%;"
                 aria-valuenow="{{ $todoPercentage }}" aria-valuemin="0" aria-valuemax="100">
                {{ number_format($todoPercentage, 2) }}%
            </div>
            <div class="progress-bar bg-success" role="progressbar"
                 style="width: {{ $donePercentage }}%;"
                 aria-valuenow="{{ $donePercentage }}" aria-valuemin="0" aria-valuemax="100">
                {{ number_format($donePercentage, 2) }}%
            </div>
        </div>

        <div class="d-flex gap-4 mb-3">
            <div class="col text-secondary">
                <strong>{{ __('project/conducting.snowballing.status.todo') }}:</strong> {{ count($todo) }}
            </div>
            <div class="col text-success">
                <strong>{{ __('project/conducting.snowballing.status.done') }}:</strong> {{ count($done) }}
            </div>
            <div class="col text-warning">
                <strong>{{ __('project/conducting.snowballing.status.relevant') }}:</strong> {{ $relevantCount }}
            </div>
            <div class="col">
                <strong>Total (papers base):</strong> {{ $totalPapers }}
            </div>
        </div>
    </div>
</div>

@script
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('show-success', () => {
            toasty({ message: 'Papers updated successfully!', type: 'success' });
            window.location.reload();
        });
    });
</script>
@endscript
