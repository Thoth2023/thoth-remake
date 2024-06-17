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
                            'header' => __('project/conducting.conducting'),
                            "tabs" => [
                              [
                                    "id" => "overview-tab",
                                    "label" => "Overview",
                                    "href" => "#overview",
                              ],
                              [
                                  'id' => 'import-studies-tab',
                                  'label' => __('project/conducting.header.import_studies'),
                                  'href' => '#import-studies',
                              ],
                              [
                                  'id' => 'snowballing-tab',
                                  'label' => __('project/conducting.header.snowballing'),
                                  'href' => '#snowballing',
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
                              [
                                  'id' => 'data-extraction-tab',
                                  'label' => __('project/conducting.header.data_extraction'),
                                  'href' => '#data-extraction',
                              ],
                         
                            "activeTab" => "overview-tab",
                        ]
                    )
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="overview">
                            <!-- Content for Overview tab -->
                            <div
                                id="overviewFunnelChart"
                                style="height: 400px"
                                class="card my-2 p-2"
                            ></div>
                            <div
                                id="overviewChart"
                                style="height: 400px"
                                class="card my-2 p-2"
                            ></div>
                        </div>
                        <div class="tab-pane fade" id="import-studies">
                            <!-- Content for Import Studies tab -->
                            <div
                                id="papers_per_database"
                                style="height: 400px"
                                class="card my-2 p-2"
                            >
                                @livewire("conducting.import-studies")
                        </div>
                        </div>
                        <div id="snowballing" class="tab-pane fade">
                            @include("project.conducting.snowballing", ['snowballing_projects' => $snowballing_projects])
                        </div>
                        <div id="study-selection" class="tab-pane fade">
                            @include("project.conducting.study-selection")
                        </div>
                        <div id="quality-assessment" class="tab-pane fade">
                            @include("project.conducting.quality-assessment")
                        </div>
                        <div id="data-extraction" class="tab-pane fade">
                            @include("project.conducting.data-extraction")
                        </div>
                    </div>
                </div>
            </div>
            @include("layouts.footers.auth.footer")
        </div>
    </div>
@endsection
