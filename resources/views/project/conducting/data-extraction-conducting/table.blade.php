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
                        <th class="text-uppercase text-secondary">{{ __('project/conducting.table.data_base') }}</th>
                        <th class="text-uppercase text-secondary">{{ __('project/conducting.table.status') }}</th>
                    </tr>
                </thead>
                <!-- Your table body here -->
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
});
</script>

</body>
</html>
