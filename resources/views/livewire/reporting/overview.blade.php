<div>
<!--<div id="overviewFunnelChart" style="height: 400px;" class="card my-2 p-2"></div>-->
<div id="overviewChart" style="height: 400px;" class="card my-2 p-2"></div>
</div>
@section('scripts')
    @parent
    @push('js')
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/funnel.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <script>
            // Sample Highcharts chart
            document.addEventListener('DOMContentLoaded', function() {

                // Overview Tab
               /* Highcharts.chart('overviewFunnelChart', {
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
                    series: [{
                        "name": "Studies",
                        "data": [
                            ["Imported Studies", 1737],
                            ["Not Duplicate", 1737],
                            ["Status Selection", 10],
                            ["Status Quality", 4],
                            ["Status Extraction", 4]
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
                });*/
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
                        text: 'Project Activities Over Time'
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

            });
        </script>
    @endpush
@endsection
