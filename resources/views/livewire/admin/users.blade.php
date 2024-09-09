@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => __("nav/side.user_manager")])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div> <!-- Adiciona um div para encapsular todo o conteúdo -->
                <div class="flex justify-between mb-4">
                    <h1 class="text-2xl font-bold">Gerenciar Usuários</h1>
                    <button wire:click="openModal" class="bg-blue-500 text-white px-4 py-2 rounded">Criar Novo Usuário</button>
                </div>

                @if (session()->has('message'))
                    <div class="bg-green-200 text-green-800 p-2 rounded">
                        {{ session('message') }}
                    </div>
                @endif

                <table class="min-w-full bg-white border">
                    <thead>
                    <tr>
                        <th class="px-4 py-2">Nome de Usuário</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="border px-4 py-2">{{ $user->username }}</td>
                            <td class="border px-4 py-2">{{ $user->email }}</td>
                            <td class="border px-4 py-2">
                                <button wire:click="edit({{ $user->id }})" class="bg-yellow-500 text-white px-4 py-2 rounded">Editar</button>
                                <button wire:click="delete({{ $user->id }})" class="bg-red-500 text-white px-4 py-2 rounded">Excluir</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $users->links() }}

                @if ($showModal)
                    <div class="fixed inset-0 flex items-center justify-center bg-gray-600 bg-opacity-50">
                        <div class="bg-white p-6 rounded-lg">
                            <h2 class="text-xl font-bold">{{ $isEditMode ? 'Editar Usuário' : 'Criar Novo Usuário' }}</h2>
                            <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">
                                <div class="mb-4">
                                    <label for="username" class="block text-gray-700">Nome de Usuário</label>
                                    <input wire:model="username" type="text" id="username" class="w-full border rounded px-3 py-2">
                                    @error('username') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="email" class="block text-gray-700">Email</label>
                                    <input wire:model="email" type="email" id="email" class="w-full border rounded px-3 py-2">
                                    @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="block text-gray-700">Senha</label>
                                    <input wire:model="password" type="password" id="password" class="w-full border rounded px-3 py-2">
                                    @if($isEditMode)
                                        <small class="text-gray-600">Deixe em branco para manter a senha atual.</small>
                                    @endif
                                    @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>

                                <div class="flex justify-end">
                                    <button wire:click="closeModal" type="button" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancelar</button>
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">{{ $isEditMode ? 'Atualizar' : 'Criar' }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

