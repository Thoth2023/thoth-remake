@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content') 

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-EW1W7Jea6l9mZq7r8w4g+Lj/h5gPflAPeR4x6WVNOe4atK8OeGWeR7hQYdj4k8ntQF6ZfXKgKJVlWGfTNvCHhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />


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
        font-size: 24px; /* Tamanho do ícone */
        cursor: pointer;
    }

    </style>
    @stack('styles')


    @include('layouts.navbars.auth.topnav', ['title' => 'Export'])

    <div class="row mt-4 mx-4">

        @include('project.components.project-header', ['project' => $project, 'activePage' => 'export'])

        <div class="container-fluid py-4">
            <div class="container-fluid py-4">

                <div class="card card-frame mt-5">
                    <div class="card-group justify-content-center">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <h3 class="card-title>">Export</h3>
                                        <p> Que etapa você gostaria de exportar?</p>

                                        <div class="checkbox-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckDefault1">
                                                <label class="form-check-label" for="flexCheckDefault1">
                                                    Planning
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckDefault2">
                                                <label class="form-check-label" for="flexCheckDefault2">
                                                    Import Study
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckDefault3">
                                                <label class="form-check-label" for="flexCheckDefault3">
                                                    Study Selection
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckDefault4" width="50" height="50">
                                                <label class="form-check-label" for="flexCheckDefault4">
                                                    Quality Assessment
                                                </label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success mt-3" onclick="generateBibTex()">
                                            Gerar Exportação
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-frame mt-5">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8" style="position: relative;">
                                <h3 class="card-title">BibTex</h3>
                                <div style="position: relative;">

                                  

                                    <textarea name="bibTex-generated" class="form-control" id="bibTex-generated" rows="8" data-lt-tmp-id="lt-532503" spellcheck="false" data-gramm="false"> </textarea>


                                    <div class="copy-icon-container">
                                        <i class="fas fa-copy copy-icon" onclick="copyToClipboard()"></i>
                                    </div>
                                </div>
                                 <!-- Botão "Baixar" movido para dentro da div .col-8 -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-success mt-3">
                                    Baixar
                                </button>
                                <button type="submit" class="btn btn-success mt-3">
                                    Criar Projeto no Overleaf
                                </button>
                            </div>
                            </div> <!-- Fechamento da div .col-8 -->




                
                            
                        </div> <!-- Fechamento da div .row -->
                    </div> <!-- Fechamento da div .card-body -->
                </div> <!-- Fechamento da div .card -->

        </div>
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




        </script>
    @endpush
@endsection
