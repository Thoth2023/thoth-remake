@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Adicionar Novo Perfil de Usuário'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Adicionar Novo Perfil de Usuário</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="p-3">
                    <form action="{{ route('levels.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="level" class="form-label">Nome do Perfil</label>
                            <input type="text" class="form-control" id="level" name="level" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Salvar</button>
                        <a href="{{ route('levels.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
