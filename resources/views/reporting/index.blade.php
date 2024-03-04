@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Reporting'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>
                    {{ $project->title }}
                </h4>
            </div>
            <div class="card-body">
                <div class="nav-wrapper position-relative end-0">
                    <ul class="nav nav-pills nav-fill p-1" id="myTabs">
                        <li class="nav-item">
                            <a class="btn bg-gradient-faded-white mb-0"
                                href="{{ route('projects.show', $project->id_project) }}">
                                <i class="fas fa-plus"></i>Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn bg-gradient-faded-white mb-0"
                                href="{{ route('planning.index', $project->id_project) }}">
                                <i class="fas fa-plus"></i>Planning</a>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="btn bg-gradient-default">Conducting</button>
                        </li>
                        <li class="nav-item">
                            <a class="btn bg-gradient-dark mb-0"
                                href="{{ route('reporting.index', $project->id_project) }}">
                                <i class="fas fa-plus"></i>Reporting</a>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="btn bg-gradient-default">Export</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Planning</h6>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" id="overview-tab" data-bs-toggle="tab"
                                href="#overview">Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="import-studies-tab" data-bs-toggle="tab"
                                href="#import-studies">Import Studies</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="study-selection-tab" data-bs-toggle="tab"
                                href="#study-selection">Study Selection</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="quality-assessment-tab" data-bs-toggle="tab"
                                href="#quality-assessment">Quality Assessment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="data-extraction-tab" data-bs-toggle="tab"
                                href="#data-extraction">Data Extraction</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="overview">
                        <!-- Highcharts Chart -->
                        <div id="overviewFunnelChart" style="height: 400px;" class="card my-2 p-2"></div>
                        <div id="overviewChart" style="height: 400px;" class="card my-2 p-2"></div>
                    </div>
                    <div class="tab-pane fade" id="import-studies">
                        <!-- Content for Import Studies tab -->
                    </div>
                    <div class="tab-pane fade" id="study-selection">
                        <!-- Content for Study Selection tab -->
                    </div>
                    <div class="tab-pane fade" id="quality-assessment">
                        <!-- Content for Quality Assessment tab -->
                    </div>
                    <div class="tab-pane fade" id="data-extraction">
                        <!-- Content for Data Extraction tab -->
                    </div>
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
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/funnel.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    // Function to store the active tab in a cookie
    function storeActiveTab(tabId) {
        document.cookie = "activeReportingTab=" + tabId + ";path=/";
    }

    // Sample Highcharts chart
    document.addEventListener('DOMContentLoaded', function () {

        // Overview Tab

        Highcharts.chart('overviewFunnelChart', {
            chart: {
                type: 'funnel'
            },
            title: {
                text: '{{ $project->title }} Funnel'
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b> ({point.y:,.0f})',
                        softConnector: true
                    },
                    center: ['40%', '50%'],
                    neckWidth: '30%',
                    neckHeight: '25%',
                    width: '80%'
                }
            },
            legend: {
                enabled: false
            },
            series: [{
                name: 'Unique users',
                data: [
                    ['Website visits', 15654],
                    ['Downloads', 4064],
                    ['Requested price list', 1987],
                    ['Invoice sent', 976],
                    ['Finalized', 846]
                ]
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        plotOptions: {
                            series: {
                                dataLabels: {
                                    inside: true
                                },
                                center: ['50%', '50%'],
                                width: '100%'
                            }
                        }
                    }
                }]
            }
        });

        Highcharts.chart('overviewChart', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Failure of Daily Project Activities'
            },
            xAxis: {
                categories: ['Category 1', 'Category 2', 'Category 3']
            },
            yAxis: {
                title: {
                    text: 'Values'
                }
            },
            series: [{
                name: 'Series 1',
                data: [10, 20, 30]
            }]
        });

        // Import Studies Tab

        // Study Selection Tab

        // Quality Assessment Tab

        // Data Extraction Tab

    });
</script>
@endpush
@endsection
