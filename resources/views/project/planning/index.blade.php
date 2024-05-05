@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Planning'])

    <div class="row mt-4 mx-4">

        @include(
            'project.components.project-header',
            ['activePage' => 'planning'],
            ['project' => $project]
        )

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    @include('project.components.project-tabs', [
                        'header' => 'Planning',
                        'tabs' => [
                            [
                                'id' => 'overall-info-tab',
                                'label' => 'Overall Information',
                                'href' => '#overall-info',
                            ],
                            [
                                'id' => 'research-questions-tab',
                                'label' => 'Research Questions',
                                'href' => '#research-questions',
                            ],
                            ['id' => 'data-bases-tab', 'label' => 'Data Bases', 'href' => '#data-bases'],
                            ['id' => 'search-string-tab', 'label' => 'Search String', 'href' => '#search-string'],
                            [
                                'id' => 'search-strategy-tab',
                                'label' => 'Search Strategy',
                                'href' => '#search-strategy',
                            ],
                            ['id' => 'criteria-tab', 'label' => 'Criteria', 'href' => '#criteria'],
                            [
                                'id' => 'quality-assessment-tab',
                                'label' => 'Quality Assessment',
                                'href' => '#quality-assessment',
                            ],
                            [
                                'id' => 'data-extraction-tab',
                                'label' => 'Data Extraction',
                                'href' => '#data-extraction',
                            ],
                        ],
                        'activeTab' => 'overall-info-tab',
                    ])

                    <div class="tab-content mt-4">
                        <div class="tab-pane fade show active" id="overall-info">
                            @include('project.planning.overall')
                        </div>
                        <div class="tab-pane fade" id="research-questions">
                            @include('project.planning.research-questions')
                        </div>
                        <div class="tab-pane fade" id="data-bases">
                            @include('project.planning.databases')
                        </div>
                        <div class="tab-pane fade" id="search-string">
                            [wip]
                        </div>
                        <div class="tab-pane fade" id="search-strategy">
                            @include('project.planning.search-strategy')
                        </div>
                        <div class="tab-pane fade" id="criteria">
                            @include('project.planning.criteria.index')
                        </div>
                        <div class="tab-pane fade" id="quality-assessment">
                            [wip]
                        </div>
                        <div class="tab-pane fade" id="data-extraction">
                            @include('project.planning.data-extraction.index')
                        </div>

                    </div>

                </div>
                @include('layouts.footers.auth.footer')
            </div>
        </div>
    </div>


    @if (session()->has('activePlanningTab'))
        <script>
            window.onload = function() {
                // Remove active class from overall-info tab
                document.getElementById('overall-info-tab').classList.remove('active');
                // Remove active class from overall-info content
                document.getElementById('overall-info').classList.remove('show', 'active');

                // Get the tab ID stored in the session
                var activeTabId = '{{ session('activePlanningTab') }}';

                // Add active class to the tab stored in the session
                document.getElementById(activeTabId + '-tab').classList.add('active');
                // Add active show class to the tab content stored in the session
                document.getElementById(activeTabId).classList.add('show', 'active');
            }
        </script>
    @endif
@endsection
