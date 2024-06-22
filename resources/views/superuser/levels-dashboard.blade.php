@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Gerenciar Perfis de Usuários'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Permissão de Grupo</h6>
                <a href="{{ route('levels.create') }}" class="btn btn-success">+ Nova Permissão de Grupo</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" style="width: 30%;">Nome</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" style="width: 40%;">Descrição</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-end" style="width: 30%;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($levels as $level)
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $level->id_level}}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{ $level->level}}</p>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">
                                        {{ $level->description ?? 'N/A' }}
                                    </p>
                                </td>
                                <td class="align-middle text-end">
                                    <a href="{{ route('levels.show', $level->id_level) }}" class="btn btn-info btn-sm">VER</a>
                                    <a href="{{ route('levels.edit', $level->id_level) }}" class="btn btn-warning btn-sm">EDITAR</a>
                                    <form action="{{ route('levels.destroy', $level->id_level) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">EXCLUIR</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
