@extends("layouts.app", ["class" => "g-sidenav-show bg-gray-100"])

@section("content")
    @include("layouts.navbars.auth.topnav", ["title" => translationTopnav('planning')])

    <div class="row mt-4 mx-4">
        @include("project.components.project-header", ["activePage" => "planning", "project" => $project])

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    @include(
                        "project.components.project-tabs",
                        [
                            "header" => translationPlanning('planning'),
                            "tabs" => [
                                [
                                    "id" => "overall-info-tab",
                                    "label" => translationPlanning('overall.title'),
                                    "href" => "#overall-info",
                                ],
                                [
                                    "id" => "research-questions-tab",
                                    "label" => translationPlanning('research-questions.title'),
                                    "href" => "#research-questions",
                                ],
                                [
                                    "id" => "data-bases-tab",
                                    "label" => translationPlanning('databases.title'),
                                    "href" => "#data-bases",
                                ],
                                [
                                    "id" => "search-string-tab",
                                    "label" => translationPlanning('search-string.title'),
                                    "href" => "#search-string",
                                ],
                                [
                                    "id" => "search-strategy-tab",
                                    "label" => translationPlanning('search-strategy.title'),
                                    "href" => "#search-strategy",
                                ],
                                [
                                    "id" => "criteria-tab",
                                    "label" => translationPlanning('criteria.title'),
                                    "href" => "#criteria",
                                ],
                                [
                                    "id" => "quality-assessment-tab",
                                    "label" => translationPlanning('quality-assessment.title'),
                                    "href" => "#quality-assessment",
                                ],
                                [
                                    "id" => "data-extraction-tab",
                                    "label" => translationPlanning('data-extraction.title'),
                                    "href" => "#data-extraction",
                                ],
                            ],
                            "activeTab" => "overall-info-tab",
                        ]
                    )

                    <div class="tab-content mt-4">
                        <div
                            class="tab-pane fade show active"
                            id="overall-info"
                        >
                            @include("project.planning.overall")
                        </div>
                        <div class="tab-pane fade" id="research-questions">
                            @livewire("planning.questions.research-questions")
                        </div>
                        <div class="tab-pane fade" id="data-bases">
                            @livewire("planning.databases.databases")
                        </div>
                        <div class="tab-pane fade" id="search-string">
                            @livewire("planning.search-string.search-term")
                        </div>
                        <div class="tab-pane fade" id="search-strategy">
                            @livewire("planning.search-strategy.strategy")
                        </div>
                        <div class="tab-pane fade" id="criteria">
                            @livewire("planning.criteria.criteria")
                        </div>
                        <div class="tab-pane fade" id="quality-assessment">
                            @include("project.planning.quality-assessment")
                        </div>
                        <div class="tab-pane fade" id="data-extraction">
                            {{-- @livewire("planning.data-extraction.data-extraction") --}}
                            @include("project.planning.data-extraction.index")
                        </div>
                    </div>
                </div>
                @include("layouts.footers.auth.footer")
            </div>
        </div>
    </div>

    @if (session()->has("activePlanningTab"))
        <script>
            window.onload = function () {
                // Remove active class from overall-info tab
                document
                    .getElementById('overall-info-tab')
                    .classList.remove('active');
                // Remove active class from overall-info content
                document
                    .getElementById('overall-info')
                    .classList.remove('show', 'active');

                // Get the tab ID stored in the session
                var activeTabId = '{{ session("activePlanningTab") }}';

                // Add active class to the tab stored in the session
                document
                    .getElementById(activeTabId + '-tab')
                    .classList.add('active');
                // Add active show class to the tab content stored in the session
                document
                    .getElementById(activeTabId)
                    .classList.add('show', 'active');
            };
        </script>
    @endif
@endsection
