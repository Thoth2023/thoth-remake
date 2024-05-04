@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Conducting'])

    <div class="row mt-4 mx-4">

        @include(
            'project.components.project-header',
            ['activePage' => 'conducting'],
            ['project' => $project]
        )

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    @include('project.components.project-tabs', [
                        'header' => 'Conducting',
                        'tabs' => [
                            [
                                'id' => 'import-studies-tab',
                                'label' => 'Import Studies',
                                'href' => '#import-studies',
                            ],
                            [
                                'id' => 'study-selection-tab',
                                'label' => 'Study Selection',
                                'href' => '#study-selection',
                            ],
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
                        'activeTab' => 'import-studies-tab',
                    ])

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="import-studies">
                            @include('project.conducting.import-studies')
                        </div>
                        <div class="tab-pane fade" id="study-selection">
                            @include('project.conducting.study-selection')
                        </div>
                        <div class="tab-pane fade" id="quality-assessment">
                            @include('project.conducting.quality-assessment')
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


    @if (session()->has('activeConductingTab'))
        <script>
            window.onload = function() {
                // Remove active class from import-studies tab
                document.getElementById('import-studies-tab').classList.remove('active');
                // Remove active class from import-studies content
                document.getElementById('import-studies').classList.remove('show', 'active');

                // Get the tab ID stored in the session
                var activeTabId = '{{ session('activeConductingTab') }}';

                // Add active class to the tab stored in the session
                document.getElementById(activeTabId + '-tab').classList.add('active');
                // Add active show class to the tab content stored in the session
                document.getElementById(activeTabId).classList.add('show', 'active');
            }
        </script>
    @endif
@endsection
