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
                        <div class="tab-pane fade" id="import-studies">
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
                                @include("project.conducting.snowballing", ['snowballing_projects' => $snowballing_projects])
                            </div>
                        @endif

                        <div id="data-extraction" class="tab-pane fade">
                            @include("project.conducting.data-extraction")
                        </div>
                    </div>
                </div>
            </div>

            @include('layouts.footers.auth.footer')

        </div>
    </div>
    </div>

    @if (session()->has("activePlanningTab"))
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
                var activeTabId = '{{ session("activePlanningTab") }}';

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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Adicionar um ouvinte de evento para cada aba
            var tabs = document.querySelectorAll('[id$="-tab"]');
            tabs.forEach(function (tab) {
                tab.addEventListener('click', function () {
                    var tabId = this.id.replace('-tab', '');
                    fetch('/set-active-tab', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({ activeTab: tabId }),
                    });
                });
            });
        });
    </script>

@endsection
