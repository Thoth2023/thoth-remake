<div class="d-flex flex-column gap-4">
    <div class="card">
      <div class="card-body">
        <div class="card-header mb-0 pb-0">
            <x-helpers.modal
                target="import-studies"
                modalTitle="{{ __('project/conducting.data-extraction.title') }}"
                modalContent="{{ __('project/conducting.data-extraction.help.content') }}"
            />
        </div>
          <br/><br/>
             <div class="d-flex flex-column">
                <div class="progress" style="height: 18px">
                    <div id="prog_done" class="progress-bar bg-success" role="progressbar" style="width: 60%"
                        aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">0%</div>
                    <div id="prog_to_do" class="progress-bar bg-dark" role="progressbar" style="width: 30%"
                        aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">0%</div>
                    <div id="prog_rem_ex" class="progress-bar bg-info" role="progressbar" style="width: 10%"
                        aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
             </div>

                <br>
                <div class="form-inline">
                    <div class="input-group col-md-2">
                        <label class="text-success">
                            <span class="fas fa-check fa-lg"></span>
                            {{ __('project/conducting.data-extraction.status.done') }}: <span id="count_done">0</span>
                        </label>
                    </div>
                    <div class="input-group col-md-2">
                        <label class="text-dark">
                            <span class="fas fa-times fa-lg"></span>
                            {{ __('project/conducting.data-extraction.status.todo') }}: <span id="count_to_do">0</span>
                        </label>
                    </div>
                    <div class="input-group col-md-2">
                        <label class="text-info">
                            <span class="fas fa-trash-alt fa-lg"></span>
                            {{ __('project/conducting.data-extraction.status.removed') }}: <span
                                id="count_rem_ex">0</span>
                        </label>
                    </div>
                    <div class="input-group col-md-2">
                        <label class="text-secondary">
                            <span class="fas fa-bars fa-lg"></span>
                            {{ __('project/conducting.data-extraction.status.total') }}: <span
                                id="count_total_ex">0</span>
                        </label>
                    </div>
                </div>
                <br>
                <table class="table table-xs" id="table_papers_extraction">
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
                        @if(count($studies) > 0)
                            @foreach($studies as $study)
                                <tr>
                                    <td>{{ $study->id_paper }}</td>
                                    <td>{{ $study->title }}</td>
                                    <td>{{ $study->author }}</td>
                                    <td>{{ $study->year }}</td>
                                    @foreach ($databases as $database)
                                        @if ($study->data_base == $database->id_database)
                                        <td>{{ substr($database->name, 0, 10) }}</td>
                                        @endif
                                    @endforeach
                                    @if ($study->status_extraction == 1)
                                        <td id="status_{{ $study->status_extraction }}">
                                            {{ __('project/conducting.data-extraction.status.done') }}</td>
                                    @elseif ($study->status_extraction == 2)
                                        <td id="status_{{ $study->status_extraction }}">
                                            {{ __('project/conducting.data-extraction.status.todo') }}</td>
                                    @else
                                        <td id="status_{{ $study->status_extraction }}">
                                            {{ __('project/conducting.data-extraction.status.removed') }}</td>
                                    @endif
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm btn-view-paper" data-toggle="modal"
                                        data-target="#modal_paper_ex" data-paper-id="{{ $study->id_paper }}">
                                            {{ __('project/conducting.data-extraction.details') }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
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
        let studies = {!! json_encode($studies) !!};
        let databases = {!! json_encode($databases) !!};

        function updateProgress() {
            var doneCount = 0;
            var toDoCount = 0;
            var removedCount = 0;
            var totalCount = 0;

            $('#table_papers_extraction tbody tr').each(function () {
                totalCount++;
                var statusTd = $(this).find('td[id^="status_"]');
                var status = statusTd.attr('id');
                if (status === 'status_1') {
                    doneCount++;
                } else if (status === 'status_2') {
                    toDoCount++;
                } else if (status === 'status_3') {
                    removedCount++;
                }
            });

            var donePercentage = (doneCount / totalCount) * 100;
            var toDoPercentage = (toDoCount / totalCount) * 100;
            var removedPercentage = (removedCount / totalCount) * 100;

            $('#prog_done').css('width', donePercentage + '%').attr('aria-valuenow', donePercentage).text(donePercentage.toFixed(0) + '%');
            $('#prog_to_do').css('width', toDoPercentage + '%').attr('aria-valuenow', toDoPercentage).text(toDoPercentage.toFixed(0) + '%');
            $('#prog_rem_ex').css('width', removedPercentage + '%').attr('aria-valuenow', removedPercentage).text(removedPercentage.toFixed(0) + '%');

            $('#count_done').text(doneCount);
            $('#count_to_do').text(toDoCount);
            $('#count_rem_ex').text(removedCount);
            $('#count_total_ex').text(totalCount);
        }

        $(document).ready(function () {
            updateProgress();
            $('.btn-view-paper').click(function () {
                var button = $(this);
                var paperId = button.data('paper-id');

                studies.forEach(function (study) {
                    if (paperId == study.id_paper) {
                        var title = study.title;
                        var doi = study.doi;
                        var url = study.url;
                        var author = study.author;
                        var year = study.year;
                        var databaseID = study.data_base;
                        var databaseName = '';
                        databases.forEach(database => {
                            if (databaseID == database.id_database) {
                                databaseName = database.name;
                            }
                        });
                        var keywords = study.keywords;
                        var abstract = study.abstract;
                        $('#paper_title_ex').text(title);
                        $('#paper_doi_ex').attr('href', doi).text(doi);
                        $('#paper_url_ex').attr('href', url).text(url);
                        $('#paper_author_ex').text(author);
                        $('#paper_year_ex').text(year);
                        $('#paper_database_ex').text(databaseName);
                        $('#paper_keywords_ex').text(keywords);
                        $('#paper_abstract_ex').text(abstract);
                        $('#paper_id_ex').text('ID: ' + paperId);

                        var statusText = $('#status_' + paperId).text();
                        $('#text_ex').text('Status: ' + statusText);
                        $('#edit_status_ex').val(statusText);

                        showQuestions();
                        $('#modal_paper_ex').modal('show');

                        $('#edit_status_ex').off('change').on('change', function () {
                            var newStatus = $(this).val();
                            $('#status_' + paperId).text(newStatus);
                            updateProgress();
                        });
                    }
                });
            });
        });

    </script>
