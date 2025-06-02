<div>
    <h5>Snowballing com IA</h5>

    <form wire:submit.prevent="fetch">
        <div class="form-group">
            <label for="doi">Informe o DOI:</label>
            <input type="text" id="doi" wire:model.defer="doi" class="form-control" placeholder="10.1016/j.future.2020.01.005">
        </div>

        <button type="submit" class="btn btn-primary mt-2">Buscar Referências</button>
    </form>

    @if (session()->has('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

    @if ($references)
        <h6 class="mt-4">Referências:</h6>
        <ul>
            @foreach ($references as $ref)
                <li>{{ $ref['title'] ?? '[sem título]' }}</li>
            @endforeach
        </ul>
    @endif

    @if ($citations)
        <h6 class="mt-4">Citações:</h6>
        <ul>
            @foreach ($citations as $cit)
                <li>{{ $cit['title'] ?? '[sem título]' }}</li>
            @endforeach
        </ul>
    @endif
</div>
