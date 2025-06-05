<div class="bg-white shadow-lg rounded-xl p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">📝 Minhas Notas</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="saveNote">
        <textarea wire:model="content"
                  placeholder="Escreva sua nota aqui..."
                  class="w-full h-32 p-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none"></textarea>

        @error('content') 
            <p class="text-red-500 mt-1 text-sm">{{ $message }}</p> 
        @enderror

        <button type="submit"
                class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
            Salvar Nota
        </button>
    </form>

    <hr class="my-6">

    <h3 class="text-lg font-semibold text-gray-700 mb-2">🗂️ Notas Salvas</h3>

    @forelse ($notes as $note)
        <div class="bg-gray-50 border border-gray-200 rounded-md p-4 mb-3 shadow-sm">
            <p class="text-gray-800 whitespace-pre-line">{{ $note->content }}</p>
            <p class="text-sm text-gray-500 mt-2">Criada em {{ $note->created_at->format('d/m/Y H:i') }}</p>
        </div>
    @empty
        <p class="text-gray-500">Nenhuma nota encontrada ainda.</p>
    @endforelse
</div>
