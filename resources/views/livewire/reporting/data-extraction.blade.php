<div class="col-12">
    <figure class="highcharts-figure">
        <div id="dataextraction" style="height: 400px;" class="card my-2 p-2"></div>
    </figure>
    <div class="grid-items-2 gap-4">
        <figure class="highcharts-figure">
            <div id="packedbubblechart" style="height: 400px;" class="card my-2 p-2 "></div>
        </figure>
        <figure class="highcharts-figure">
            <div id="radarchart" style="height: 400px;" class="card my-2 p-2 "></div>
        </figure>
    </div>
    <!--<figure class="highcharts-figure">
        <div id="barchart" style="height: 600px;" class="card my-2 p-2 "></div>
    </figure>-->
    <div class="col-12">
        <div class="card card-body col-md-12 mt-3">
            @livewire('reporting.data-extraction-table')
        </div>
    </div>
</div>
@php
    $radarChartDataArray = json_decode($radarChartData, true);
    $responsesTimes = $radarChartDataArray['data'];
    $wasResponse = false;
    foreach ($responsesTimes as $responseTimes) {
        if($responseTimes > 0) {
            $wasResponse = true;
            break;
        }
    }
@endphp

@section('scripts')
    @parent
    @push('js')
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/wordcloud.js"></script>
        <script src="https://code.highcharts.com/modules/packed-bubble.js"></script>
        <script src="https://code.highcharts.com/highcharts-more.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const wordCloudData = {!! $wordCloudData !!}; // Dados gerados pelo controller
                Highcharts.chart('dataextraction', {
                    accessibility: {
                        screenReaderSection: {
                            beforeChartFormat: '<h5>{chartTitle}</h5>' +
                                '<div>{chartSubtitle}</div>' +
                                '<div>{chartLongdesc}</div>' +
                                '<div>{viewTableButton}</div>'
                        }
                    },
                    series: [{
                        type: 'wordcloud',
                        data: wordCloudData,
                        name: 'Occurrences'
                    }],
                    title: {
                        text: '{{ __('project/reporting.data-extraction.data-extraction-wordcloud') }}',
                        align: 'center'
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size: 16px"><b>{point.key}</b></span><br>'
                    }
                });

                const packedBubbleData = {!! $packedBubbleData !!}; // Dados gerados pelo controller

                Highcharts.chart('packedbubblechart', {
                    chart: {
                        type: 'packedbubble',
                        height: '65%'
                    },
                    title: {
                        text: '{{ __('project/reporting.data-extraction.data-extraction-answer-packed-bubble') }}',
                        align: 'left'
                    },
                    tooltip: {
                        useHTML: true,
                        pointFormat: '<b>{point.name}:</b> {point.value} ocorrências'
                    },
                    plotOptions: {
                        packedbubble: {
                            minSize: '30%',
                            maxSize: '120%',
                            zMin: 0,
                            zMax: 1000,
                            layoutAlgorithm: {
                                splitSeries: true,
                                gravitationalConstant: 0.02,
                                parentNodeLimit: true
                            },
                            dataLabels: {
                                enabled: true,
                                format: '{point.name}', // Mostra o número de ocorrências ao lado do nome
                                style: {
                                    color: 'black',
                                    textOutline: 'none',
                                    fontWeight: 'normal'
                                }
                            }
                        }
                    },
                    series: packedBubbleData
                });

                const radarChartData = {!! json_encode($this->getRadarChartData()) !!};

                Highcharts.chart('radarchart', {
                    chart: {
                        polar: true,
                        type: 'line'
                    },
                    title: {
                        text: '{{ __('project/reporting.data-extraction.comparasion-answers-question.title') }}',
                        align: 'left'
                    },
                    xAxis: {
                        categories: radarChartData.categories,
                        tickmarkPlacement: 'on',
                        lineWidth: 0
                    },
                    yAxis: {
                        gridLineInterpolation: 'polygon',
                        lineWidth: 0,
                        min: 0
                    },
                    series: [{
                        name: '{{ __('project/reporting.data-extraction.comparasion-answers-question.content') }}',
                        data: radarChartData.data,
                        pointPlacement: 'on'
                    }]
                });

            });
        </script>

        @if(count(json_decode($wordCloudData, true)) == 0)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('dataextraction').innerHTML = '<p style="text-align:center; margin-top:2em;">{{ __("project/reporting.check.no_extracted_data_by_anyone") }}</p>';
            });
        </script>
        @endif

        @if(count(json_decode($packedBubbleData, true)) == 0)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('packedbubblechart').innerHTML = '<p style="text-align:center; margin-top:2em;">{{ __("project/reporting.check.no_extracted_data_by_anyone") }}</p>';
                });
            </script>
        @endif

        @if(!$wasResponse)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('radarchart').innerHTML = '<p style="text-align:center; margin-top:2em;">{{ __("project/reporting.check.no_extracted_data_by_anyone") }}</p>';
                });
            </script>
        @endif
    @endpush
@endsection
