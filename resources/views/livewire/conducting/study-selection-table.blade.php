<!-- resources/views/livewire/study-selection-table.blade.php -->
<div>
    <div class="card border">
        <div class="table-responsive">
            <table class="table table-hover" id="study-selection-table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Quality Questions Code</th>
                        <th scope="col">General Score</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($generalscore as $index => $score)
                    <tr wire:key="{{ $score->id_general_score }}">
                        <td>{{ $score->id_general_score }}</td>
                        <td>
                            @isset($currentQuestion[$index])
                                {{ $currentQuestion[$index]->id}}
                            @endisset
                        </td>
                        <td>{{ $score->start }} - {{ $score->end }}</td>
                        <td>{{ $score->description }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <x-helpers.description>
                                {{ __("project/planning.quality-assessment.general-score.table.empty") }}
                            </x-helpers.description>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#study-selection-table').DataTable();
    });
</script>

<style>
    /* Estilo para a caixa de pesquisa */
    .dataTables_filter input {
        border-radius: 10px;
        padding: 8px;
        border: 1px solid #ccc;
        box-shadow: none;
    }

    /* Estilo para o botão de pesquisa */
    .dataTables_filter label {
        margin-bottom: 0;
    }

    /* Estilo para o botão de paginação */
    .dataTables_paginate .paginate_button {
        border-radius: 20px !important;
        margin: 0 5px;
    }

    /* Estilo para o botão de página ativa */
    .dataTables_paginate .paginate_button.current {
        background-color: #007bff !important;
        color: #fff !important;
    }


    /* Estilo para a caixa de seleção de quantidade de registros */
    .dataTables_length select {
        border-radius: 5px;
        padding: 5px;
        width: 10px
    }

    /* Estilo para a mensagem de "Nenhum dado encontrado" */
    .dataTables_empty {
        text-align: center;
    }

    /* Estilizando o campo de pesquisa */
    .dataTables_filter {
        text-align: center; /* Centraliza o campo de pesquisa */
    }

    .dataTables_filter input {
        width: 70%; /* Define a largura do campo de pesquisa */
        max-width: 400px; /* Defina um comprimento máximo para evitar que ele se estenda muito */
        border-radius: 20px;
        padding: 10px;
        border: 1px solid #ccc;
        background-color: #f5f5f5;
        color: #333;
        margin-right: 5px;
        margin-top: 2px;
    }

    .dataTables_paginate .paginate_button {
        /* border-radius: 20px !important;
        margin: 0 5px;
        padding: 10px 15px;
        background-color: #007bff;
        color: #fff;
        border: none;
        cursor: pointer; */
  
    }

    /* Estilizando o botão "Anterior" quando desativado */
    .dataTables_paginate .paginate_button.previous.disabled  {
        /* background-color: #ccc;
        color: #666;
        cursor: not-allowed; */
        font-size: 10px;
    }

    /* Estilizando o botão "Próximo" quando desativado */
    .dataTables_paginate .paginate_button.next.disabled {
        /* background-color: #ccc;
        color: #666;
        cursor: not-allowed; */
    }

    /* Estilizando o botão "Próximo" quando desativado */
    .dataTables_paginate .paginate_button.next.disabled .page-link {
        /* background-color: #ccc;
        color: #666;
        cursor: not-allowed; */
        font-size: 10px;
    }

   
    .dataTables_paginate .paginate_button.previous.disabled .page-link {
        /* background-color: #ccc;
        color: #666;
        cursor: not-allowed; */
        font-size: 10px;
    }
  


</style>



</div>
