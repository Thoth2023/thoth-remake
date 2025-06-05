<div class="p-4 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Minhas Notas</h2>

    @if (session()->has('message'))
        <div class="text-green-600 mb-2">{{ session('message') }}</div>
    @endif

    <textarea wire:model="newNote" class="w-full p-2 border rounded mb-2" placeholder="Escreva sua nota..."></textarea>
    <button wire:click="saveNote" class="bg-blue-600 text-white px-4 py-2 rounded">Salvar</button>

    <div class="mt-4">
        <h3 class="font-semibold mb-2">Notas anteriores:</h3>
        @forelse ($notes as $note)
            <div class="mb-2 p-2 bg-gray-100 rounded">
                <p>{{ $note->content }}</p>
                <span class="text-xs text-gray-500">{{ $note->created_at->format('d/m/Y H:i') }}</span>
            </div>
        @empty
            <p>Você ainda não escreveu nenhuma nota.</p>
        @endforelse
    </div>
</div>
