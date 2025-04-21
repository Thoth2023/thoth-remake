@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 px-4">
    <div class="bg-white shadow-2xl rounded-2xl p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">📝 Minhas Notas</h1>

        @if (session('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <form method="POST" action="{{ route('notes.store') }}">
            @csrf
            <textarea name="content" rows="4" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm" placeholder="Escreva sua nova nota aqui..."></textarea>
            @error('content')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror

            <button type="submit" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-xl transition-all duration-200">
                Salvar Nota
            </button>
        </form>

        <hr class="my-6">

        <h2 class="text-xl font-semibold text-gray-700 mb-4">📚 Notas anteriores</h2>

        @forelse ($notes as $note)
            <div class="mb-4 p-4 bg-gray-50 border border-gray-200 rounded-xl shadow-sm">
                <p class="text-gray-800">{{ $note->content }}</p>
                <span class="text-sm text-gray-500">{{ $note->created_at->format('d/m/Y H:i') }}</span>
            </div>
        @empty
            <p class="text-gray-600">Você ainda não tem notas salvas.</p>
        @endforelse
    </div>
</div>
@endsection
