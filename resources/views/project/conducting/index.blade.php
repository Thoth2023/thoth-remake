@extends("layouts.app", ["class" => "g-sidenav-show bg-gray-100"])

@section("content")
    @include("layouts.navbars.auth.topnav", ["title" => "Conducting"])

    <div class="row mt-4 mx-4">
        @include("project.components.project-header", ["project" => $project, "activePage" => "conducting"])

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    @include(
                        "project.components.project-tabs",
                        [
                            "header" => "Conducting",
                            "tabs" => [
                                [
                                    "id" => "overview-tab",
                                    "label" => "Overview",
                                    "href" => "#overview",
                                ],
                                [
                                    "id" => "import-studies-tab",
                                    "label" => "Import Studies",
                                    "href" => "#import-studies",
                                ],
                                [
                                    "id" => "study-selection-tab",
                                    "label" => "Study Selection",
                                    "href" => "#study-selection",
                                ],
                                [
                                    "id" => "quality-assessment-tab",
                                    "label" => "Quality Assessment",
                                    "href" => "#quality-assessment",
                                ],
                                [
                                    "id" => "data-extraction-tab",
                                    "label" => "Data Extraction",
                                    "href" => "#data-extraction",
                                ],
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
                        <div class="tab-pane fade" id="study-selection">
                            <!-- Content for Study Selection tab -->
                            <div
                                id="papers_per_selection"
                                style="height: 400px"
                                class="card my-2 p-2"
                            ></div>
                        </div>
                        <div class="tab-pane fade" id="quality-assessment">
                            <!-- Content for Quality Assessment tab -->
                            <div
                                id="papers_per_quality"
                                style="height: 400px"
                                class="card my-2 p-2"
                            ></div>
                            <div
                                id="papers_gen_score"
                                style="height: 400px"
                                class="card my-2 p-2"
                            ></div>
                        </div>
                        <div class="tab-pane fade" id="data-extraction">
                            <!-- Content for Data Extraction tab -->
                        </div>
                    </div>
                </div>
            </div>
            @include("layouts.footers.auth.footer")
        </div>
    </div>
@endsection
