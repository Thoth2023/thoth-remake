@extends('layouts.app')

@section('content')
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Editar Permissão de Grupo</h6>
            </div>
            <div class="card-body px-4 pt-4 pb-2">
                <form action="{{ route('levels.update', $level->id_level) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="level" class="form-label">Nome do Grupo</label>
                        <input type="text" class="form-control" id="level" name="level" value="{{ $level->level }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição</label>
                        <input type="text" class="form-control" id="description" name="description" value="{{ $level->description }}">
                    </div>
                    
                    <button type="submit" class="btn btn-success">Salvar</button>
                        <a href="{{ route('levels.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection
