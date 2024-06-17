<body>
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

            $('#study-selection-table tbody').on('click', 'tr', function () {
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
        });
    </script>
</body>
</html>
