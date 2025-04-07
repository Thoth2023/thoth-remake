<div class="col-12">

<!--<div id="overviewRslTimeline" style="height: 300px;" class="card my-2 p-2"></div>-->
<div class="grid-items-2 gap-4">
    <figure class="highcharts-figure">
        <div id="overviewFunnelChart" style="height: 600px;" class="card my-2 p-2"></div>
    </figure>
    <figure class="highcharts-figure">
        <div id="overviewRslPhases" style="height: 600px;" class="card my-2 p-2"></div>
    </figure>
</div>
    <div id="overviewChart" style="height: 400px;" class="card my-2 p-2"></div>
</div>

@section('scripts')
    @parent
    @push('js')
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/funnel.js"></script>
        <script src="https://code.highcharts.com/modules/sankey.js"></script>
        <script src="https://code.highcharts.com/modules/organization.js"></script>
        <script src="https://code.highcharts.com/modules/timeline.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <script>
            // Sample Highcharts chart
            document.addEventListener('DOMContentLoaded', function() {

                // Overview Tab
              Highcharts.chart('overviewFunnelChart', {
                    chart: {
                        type: 'funnel'
                    },
                    title: {
                        text: '{{ __('project/reporting.overview.systematic-mapping-study') }}'
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
                        "name": "Studies",
                        "data": [
                            ["Imported Studies", {{$importedStudiesCount}}],
                            ["Not Duplicate", {{ $notDuplicateStudiesCount }}],
                            ["Status Selection", {{$studiesSelectionCount}}],
                            ["Status Quality",  {{$studiesQualityCount}}],
                            ["Status Extraction",  {{$studiesExtractionCount}}]
                        ]
                    }],
                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 550
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



                // Definindo os dados no formato JSON enviados pelo Livewire/Blade
                const dates = @json($activitiesData['dates']); // Datas das atividades
                const projectTotalActivities = @json($activitiesData['projectTotalActivities']); // Atividades totais do projeto
                const activitiesByUser = @json($activitiesData['activitiesByUser']); // Atividades por usuário

                // Criando a série para o gráfico de linha
                const seriesData = [
                    {
                        name: 'Project',
                        data: projectTotalActivities // Dados das atividades totais do projeto por data
                    }
                ];

                // Adicionando as atividades de cada usuário na série de dados
                Object.keys(activitiesByUser).forEach(userName => {
                    seriesData.push({
                        name: userName,
                        data: activitiesByUser[userName] // Atividades de cada usuário por data
                    });
                });

                // Configurando o gráfico Highcharts
                Highcharts.chart('overviewChart', {
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: '{{ __('project/reporting.overview.project-activities-overtime') }}'
                    },
                    xAxis: {
                        categories: dates // Datas no eixo X
                    },
                    yAxis: {
                        title: {
                            text: 'Total Activities'
                        }
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: true
                        }
                    },
                    series: seriesData // Série de dados com atividades do projeto e dos usuários
                });

                Highcharts.chart('overviewRslPhases', {
                    chart: {
                        type: 'organization',
                        inverted: true,
                        height: 575
                    },
                    title: {
                        text: '{{ __('project/reporting.overview.stages-systematic-review') }}',
                        style: {
                            fontSize: '18px' // Tamanho da fonte do título
                        }
                    },
                    accessibility: {
                        point: {
                            descriptionFormat: '{add index 2}. {toNode.name}' +
                                '{#if (ne toNode.name toNode.id)}, {toNode.id}{/if}, ' +
                                'reports to {fromNode.id}'
                        }
                    },
                    series: [{
                        type: 'organization',
                        name: 'Phase',
                        keys: ['from', 'to'],
                        data: [
                            ['Search in Digital Libraries', 'imported studies'],
                            ['imported studies', 'Duplicates Removal'],
                            ['Duplicates Removal', 'studies included'],
                            ['studies included', 'Inclusion/Exclusion Criteria'],
                            ['Inclusion/Exclusion Criteria', 'I/E studies'],
                            ['I/E studies', 'QA Assessment'],
                            ['QA Assessment', 'DE studies'],
                        ],
                        nodes: [{
                            id: 'Search in Digital Libraries',
                            title: 'Search in Digital Libraries',
                            name: 'Databases',
                            color: '#D0D0D0'
                        }, {
                            id: 'Duplicates Removal',
                            title: '{{ $duplicateStudiesCount }} Duplicates Removal',
                            name: 'Duplicates',
                            color: '#F7C5C5'
                        }, {
                            id: 'Inclusion/Exclusion Criteria',
                            title: '{{$studiesSelectionRejectedCount}} I/E removed',
                            name: 'Study Selection',
                            color: '#F8E8A2'
                        }, {
                            id: 'QA Assessment',
                            title: '{{$studiesQualityRejectedCount}} QA rejected',
                            name: 'Quality Assessment',
                            color: '#D5FAD9'
                        }, {
                            id: 'Data Extraction',
                            title: 'Data Extraction',
                            name: 'Data Extraction',
                            color: '#D5FAD9'
                        }, {
                            id: 'imported studies',
                            name: '{{$importedStudiesCount}} imported studies',
                            color: '#ffffff'
                        }, {
                            id: 'studies included',
                            name: '{{$notDuplicateStudiesCount }} studies',
                            color: '#ffffff'
                        }, {
                            id: 'I/E studies',
                            name: '{{$studiesSelectionCount}} studies I/E included',
                            color: '#ffffff'
                        }, {
                            id: 'DE studies',
                            name: '{{$studiesQualityCount}} studies accepted',
                            title: '#Avaiable Data Extraction',
                            color: '#ffffff'
                        }],
                        dataLabels: {
                            style: {
                                fontSize: '10px' // Tamanho da fonte dos rótulos
                            }
                        },
                        nodeHeight: 'auto'
                    }],
                    tooltip: {
                        outside: true
                    },
                    exporting: {
                        allowHTML: true,
                        sourceWidth: 600,
                        sourceHeight: 800
                    }
                });

                Highcharts.chart('overviewRslTimeline', {
                    chart: {
                        type: 'timeline',
                        height: 250
                    },
                    title: {
                        text: 'Systematic Literature Review Timeline',
                        style: {
                            fontSize: '14px' // Tamanho da fonte do título
                        }
                    },
                    accessibility: {
                        point: {
                            valueDescriptionFormat: '{index}. {point.name}. {point.description}.'
                        }
                    },
                    xAxis: {
                        visible: false
                    },
                    yAxis: {
                        visible: false
                    },
                    series: [{
                        data: [
                            {
                                name: 'Search in Digital Libraries',
                                description: '6740 estudos encontrados.'
                            },
                            {
                                name: 'Duplicates Removal',
                                description: '28 estudos duplicados. 6712 estudos restantes.'
                            },
                            {
                                name: 'Inclusion/Exclusion Criteria',
                                description: '6677 estudos removidos. 35 estudos restantes.'
                            },
                            {
                                name: 'QA Assessment',
                                description: '11 estudos rejeitados. 24 estudos restantes.'
                            },
                            {
                                name: 'Data Extraction',
                                description: 'Extração de dados dos 24 estudos finais.'
                            }
                        ]
                    }],
                    colors: [
                        '#D0D0D0',
                        '#F7C5C5',
                        '#F8E8A2',
                        '#D5FAD9',
                        '#D5FAb8'
                    ],
                    tooltip: {
                        outside: true
                    },
                    exporting: {
                        allowHTML: true,
                        sourceWidth: 800,
                        sourceHeight: 600
                    }
                });
            });
        </script>
    @endpush
@endsection
