<!-- resources/views/livewire/study-evaluation.blade.php -->
<div>
    <div class="form-group">
        <label for="criteria_inclusion">Atende os Critérios de Inclusão?</label>
        <input type="checkbox" wire:model.defer="criteria_inclusion" id="criteria_inclusion" {{ $paper->criteria_inclusion ? 'checked' : '' }}>
    </div>
    <div class="form-group">
        <label for="criteria_exclusion">Atende os Critérios de Exclusão?</label>
        <input type="checkbox" wire:model.defer="criteria_exclusion" id="criteria_exclusion" {{ $paper->criteria_exclusion ? 'checked' : '' }}>
    </div>
    <div class="form-group">
        <label for="notes">Notas:</label>
        <textarea wire:model.defer="notes" class="form-control" id="notes">{{ $paper->notes }}</textarea>
    </div>
    <button type="button" class="btn btn-primary" wire:click="save">Salvar</button>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <a href="{{ $paper->url }}" class="btn btn-secondary" target="_blank">
        <i class="fa fa-link"></i> Ver Estudo Completo
    </a>
</div>
