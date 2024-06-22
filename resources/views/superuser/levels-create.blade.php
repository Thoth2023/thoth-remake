@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Adicionar Nova Permissão de Grupo'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Adicionar Nova Permissão de Grupo</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="p-3">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-5">
                                <label>Permissões do Sistema</label>
                                <select multiple id="available-permissions" class="form-control" size="10">
                                    <!-- Exemplo de permissões, substitua conforme necessário -->
                                    <option value="1">admin.users.add</option>
                                    <option value="2">admin.users.view</option>
                                    <option value="3">admin.users.edit</option>
                                    <option value="4">admin.users.delete</option>
                                    <!-- Adicione outras permissões aqui -->
                                </select>
                            </div>
                            <div class="col-md-2 text-center d-flex align-items-center justify-content-center">
                                <div class="button-group">
                                    <button type="button" id="btn-add" class="btn btn-primary mb-2"><i class="fas fa-arrow-right"></i></button>
                                    <button type="button" id="btn-remove" class="btn btn-primary"><i class="fas fa-arrow-left"></i></button>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label>Permissões do Grupo</label>
                                <select multiple id="assigned-permissions" name="permissions[]" class="form-control" size="10">
                                    <!-- Este campo será preenchido via JavaScript -->
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 text-right">
                            <button type="submit" class="btn btn-success">Salvar</button>
                            <a href="#" class="btn btn-secondary">Cancelar</a>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('btn-add').addEventListener('click', function() {
        moveOptions(document.getElementById('available-permissions'), document.getElementById('assigned-permissions'));
    });

    document.getElementById('btn-remove').addEventListener('click', function() {
        moveOptions(document.getElementById('assigned-permissions'), document.getElementById('available-permissions'));
    });

    function moveOptions(from, to) {
        let selectedOptions = Array.from(from.selectedOptions);
        selectedOptions.forEach(option => {
            to.appendChild(option);
        });
    }
</script>
<!-- FontAwesome CDN para ícones -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
