@extends("layouts.app", ["class" => "g-sidenav-show bg-gray-100"])

@section("content")
    @include("layouts.navbars.auth.topnav", ["title" => __("nav/topnav.planning")])

    <div class="row mt-4 mx-4">
        @include("project.components.project-header", ["activePage" => "planning", "project" => $project])

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    @include(
                        "project.components.project-tabs",
                        [
                            "header" => __("project/planning.planning"),
                            "tabs" => [
                                [
                                    "id" => "overall-info-tab",
                                    "label" => __("project/planning.overall.title"),
                                    "href" => "#overall-info",
                                ],
                                [
                                    "id" => "research-questions-tab",
                                    "label" => __("project/planning.research-questions.title"),
                                    "href" => "#research-questions",
                                ],
                                [
                                    "id" => "data-bases-tab",
                                    "label" => __("project/planning.databases.title"),
                                    "href" => "#data-bases",
                                ],
                                [
                                    "id" => "search-string-tab",
                                    "label" => __("project/planning.search-string.title"),
                                    "href" => "#search-string",
                                ],
                                [
                                    "id" => "search-strategy-tab",
                                    "label" => __("project/planning.search-strategy.title"),
                                    "href" => "#search-strategy",
                                ],
                                [
                                    "id" => "criteria-tab",
                                    "label" => __("project/planning.criteria.title"),
                                    "href" => "#criteria",
                                ],
                                [
                                    "id" => "quality-assessment-tab",
                                    "label" => __("project/planning.quality-assessment.title"),
                                    "href" => "#quality-assessment",
                                ],
                                [
                                    "id" => "data-extraction-tab",
                                    "label" => __("project/planning.data-extraction.title"),
                                    "href" => "#data-extraction",
                                ],
                            ],
                            "activeTab" => "overall-info-tab",
                            // IMPORTANTE: dá um escopo único para não conflitar com outras páginas que usam o mesmo componente
                            "scope" => "planning"
                        ]
                    )

                    <div class="tab-content mt-4">
                        <div class="tab-pane fade show active" id="overall-info" role="tabpanel" aria-labelledby="overall-info-tab">
                            @include("project.planning.overall")
                        </div>
                        <div class="tab-pane fade" id="research-questions" role="tabpanel" aria-labelledby="research-questions-tab">
                            @livewire("planning.questions.research-questions")
                        </div>
                        <div class="tab-pane fade" id="data-bases" role="tabpanel" aria-labelledby="data-bases-tab">
                            @livewire("planning.databases.databases")
                        </div>
                        <div class="tab-pane fade" id="search-string" role="tabpanel" aria-labelledby="search-string-tab">
                            @livewire("planning.search-string.search-term")
                        </div>
                        <div class="tab-pane fade" id="search-strategy" role="tabpanel" aria-labelledby="search-strategy-tab">
                            @livewire("planning.search-strategy.strategy")
                        </div>
                        <div class="tab-pane fade" id="criteria" role="tabpanel" aria-labelledby="criteria-tab">
                            @livewire("planning.criteria.criteria")
                        </div>
                        <div class="tab-pane fade" id="quality-assessment" role="tabpanel" aria-labelledby="quality-assessment-tab">
                            @include("project.planning.quality-assessment")
                        </div>
                        <div class="tab-pane fade" id="data-extraction" role="tabpanel" aria-labelledby="data-extraction-tab">
                            @include("project.planning.data-extraction.index")
                        </div>
                    </div>
                </div>
                @include("layouts.footers.auth.footer")
            </div>
        </div>
    </div>
@endsection
