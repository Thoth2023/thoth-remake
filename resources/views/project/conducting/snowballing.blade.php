<div class="card mt-4">
    <div class="card-header">
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Ações</th> <!-- Nova coluna para o botão -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($snowballing_projects as $project)
                        <tr>
                            <td>{{ $project->id }}</td>
                            <td>{{ $project->title }}</td>
                            <td>
                                <!-- Botão que abre o modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#projectModal-{{ $project->id }}">
                                    Analyse reference
                                </button>
                                <!-- Botão de excluir -->
                                <button type="button" class="btn btn-danger">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach ($snowballing_projects as $project)
    <!-- Modal -->
    <div class="modal fade" id="projectModal-{{ $project->id }}" tabindex="-1" aria-labelledby="projectModalLabel-{{ $project->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="projectModalLabel-{{ $project->id }}">{{ $project->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Primeira sessão do modal -->
                    <p>Doi:</p>
                    <p>URL:</p>
                    <p>Autor:</p>
                    <p>Ano:</p>
                    <p>Base de dados:</p>
                    <p>Abstract:</p>
                    <p>Keywords:</p>
                    <p>Exclusion Criteria Rule:</p>
                    <p>Inclusion Criteria Rule:</p>
                    <!-- Linha dividindo as seções -->
                    <hr>
                    <!-- Segunda sessão do modal -->
                    <p>Inclusion Criteria</p>                    
                    <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($snowballing_projects as $project)
                        <tr>
                            <td>{{ $project->id }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
                    
                </div>

                <p>Exclusion Criteria</p>                    
                    <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($snowballing_projects as $project)
                        <tr>
                            <td>{{ $project->id }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Inclua os scripts do Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
