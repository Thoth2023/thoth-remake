@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Editar Perfil de Usuário'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Editar Perfil</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form action="{{ route('permissions.update', $profile->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nome do Perfil</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $profile->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Descrição</label>
                        <textarea class="form-control" id="description" name="description" required>{{ old('description', $profile->description) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
