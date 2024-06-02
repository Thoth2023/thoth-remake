@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Conducting'])

    <div class="row mt-4 mx-4">

        @include(
            'project.components.project-header',
            ['activePage' => 'conducting'],
            ["project" => $project]
        )

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                @include('project.components.project-tabs', [
                        'header' => __('project/conducting.conducting'),
                        'tabs' => [
                            [
                                'id' => 'import-studies-tab',
                                'label' => __('project/conducting.header.import_studies'),
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
                            [
                                'id' => 'data-extraction-tab',
                                'label' => __('project/conducting.header.data_extraction'),
                                'href' => '#data-extraction',
                            ],
                        ],
                        'activeTab' => 'overview-tab',
                    ])

                    <div class="tab-content mt-4" >
                        <div id="study-selection" class="tab-pane fade">
                            @include("project.conducting.study-selection")
                        </div>
                    </div>

                </div>
                @include('layouts.footers.auth.footer')
            </div>
        </div>
    </div>

@endsection