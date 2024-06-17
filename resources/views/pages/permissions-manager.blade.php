@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Gerenciar Perfis de Usuários'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Permissão de Grupo</h6>
                <a href="{{ route('permissions.create') }}" class="btn btn-success">+ Nova Permissão de Grupo</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nome do Usuário</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Grupo (Profile)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $user->id }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{ $user->firstname }} {{ $user->lastname }}</p>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">
                                        {{ $user->profile->name ?? 'N/A' }}
                                    </p>
                                </td>
                                @if(auth()->check() && auth()->user()->profile)
                                    <a href="{{ route('edit-permissions', auth()->user()->profile->id) }}" class="btn btn-warning" >Editar</a>
                                @else
                                    <p>Perfil não encontrado.</p>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tem certeza de que deseja excluir este perfil?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function () {
            const action = button.getAttribute('data-action');
            document.getElementById('deleteForm').setAttribute('action', action);
        });
    });
</script>

@endsection
