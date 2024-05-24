@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-EW1W7Jea6l9mZq7r8w4g+Lj/h5gPflAPeR4x6WVNOe4atK8OeGWeR7hQYdj4k8ntQF6ZfXKgKJVlWGfTNvCHhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .form-check {
            display: inline-block;
            margin-right: 10px;
        }
        .form-check-input {
            width: 30px;
            /* largura */
            height: 30px;
            /* altura */
        }
        .form-check-label {
            font-size: 20px;
            /* tamanho da fonte */
            margin-top: 5px
        }
        .copy-icon-container {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 40px;
            height: 40px;
            background-color: #007bff;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .copy-icon {
            color: white;
            font-size: 24px;
            /* Tamanho do ícone */
            cursor: pointer;
        }
    </style>
    @stack('styles')
    @include('layouts.navbars.auth.topnav', ['title' => 'Export'])
    <div class="row mt-4 mx-4">
        @include('project.components.project-header', ['project' => $project, 'activePage' => 'export'])
        <div class="container-fluid py-4">
            <div class="container-fluid py-4">
                @livewire('export.export-options')
                @livewire('export.text-area-and-download')
        </div>
        @include('layouts.footers.auth.footer')
    </div>
    </div>
@endsection
@section('scripts')
    @parent
    @push('js')
        {{-- <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/funnel.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
        <script>
            // Function to store the active tab in a cookie
            function storeActiveTab(tabId) {
                document.cookie = "activeReportingTab=" + tabId + ";path=/"; /*  */
            }
            // Sample Highcharts chart
            document.addEventListener('DOMContentLoaded', function() {
            });
            function copyToClipboard() {
                var textarea = document.getElementById('bibTex-generated');
                textarea.select();
                document.execCommand('copy');
                alert('Texto copiado para a área de transferência!');
            }
            function generateBibTex() {
                var bibTex = '';
                // Verificar qual checkbox está marcada
                if (document.getElementById('flexCheckDefault1').checked) {
                    // Conteúdo para o checkbox 1 (Planning)
                    bibTex = `@article{planning,
            author = {author1},
            title = {title1},
            journal = {journal1},
            year = {year1},
            volume = {volume1},
            number = {number1},
            pages = {pages1},
            month = {month1},
            doi = {doi1},
            url = {url1},
        }`;
                } else if (document.getElementById('flexCheckDefault2').checked) {
                    // Conteúdo para o checkbox 2 (Import Study)
                    bibTex = `@article{import_study,
            author = {author2},
            title = {title2},
            journal = {journal2},
            year = {year2},
            volume = {volume2},
            number = {number2},
            pages = {pages2},
            month = {month2},
            doi = {doi2},
            url = {url2},
        }`;
                } else if (document.getElementById('flexCheckDefault3').checked) {
                    // Conteúdo para o checkbox 3 (Study Selection)
                    bibTex = `@article{study_selection,
            author = {author3},
            title = {title3},
            journal = {journal3},
            year = {year3},
            volume = {volume3},
            number = {number3},
            pages = {pages3},
            month = {month3},
            doi = {doi3},
            url = {url3},
        }`;
                } else if (document.getElementById('flexCheckDefault4').checked) {
                    // Conteúdo para o checkbox 4 (Quality Assessment)
                    bibTex = `@article{quality_assessment,
            author = {author4},
            title = {title4},
            journal = {journal4},
            year = {year4},
            volume = {volume4},
            number = {number4},
            pages = {pages4},
            month = {month4},
            doi = {doi4},
            url = {url4},
        }`;
                } else {
                    // Se nenhum checkbox estiver marcado
                    bibTex = '@article{default,}';
                }
                document.getElementById('bibTex-generated').value = bibTex;
            }
            function downloadAsLatex() {
                console.log('Função downloadAsLatex() chamada.');
                var text = document.getElementById('bibTex-generated').value;
                // Verifica se o campo está vazio
                if (text.trim() === '') {
                    document.getElementById('error-message').innerText = 'O campo não pode estar vazio!';
                    return;
                } else {
                    // Se o campo não estiver vazio, limpa a mensagem de erro
                    document.getElementById('error-message').innerText = '';
                }
                var filename = "export.bib";
                var blob = new Blob([text], {
                    type: "text/plain;charset=utf-8"
                });
                saveAs(blob, filename);
                console.log('Download realizado com sucesso.');
            }
            function createProjectOnOverleaf() {
    generateBibTex(); // Gera o conteúdo LaTeX
    openInOverleaf(); // Envia o formulário para o Overleaf
}
// Verify here
function openInOverleaf() {
    var latexContent = document.getElementById('bibTex-generated').value;
    document.getElementById('snip_uri').value = 'data:text/plain;charset=utf-8,' + encodeURIComponent(latexContent);
    document.getElementById('overleafForm').submit(); // Envio do formulário
}


        </script>
    @endpush
@endsection
