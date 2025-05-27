<div class="col-12">
<div class="grid-items-2 gap-4">
    <figure class="highcharts-figure">
        <div id="papers_per_quality" style="height: 400px;" class="card my-2 p-2 "></div>
    </figure>
    <figure class="highcharts-figure">
        <div id="papers_gen_score" style="height: 400px;" class="card my-2 p-2 "></div>
    </figure>
</div>
    <figure class="highcharts-figure">
       <div id="status_per_members_quality" style="height: 400px;" class="card my-2 p-2"></div>
    </figure>
    <div class="col-12">
        <div class="card card-body col-md-12 mt-3">
        @livewire('reporting.quality-table')
        </div>
    </div>
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
                // Quality Assessment Tab
                const papersPerStatus = @json($papersPerStatus); // Dados enviados do Livewire

                // Criar o gráfico de pizza
                Highcharts.chart('papers_per_quality', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: '{{ __('project/reporting.quality-assessment.papers-status-quality.title') }}'
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
                        name: '{{ __('project/reporting.quality-assessment.papers-status-quality.content') }}',
                        colorByPoint: true,
                        data: papersPerStatus // Dados dinâmicos
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
                        text: '{{ __('project/reporting.quality-assessment.papers-general-score.title') }}'
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
                        name: '{{ __('project/reporting.quality-assessment.papers-general-score.content') }}',
                        colorByPoint: true,
                        data: @json($papersByGeneralScore) // Dados gerados pela consulta
                    }]
                });


            });

            document.addEventListener('DOMContentLoaded', function() {
                // Dados para o gráfico
                const papersByUserAndStatusQuality = @json($papersByUserAndStatusQuality);

                // Extrair os usuários (categorias do eixo X)
                const users = Object.keys(papersByUserAndStatusQuality);

                // Criar as séries por status
                const statuses = [...new Set(Object.values(papersByUserAndStatusQuality).flatMap(user => Object.keys(user.statuses)))];

                // Criar as séries de dados para cada status
                const series = statuses.map(status => {
                    return {
                        name: status,
                        data: users.map(user => {
                            // Retorna a contagem de papers por status para cada usuário, ou 0 se não houver
                            return papersByUserAndStatusQuality[user].statuses[status] || 0;
                        })
                    };
                });

                // Configurar o gráfico
                Highcharts.chart('status_per_members_quality', {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: '{{ __('project/reporting.quality-assessment.number-papers-user-status-quality.title') }}'
                    },
                    xAxis: {
                        categories: users,
                        title: {
                            text: '{{ __('project/reporting.quality-assessment.number-papers-user-status-quality.users') }}'
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: '{{ __('project/reporting.quality-assessment.number-papers-user-status-quality.number-papers') }}'
                        }
                    },
                    legend: {
                        reversed: true
                    },
                    plotOptions: {
                        series: {
                            stacking: 'normal',
                            dataLabels: {
                                enabled: true
                            }
                        }
                    },
                    series: series // Dados formatados dos status e suas contagens
                });
            });
        </script>
    @endpush
@endsection
