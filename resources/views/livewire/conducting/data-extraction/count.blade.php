    <div wire:model="count" >
    <div class="mt-1">
        <div class="progress mb-4" style="height: 20px;">
            <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $to_doPercentage }}%;" aria-valuenow="{{ $to_doPercentage }}" aria-valuemin="0" aria-valuemax="100">
                {{ number_format($to_doPercentage, 2) }}%
            </div>
            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $donePercentage }}%;" aria-valuenow="{{ $donePercentage }}" aria-valuemin="0" aria-valuemax="100">
                {{ number_format($donePercentage, 2) }}%
            </div>
            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $removedPercentage }}%;" aria-valuenow="{{ $removedPercentage }}" aria-valuemin="0" aria-valuemax="100">
                {{ number_format($removedPercentage, 2) }}%
            </div>


        </div>

        <div class="d-flex gap-4 mb-3">
            <div class="col text-secondary">
                <strong>{{ translationConducting('data-extraction.status.to_do' )}}:</strong> {{ count($to_do) }}
            </div>
            <div class="col text-success">
                <strong>{{ translationConducting('data-extraction.status.done' )}}:</strong> {{ count($done) }}
            </div>
            <div class="col text-info">
                <strong>{{ translationConducting('data-extraction.status.removed' )}}:</strong> {{ count($removed) }}
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
