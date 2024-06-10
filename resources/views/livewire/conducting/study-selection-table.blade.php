    <!-- resources/views/livewire/study-selection-table.blade.php -->
    <div>
        <div class="card border">
            <!-- Caixa de pesquisa -->
            <div class="p-3">
                <input type="text" id="search-input" class="form-control" placeholder="Pesquisar...">
            </div>

            <div class="table-responsive">
                <table class="table table-hover" id="study-selection-table">
                    <thead>
                        <tr>
                            <th scope="col">ID <i class="fas fa-sort"></i></th>
                            <th scope="col">Quality Questions Code <i class="fas fa-sort"></i></th>
                            <th scope="col">General Score <i class="fas fa-sort"></i></th>
                            <th scope="col">Descrição <i class="fas fa-sort"></i></th>
                            <th scope="col">Status <i class="fas fa-sort"></i></th>
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
                            <td>
                                <button
                                class="btn py-1 px-3 btn-outline-secondary"
                                wire:click="edit('{{ $score->id_general_score }}')"
                            >
                                <i class="fas fa-edit"></i>
                            </button>
                            <button
                                class="btn py-1 px-3 btn-outline-danger"
                                wire:click="delete('{{ $score->id_general_score }}')"
                                wire:target="delete('{{ $score->id_general_score }}')"
                                wire:loading.attr="disabled"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                            </td>
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

    <!-- Incluindo Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tablesort/5.2.1/tablesort.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Tablesort(document.getElementById('study-selection-table'));

            // Filtragem da tabela
            const searchInput = document.getElementById('search-input');
            const table = document.getElementById('study-selection-table').getElementsByTagName('tbody')[0];
            const rows = table.getElementsByTagName('tr');

            searchInput.addEventListener('keyup', function() {
                const filter = searchInput.value.toLowerCase();

                for (let i = 0; i < rows.length; i++) {
                    const cells = rows[i].getElementsByTagName('td');
                    let display = false;
                    for (let j = 0; j < cells.length; j++) {
                        if (cells[j].textContent.toLowerCase().indexOf(filter) > -1) {
                            display = true;
                            break;
                        }
                    }
                    rows[i].style.display = display ? '' : 'none';
                }
            });
        });
    </script>

    <style>
        /* Estilo para o cabeçalho da tabela para indicar que é clicável */
        #study-selection-table thead th {
            cursor: pointer;
            transition: color 0.3s;
            position: relative;
        }

        /* Estilo para o cabeçalho da tabela quando o mouse estiver sobre ele */
        #study-selection-table thead th:hover {
            color: #000; /* Texto mais escuro */
        }

        /* Estilo para os ícones de ordenação */
        #study-selection-table thead th i {
            margin-left: 5px;
            font-size: 0.8em;
            color: #999;
        }

        /* Estilo para a caixa de pesquisa */
        #search-input {
            margin-bottom: 15px;
        }

         /* Estilo para as células da tabela */
    #study-selection-table tbody td {
        padding-left: 23px; /* Adiciona 20px de padding à esquerda */
    }
    </style>
