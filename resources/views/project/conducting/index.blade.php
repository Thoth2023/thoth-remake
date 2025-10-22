@extends("layouts.app", ["class" => "g-sidenav-show bg-gray-100"])

@section("content")
    @include("layouts.navbars.auth.topnav", ["title" => __('nav/topnav.conducting')])

    <div class="row mt-4 mx-4">
        @include("project.components.project-header", [
            "project" => $project,
            "activePage" => "conducting"
        ])

        <div class="container-fluid py-4">
            <div class="row">

                <div class="col-12">
                    @if (session()->has('error'))
                        <div class='card card-body col-md-12 mt-3'>
                            <h3 class="h5 mb-3">{{ __('project/conducting.study-selection.tasks') }}</h3>
                            <div class="alert alert-warning" id="errorMessage">
                                <ul>
                                {!! session('error') !!}
                                </ul>
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const errorElement = document.getElementById('errorMessage');
                                if (errorElement) {
                                    errorElement.innerText = decodeHtmlEntities(errorElement.innerText);
                                }
                            });
                        </script>
                    @else
                    @include(
                        "project.components.project-tabs",
                        [
                            'header' => __('project/conducting.conducting.title'),
                            "tabs" => collect([
                                [
                                    'id' => 'import-studies-tab',
                                    'label' =>__('project/conducting.header.import_studies'),
                                    'href' => '#import-studies',
                                ],
                                [
                                    'id' => 'study-selection-tab',
                                    'label' => __('project/conducting.header.study_selection'),
                                    'href' => '#study-selection',
                                ],
                                [
                                    'id' => 'quality-assessment-tab',
                                    'label' => __('project/conducting.header.quality_assessment'),
                                    'href' => '#quality-assessment',
                                ],

                            ])->when(strpos($project->feature_review, 'Snowballing') !== false || strpos($project->feature_review, 'Systematic Review and Snowballing') !== false, function ($collection) {
                                return $collection->push([
                                    'id' => 'snowballing-tab',
                                    'label' => __('project/conducting.header.snowballing'),
                                    'href' => '#snowballing',
                                ]);

                            })->push([
                                'id' => 'data-extraction-tab',
                                'label' => __('project/conducting.header.data_extraction'),
                                'href' => '#data-extraction',

                            ]),
                            "activeTab" => "import-studies-tab",
                        ]
                    )

                    <div class="tab-content mt-4">
                        <div class="tab-pane fade show active" id="import-studies">
                            <!-- Conteúdo da aba Import Studies -->
                            @livewire("conducting.file-upload")
                        </div>

                        <div id="study-selection" class="tab-pane fade">
                            @include("project.conducting.study-selection.index", ["project" => $project])
                        </div>

                        <div id="quality-assessment" class="tab-pane fade">
                            @include("project.conducting.quality-assessment.index", ["project" => $project])
                        </div>

                        @if (strpos($project->feature_review, 'Snowballing') !== false || strpos($project->feature_review, 'Systematic Review and Snowballing') !== false)
                            <div id="snowballing" class="tab-pane fade">
                                @include("project.conducting.snowballing.index",["project" => $project])
                            </div>
                        @endif

                        <div id="data-extraction" class="tab-pane fade">
                            @include("project.conducting.data-extraction.index", ["project" => $project])
                        </div>
                    </div>
                    @endif
                </div>

            </div>

            @include('layouts.footers.auth.footer')

        </div>
    </div>
    </div>



    @if (session()->has("activeConductingTab"))
        <script>
            window.onload = function () {
                // Remover a classe active da aba import-studies-tab
                document
                    .getElementById('import-studies-tab')
                    .classList.remove('active');
                // Remover a classe active e show do conteúdo import-studies
                document
                    .getElementById('import-studies')
                    .classList.remove('show', 'active');

                // Obter o ID da aba armazenada na sessão
                var activeTabId = '{{ session("activeConductingTab") }}';

                // Adicionar a classe active à aba armazenada na sessão
                document
                    .getElementById(activeTabId + '-tab')
                    .classList.add('active');
                // Adicionar as classes show e active ao conteúdo da aba armazenada na sessão
                document
                    .getElementById(activeTabId)
                    .classList.add('show', 'active');
            };
        </script>
    @endif
@endsection
