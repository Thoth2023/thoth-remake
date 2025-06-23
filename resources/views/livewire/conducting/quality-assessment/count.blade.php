 <div wire:model="count" >
    <div class="mt-1">
        <div class="progress mb-4" style="height: 20px;">
            <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $unclassifiedPercentage }}%;" aria-valuenow="{{ $unclassifiedPercentage }}" aria-valuemin="0" aria-valuemax="100">
                {{ number_format($unclassifiedPercentage, 2) }}%
            </div>
            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $acceptedPercentage }}%;" aria-valuenow="{{ $acceptedPercentage }}" aria-valuemin="0" aria-valuemax="100">
                {{ number_format($acceptedPercentage, 2) }}%
            </div>
            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $rejectedPercentage }}%;" aria-valuenow="{{ $rejectedPercentage }}" aria-valuemin="0" aria-valuemax="100">
                {{ number_format($rejectedPercentage, 2) }}%
            </div>
            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $removedPercentage }}%;" aria-valuenow="{{ $removedPercentage }}" aria-valuemin="0" aria-valuemax="100">
                {{ number_format($removedPercentage, 2) }}%
            </div>


        </div>

        <div class="d-flex gap-4 mb-3">
            <div class="col text-secondary">
                <strong>{{ translationConducting('quality-assessment.status.unclassified' )}}:</strong> {{ count($unclassified) }}
            </div>
            <div class="col text-success">
                <strong>{{ translationConducting('quality-assessment.status.accepted' )}}:</strong> {{ count($accepted) }}
            </div>
            <div class="col text-danger">
                <strong>{{ translationConducting('quality-assessment.status.rejected' )}}:</strong> {{ count($rejected) }}
            </div>
            <div class="col text-info">
                <strong>{{ translationConducting('quality-assessment.status.removed' )}}:</strong> {{ count($removed) }}
            </div>

            <div class="col">
                <strong>Total:</strong> {{ count($papers) }}
            </div>
        </div>
    </div>
    </div>

@script
<script>
    $wire.on('count', ([{ message, type }]) => {
        toasty({ message, type });
    });

    Livewire.on('import-success', () => {
        // Recarregar o componente Livewire para refletir as mudanças
        Livewire.emit('show-success');
    });
</script>
@endscript
