@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Reporting'])

<div class="row mt-4 mx-4">

    @include('project.components.project-header', ['project' => $project, 'activePage' => 'reporting'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                @include('project.components.project-tabs', [
                    'header' => 'Reporting',
                    'tabs' => [
                        ['id' => 'overview-tab', 'label' => 'Overview', 'href' => '#overview'],
                        ['id' => 'import-studies-tab', 'label' => 'Import Studies', 'href' => '#import-studies'],
                        ['id' => 'study-selection-tab', 'label' => 'Study Selection', 'href' => '#study-selection'],
                        ['id' => 'quality-assessment-tab', 'label' => 'Quality Assessment', 'href' => '#quality-assessment'],
                        ['id' => 'data-extraction-tab', 'label' => 'Data Extraction', 'href' => '#data-extraction'],
                    ],
                    'activeTab' => 'overview-tab'
                ])
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="overview">
                        <!-- Content for Overview tab -->
                        <div id="overviewFunnelChart" style="height: 400px;" class="card my-2 p-2"></div>
                        <div id="overviewChart" style="height: 400px;" class="card my-2 p-2"></div>
                    </div>
                    <div class="tab-pane fade" id="import-studies">
                        <!-- Content for Import Studies tab -->
                        <div id="papers_per_database" style="height: 400px;" class="card my-2 p-2"></div>
                    </div>
                    <div class="tab-pane fade" id="study-selection">
                        <!-- Content for Study Selection tab -->
                        <div id="papers_per_selection" style="height: 400px;" class="card my-2 p-2"></div>
                    </div>
                    <div class="tab-pane fade" id="quality-assessment">
                        <!-- Content for Quality Assessment tab -->
                        <div id="papers_per_quality" style="height: 400px;" class="card my-2 p-2"></div>
                        <div id="papers_gen_score" style="height: 400px;" class="card my-2 p-2"></div>
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
                text: 'Systematic mapping study on domain-specific language development tools Funnel'
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
            series: [{"name": "Studies", "data": [["Imported Studies", 1737], ["Not Duplicate", 1737], ["Status Selection", 10], ["Status Quality", 4], ["Status Extraction", 4]]}],
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
                categories: ["2023-03-28", "2023-03-30", "2023-04-04", "2023-04-24", "2023-06-03"]
            },
            yAxis: {
                title: {
                    text: 'Activities'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{"name": "Project", "data": [40, 103, 257, 7, 2]}, {"name": "Auri Gabriel", "data": [40, 103, 257, 7, 2]}]
        });

        // Import Studies Tab

        Highcharts.chart('papers_per_database', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Papers per Database'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})'
            },
            plotOptions: {
                column: {
                    colorByPoint: true
                },
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{"name": "IEEE Base", "y": 1737}]
            }]
        });

        // Study Selection Tab

        Highcharts.chart('papers_per_selection', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Papers per Status Selection'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{"name": "Accepted", "y": 10, "color": "#90ed7d"}, {"name": "Unclassified", "y": 1727, "color": "#434348"}]
            }]
        });

        // Quality Assessment Tab

        Highcharts.chart('papers_per_quality', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Papers per Status Quality'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{"name": "Accepted", "y": 4, "color": "#90ed7d"}, {"name": "Rejected", "y": 6, "color": "#f45b5b"}]
            }]
        });

        Highcharts.chart('papers_gen_score', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Papers per General Score'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{"name": "Poor", "y": 2}, {"name": "OK", "y": 4}, {"name": "Good", "y": 4}]
            }]
        });

        // Data Extraction Tab






    });
</script>
@endpush
@endsection
