<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <br>
                <label><strong>{{ __('project/conducting.data-extraction.title') }}</strong></label>
                <br>
                <h6>{{ __('project/conducting.data-extraction.progress-data-extraction') }}</h6>
                <div class="progress" style="height: 18px">
                    <div id="prog_done" class="progress-bar bg-success" role="progressbar" style="width: 60%"
                        aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
                    <div id="prog_to_do" class="progress-bar bg-dark" role="progressbar" style="width: 30%"
                        aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
                    <div id="prog_rem_ex" class="progress-bar bg-info" role="progressbar" style="width: 10%"
                        aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">10%</div>
                </div>
                <br>
                <div class="form-inline">
                    <div class="input-group col-md-2">
                        <label class="text-success">
                            <span class="fas fa-check fa-lg"></span>
                            {{ __('project/conducting.data-extraction.status.done') }}: <span id="count_done">60</span>
                        </label>
                    </div>
                    <div class="input-group col-md-2">
                        <label class="text-dark">
                            <span class="fas fa-times fa-lg"></span>
                            {{ __('project/conducting.data-extraction.status.todo') }}: <span id="count_to_do">30</span>
                        </label>
                    </div>
                    <div class="input-group col-md-2">
                        <label class="text-info">
                            <span class="fas fa-trash-alt fa-lg"></span>
                            {{ __('project/conducting.data-extraction.status.removed') }}: <span
                                id="count_rem_ex">10</span>
                        </label>
                    </div>
                    <div class="input-group col-md-2">
                        <label class="text-secondary">
                            <span class="fas fa-bars fa-lg"></span>
                            {{ __('project/conducting.data-extraction.status.total') }}: <span
                                id="count_total_ex">100</span>
                        </label>
                    </div>
                </div>
                <br>
                <table class="table table-responsive-sm" id="table_papers_extraction">
                    <caption>{{ __('project/conducting.data-extraction.list_studies') }}</caption>
                    <thead>
                        <tr>
                            <th>{{ __('project/conducting.data-extraction.table.id') }}</th>
                            <th>{{ __('project/conducting.data-extraction.table.title') }}</th>
                            <th>{{ __('project/conducting.data-extraction.table.author') }}</th>
                            <th>{{ __('project/conducting.data-extraction.table.year') }}</th>
                            <th>{{ __('project/conducting.data-extraction.table.database') }}</th>
                            <th>{{ __('project/conducting.data-extraction.table.status') }}</th>
                            <th>{{ __('project/conducting.data-extraction.table.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Title 1</td>
                            <td>Author 1</td>
                            <td>2021</td>
                            <td>Database 1</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdown_status_1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Status
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdown_status_1">
                                        <a class="dropdown-item" href="#" onclick="changeStatus(1, 'Done')">Done</a>
                                        <a class="dropdown-item" href="#" onclick="changeStatus(1, 'To Do')">To Do</a>
                                        <a class="dropdown-item" href="#"
                                            onclick="changeStatus(1, 'Removed')">Removed</a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm btn-view-paper" data-toggle="modal"
                                    data-target="#modal_paper_ex" data-paper-id="1">
                                    {{ __('project/conducting.data-extraction.details') }}
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Title 2</td>
                            <td>Author 2</td>
                            <td>2022</td>
                            <td>Database 2</td>
                            <td>]
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdown_status_1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Status
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdown_status_1">
                                        <a class="dropdown-item" href="#" onclick="changeStatus(1, 'Done')">Done</a>
                                        <a class="dropdown-item" href="#" onclick="changeStatus(1, 'To Do')">To Do</a>
                                        <a class="dropdown-item" href="#"
                                            onclick="changeStatus(1, 'Removed')">Removed</a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm btn-view-paper" data-toggle="modal"
                                    data-target="#modal_paper_ex" data-paper-id="2">
                                    {{ __('project/conducting.data-extraction.details') }}
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Title 3</td>
                            <td>Author 3</td>
                            <td>2023</td>
                            <td>Database 3</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdown_status_1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Status
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdown_status_1">
                                        <a class="dropdown-item" href="#" onclick="changeStatus(1, 'Done')">Done</a>
                                        <a class="dropdown-item" href="#" onclick="changeStatus(1, 'To Do')">To Do</a>
                                        <a class="dropdown-item" href="#"
                                            onclick="changeStatus(1, 'Removed')">Removed</a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm btn-view-paper" data-toggle="modal"
                                    data-target="#modal_paper_ex" data-paper-id="3">
                                    {{ __('project/conducting.data-extraction.details') }}
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ __('project/conducting.data-extraction.table.id') }}</th>
                            <th>{{ __('project/conducting.data-extraction.table.title') }}</th>
                            <th>{{ __('project/conducting.data-extraction.table.author') }}</th>
                            <th>{{ __('project/conducting.data-extraction.table.year') }}</th>
                            <th>{{ __('project/conducting.data-extraction.table.database') }}</th>
                            <th>{{ __('project/conducting.data-extraction.table.status') }}</th>
                            <th>{{ __('project/conducting.data-extraction.table.actions') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('project.components.data-extraction-conducting.modal_paper_ex')

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"
        integrity="sha384-D8R+zAoK5OKtOJR6VBMvaYuRZze+i/cacSA6kW0g1hCqcvKjpHrs26mN9RsVjFb"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+JS83K9ZL8J3er2rBXVl4+76S1qqN0eg4J1"
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            $('.btn-view-paper').click(function () {
                var paperId = $(this).data('paper-id');
                var title = 'Title ' + paperId;
                $('#paper_title_ex').text(title);
                $('#paper_id_ex').text('ID: ' + paperId);
                var statusText = $('#status_' + paperId).text();
                $('#text_ex').text('Status: ' + statusText);
                showQuestions();
                $('#modal_paper_ex').modal('show');
            });
        });
    </script>
</body>

</html>