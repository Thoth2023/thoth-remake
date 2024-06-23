{{-- <body>
    <div class="container">
        @include('project.conducting.data-extraction-conducting.progress-bar')
        @include('project.conducting.data-extraction-conducting.search-form')
        @include('project.conducting.data-extraction-conducting.table')
        @include('project.conducting.data-extraction-conducting.study-details')
        @include('project.conducting.data-extraction-conducting.feedbacks')
    </div>

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#study-selection-table').DataTable({
                "searching": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json"
                }
                "destroy": true
            });

            $('#extractionForm').on('submit', function(event) {
                event.preventDefault();
                $('#statusFeedback').removeClass('d-none');
                setTimeout(function() {
                    $('#statusFeedback').addClass('d-none');
                }, 5000);
            });
        });
    </script>
</body>
</html> --}}

<div class="card">
    <div class="card-body">
        <br>
        <label><strong>Data Extraction</strong></label>
        <br>
        <h6>Progress Data Extraction</h6>
        <div class="progress">
            <div id="prog_done" class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
            <div id="prog_to_do" class="progress-bar bg-dark" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
            <div id="prog_rem_ex" class="progress-bar bg-info" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">10%</div>
        </div>
        <br>
        <div class="form-inline">
            <div class="input-group col-md-2">
                <label class="text-success">
                    <span class="fas fa-check fa-lg"></span>
                    Done: <span id="count_done">60</span>
                </label>
            </div>
            <div class="input-group col-md-2">
                <label class="text-dark">
                    <span class="fas fa-times fa-lg"></span>
                    To Do: <span id="count_to_do">30</span>
                </label>
            </div>
            <div class="input-group col-md-2">
                <label class="text-info">
                    <span class="fas fa-trash-alt fa-lg"></span>
                    Removed: <span id="count_rem_ex">10</span>
                </label>
            </div>
            <div class="input-group col-md-2">
                <label class="text-secondary">
                    <span class="fas fa-bars fa-lg"></span>
                    Total: <span id="count_total_ex">100</span>
                </label>
            </div>
        </div>
        <br>
        <table class="table table-responsive-sm" id="table_papers_extraction">
            <caption>List of Papers for Data Extraction</caption>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Year</th>
                    <th>Database</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                {{-- Simulando alguns papers --}}
                <tr>
                    <td>1</td>
                    <td>Title 1</td>
                    <td>Author 1</td>
                    <td>2021</td>
                    <td>Database 1</td>
                    <td id="1" class="font-weight-bold text-success">Done</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Title 2</td>
                    <td>Author 2</td>
                    <td>2022</td>
                    <td>Database 2</td>
                    <td id="2" class="font-weight-bold text-dark">To Do</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Title 3</td>
                    <td>Author 3</td>
                    <td>2023</td>
                    <td>Database 3</td>
                    <td id="3" class="font-weight-bold text-info">Removed</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Year</th>
                    <th>Database</th>
                    <th>Status</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div class="alert alert-warning container-fluid alert-dismissible fade show" role="alert">
    <h5>Complete these tasks to advance</h5>
    <ul>
        <li>Task 1</li>
        <li>Task 2</li>
        <li>Task 3</li>
    </ul>
</div>

