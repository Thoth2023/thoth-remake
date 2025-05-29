@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => __('nav/topnav.reporting')])

    <div class="row mt-4 mx-4">
        @include('project.components.project-header', ['project' => $project, 'activePage' => 'reporting'])
        @php
            $tabs = [
                [
                    'id' => 'overview-tab',
                    'label' => __('project/reporting.header.overview'),
                    'href' => '#overview'
                ],
                [
                    'id' => 'import-studies-tab',
                    'label' => __('project/reporting.header.import_studies'),
                    'href' => '#import-studies',
                ],
                [
                    'id' => 'study-selection-tab',
                    'label' => __('project/reporting.header.study_selection'),
                    'href' => '#study-selection',
                ],
                [
                    'id' => 'quality-assessment-tab',
                    'label' => __('project/reporting.header.quality_assessment'),
                    'href' => '#quality-assessment',
                ],
                [
                    'id' => 'data-extraction-tab',
                    'label' => __('project/reporting.header.data_extraction'),
                    'href' => '#data-extraction',
                ],
                [
                    'id' => 'reliability-tab',
                    'label' => __('project/reporting.header.reliability'),
                    'href' => '#reliability',
                ],
            ];

            if (
                $project->feature_review === 'Systematic review and Snowballing' ||
                $project->feature_review === 'Snowballing'
            ) {
                $tabs[] = [
                    'id' => 'snowballing-tab',
                    'label' => __('project/reporting.header.snowballing'),
                    'href' => '#snowballing',
                ];
            }
        @endphp

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    @include('project.components.project-tabs', [
                        'header' => __('project/reporting.reporting'),
                        'tabs' => $tabs,
                        'activeTab' => 'overview-tab',
                    ])
                    <div class="tab-content mt-4">
                        <div class="tab-pane fade show active" id="overview">
                            <!-- Content for Overview tab -->
                            @livewire('reporting.overview')
                        </div>
                        <div class="tab-pane fade" id="import-studies">
                            <!-- Content for Import Studies tab -->
                            @livewire('reporting.import-studies')
                        </div>
                        <div class="tab-pane fade" id="study-selection">
                            <!-- Content for Study Selection tab -->
                            @livewire('reporting.study-selection')
                        </div>
                        <div class="tab-pane fade" id="quality-assessment">
                            <!-- Content for Quality Assessment tab -->
                           @livewire('reporting.quality-assessment')
                        </div>
                        <div class="tab-pane fade" id="data-extraction">
                            <!-- Content for Data Extraction tab -->
                            @livewire('reporting.data-extraction')
                        </div>
                        <div class="tab-pane fade" id="reliability">
                            <!-- Content for Reliability tab -->
                           @livewire('reporting.reliability')
                        </div>
                        @if (
                            $project->feature_review === 'Systematic review and Snowballing' ||
                            $project->feature_review === 'Snowballing'
                        )
                            <div class="tab-pane fade" id="snowballing">
                                <!-- Content for Snowballing tab -->
                                @livewire('reporting.snowballing')
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @include('layouts.footers.auth.footer')
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    @push('js')
        <script>
            // Function to store the active tab in a cookie
            function storeActiveTab(tabId) {
                document.cookie = "activeReportingTab=" + tabId + ";path=/";
            }
        </script>
    @endpush
@endsection