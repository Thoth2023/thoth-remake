@extends("layouts.app", ["class" => "g-sidenav-show bg-gray-100"])

@section("content")
    @include("layouts.navbars.auth.topnav", ["title" => __("nav/topnav.planning")])

    <div class="row mt-4 mx-4">
        @include("project.components.project-header", ["activePage" => "planning", "project" => $project])

        @php
            $tabs = [
                [
                    'id' => 'overall-info-tab',
                    'label' => __('project/planning.overall.title'),
                    'href' => '#overall-info',
                ],
                [
                    'id' => 'research-questions-tab',
                    'label' => __('project/planning.research-questions.title'),
                    'href' => '#research-questions',
                ],
                [
                    'id' => 'data-bases-tab',
                    'label' => __('project/planning.databases.title'),
                    'href' => '#data-bases',
                ],
                [
                    'id' => 'search-string-tab',
                    'label' => __('project/planning.search-string.title'),
                    'href' => '#search-string',
                ],
                [
                    'id' => 'search-strategy-tab',
                    'label' => __('project/planning.search-strategy.title'),
                    'href' => '#search-strategy',
                ],
                [
                    'id' => 'criteria-tab',
                    'label' => __('project/planning.criteria.title'),
                    'href' => '#criteria',
                ],
                [
                    'id' => 'quality-assessment-tab',
                    'label' => __('project/planning.quality-assessment.title'),
                    'href' => '#quality-assessment',
                ],
                [
                    'id' => 'data-extraction-tab',
                    'label' => __('project/planning.data-extraction.title'),
                    'href' => '#data-extraction',
                ],
            ];
        @endphp

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    @include("project.components.project-tabs", [
                        "header" => __("project/planning.planning"),
                        "content" => __("project/planning.content-helper"),
                        "tabs" => $tabs,
                        "activeTab" => "overall-info-tab",
                        "scope" => "planning",
                    ])

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
                            @include("project.planning.data-extraction")
                        </div>
                    </div>
                </div>
            </div>
            @include("layouts.footers.auth.footer")
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    @push('js')
        <script>
            // Armazena a aba ativa em um cookie ao clicar
            document.addEventListener('DOMContentLoaded', function () {
                const tabLinks = document.querySelectorAll('[data-bs-toggle="tab"]');

                tabLinks.forEach(link => {
                    link.addEventListener('shown.bs.tab', function (event) {
                        const tabId = event.target.getAttribute('href').substring(1); // remove o #
                        document.cookie = "activePlanningTab=" + tabId + ";path=/";
                    });
                });

                // Recupera e ativa a aba armazenada no cookie, se houver
                const cookies = document.cookie.split(';').reduce((acc, cookie) => {
                    const [key, value] = cookie.split('=').map(c => c.trim());
                    acc[key] = value;
                    return acc;
                }, {});

                if (cookies.activePlanningTab) {
                    const tabTrigger = document.querySelector(`[href="#${cookies.activePlanningTab}"]`);
                    if (tabTrigger) {
                        new bootstrap.Tab(tabTrigger).show();
                    }
                }
            });
        </script>
    @endpush
@endsection
