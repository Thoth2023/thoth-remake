<div class="p-4 border rounded">
    <h2 class="text-lg font-bold mb-2">Snowballing via Semantic Scholar</h2>

    <input type="text" wire:model.defer="doi" class="border p-2 w-full mb-2" placeholder="Digite o DOI">
    <button wire:click="search" class="bg-blue-500 text-white px-4 py-2 rounded">Buscar</button>

    @error('doi') <p class="text-red-500 mt-1">{{ $message }}</p> @enderror

    @if($references)
        <h3 class="mt-4 font-semibold">Referências (Backward Snowballing)</h3>
        <ul class="list-disc ml-5">
            @foreach($references as $ref)
                <li>{{ $ref['title'] ?? 'Sem título' }} ({{ $ref['year'] ?? '?' }})</li>
            @endforeach
        </ul>
    @endif

    @if($citations)
        <h3 class="mt-4 font-semibold">Citações (Forward Snowballing)</h3>
        <ul class="list-disc ml-5">
            @foreach($citations as $cit)
                <li>{{ $cit['title'] ?? 'Sem título' }} ({{ $cit['year'] ?? '?' }})</li>
            @endforeach
        </ul>
    @endif
</div>
