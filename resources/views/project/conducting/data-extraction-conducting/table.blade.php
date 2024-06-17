<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <style>
        .table-wrapper {
            overflow-x: auto;
        }
    </style>
</head>

<body>

    <div class="card mb-0 mt-5">
        <div class="container-fluid py-4">
            <div class="table-responsive">
                <table class="table align-items-center justify-content-center mb-0" id="study-selection-table">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary">{{ __('project/conducting.table.id') }}</th>
                            <th class="text-uppercase text-secondary">{{ __('project/conducting.table.title') }}</th>
                            <th class="text-uppercase text-secondary">{{ __('project/conducting.table.author') }}</th>
                            <th class="text-uppercase text-secondary">{{ __('project/conducting.table.year') }}</th>
                            <th class="text-uppercase text-secondary">{{ __('project/conducting.table.data_base') }}
                            </th>
                            <th class="text-uppercase text-secondary">{{ __('project/conducting.table.status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-id="1">
                            <td>1</td>
                            <td>Estudo 1</td>
                            <td>Autor 1</td>
                            <td>2023</td>
                            <td>Base de Dados A</td>
                            <td>
                                <select class="form-control statusSelect" data-study-id="1">
                                    <option value="not_extracted">Não Extraído</option>
                                    <option value="extracted">Extraído</option>
                                    <option value="removed">Removido</option>
                                </select>
                            </td>
                        </tr>
                        <tr data-id="2">
                            <td>2</td>
                            <td>Estudo 2</td>
                            <td>Autor 2</td>
                            <td>2022</td>
                            <td>Base de Dados B</td>
                            <td>
                                <select class="form-control statusSelect" data-study-id="2">
                                    <option value="not_extracted">Não Extraído</option>
                                    <option value="extracted">Extraído</option>
                                    <option value="removed">Removido</option>
                                </select>
                            </td>
                        </tr>
                        <tr data-id="3">
                            <td>3</td>
                            <td>Estudo 3</td>
                            <td>Autor 3</td>
                            <td>2021</td>
                            <td>Base de Dados C</td>
                            <td>
                                <select class="form-control statusSelect" data-study-id="3">
                                    <option value="not_extracted">Não Extraído</option>
                                    <option value="extracted">Extraído</option>
                                    <option value="removed">Removido</option>
                                </select>
                            </td>
                        </tr>
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
            $('#study-selection-table').DataTable({
                "searching": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json"
                }
            });

            $('#study-selection-table tbody').on('click', 'tr', function() {
                const studyId = $(this).data('id');
                $('#studyDetails').removeClass('d-none');
                $('#question1').val(`Resposta para a pergunta 1 do Estudo ${studyId}`);
                $('#question2').val(`Resposta para a pergunta 2 do Estudo ${studyId}`);
                $('#question3').val(`Resposta para a pergunta 3 do Estudo ${studyId}`);
                $('#question4').val(`Resposta para a pergunta 4 do Estudo ${studyId}`);
            });

            $('#extractionForm').on('submit', function(event) {
                event.preventDefault();
                $('#statusFeedback').removeClass('d-none');
                setTimeout(function() {
                    $('#statusFeedback').addClass('d-none');
                }, 5000);
            });

            $('#study-selection-table tbody').on('change', '.statusSelect', function() {
                const studyId = $(this).data('study-id');
                const newStatus = $(this).val();
            });
        });
    </script>

</body>

</html>
