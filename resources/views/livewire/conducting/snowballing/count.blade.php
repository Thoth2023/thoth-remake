@if (session()->has('error'))
    <div class="card card-body col-md-12 mt-1">
        <h3 class="h4 mb-3">Complete these tasks to advance</h3>
        <div class="alert alert-warning">
            {{ session('error') }}
        </div>
    </div>
@else
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
            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $duplicatePercentage }}%;" aria-valuenow="{{ $duplicatePercentage }}" aria-valuemin="0" aria-valuemax="100">
                {{ number_format($duplicatePercentage, 2) }}%
            </div>

        </div>

        <div class="d-flex gap-4 mb-3">
            <div class="col text-secondary">
                <strong>{{ __('project/conducting.snowballing.status.unclassified' )}}:</strong> {{ count($unclassified) }}
            </div>
            <div class="col text-success">
                <strong>{{ __('project/conducting.snowballing.status.accepted' )}}:</strong> {{ count($accepted) }}
            </div>
            <div class="col text-danger">
                <strong>{{ __('project/conducting.snowballing.status.rejected' )}}:</strong> {{ count($rejected) }}
            </div>
            <div class="col text-info">
                <strong>{{ __('project/conducting.snowballing.status.removed' )}}:</strong> {{ count($removed) }}
            </div>

            <div class="col text-warning">
                <strong>{{ __('project/conducting.snowballing.status.duplicate' )}}:</strong> {{ count($duplicates) }}
            </div>
            <div class="col">
                <strong>Total:</strong> {{ count($papers) }}
            </div>
        </div>
    </div>
    </div>
@endif

@script
<script>
    $wire.on('count', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
@script
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('papersUpdated', () => {
            // Aqui você pode mostrar uma mensagem de toasty ou qualquer outra ação
            toasty({ message: 'Papers updated successfully!', type: 'success' });

            // Você pode também recarregar a página se necessário
             window.location.reload();
        });
    });
</script>
@endscript
