<div class="col-12">
    <div class="grid-items-2 gap-4">

        <figure class="highcharts-figure">
            <div id="papers_per_selection" style="height: 400px;" class="card my-2 p-2"></div>
        </figure>
        <figure class="highcharts-figure">
            <div id="total_per_criterias" style="height: 400px;" class="card my-2 p-2"></div>
        </figure>
    </div>
    <figure class="highcharts-figure">
        <div id="status_per_members" style="height: 400px;" class="card my-2 p-2"></div>
    </figure>
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

            document.addEventListener('DOMContentLoaded', function() {

                // Study Selection Tab
                const papersPerStatus = @json($papersPerStatus); // Dados enviados do Livewire

                // Criar o gráfico de pizza
                Highcharts.chart('papers_per_selection', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: '{{ __('project/reporting.study-selection.papers-per-selection.title') }}'
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
                        name: '{{ __('project/reporting.study-selection.papers-per-selection.content') }}',
                        colorByPoint: true,
                        data: papersPerStatus // Dados dinâmicos
                    }]
                });

                const criteriaData = @json($criteriaData);
                // Extrair os critérios (categorias do eixo X)
                const criterias = Object.keys(criteriaData); // Critérios por id

                // Criar as séries por usuário
                const users = [...new Set(Object.values(criteriaData).flatMap(criteria => Object.keys(criteria.users)))];

                const series = users.map(user => {
                    return {
                        name: user,
                        data: criterias.map(criteria => {
                            // Retorna a contagem de usuários por critério, ou 0 se não houver
                            return criteriaData[criteria].users[user] || 0;
                        })
                    };
                });

                // Configurar o gráfico Criterias
                Highcharts.chart('total_per_criterias', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: '{{ __('project/reporting.study-selection.criteria-marked-user.title') }}'
                    },
                    xAxis: {
                        categories: criterias,
                        title: {
                            text: '{{ __('project/reporting.study-selection.criteria-marked-user.criteria-identified-study-selection') }}'
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: '{{ __('project/reporting.study-selection.criteria-marked-user.number-times') }}'
                        }
                    },
                    plotOptions: {
                        column: {
                            stacking: null, // Desativar empilhamento para mostrar barras lado a lado
                            dataLabels: {
                                enabled: true, // Habilitar rótulos
                                formatter: function () {
                                    return this.y > 0 ? this.y : ''; // Exibir somente valores positivos
                                }
                            }
                        }
                    },
                    tooltip: {
                        formatter: function() {
                            const criteriaId = criterias[this.point.index]; // Critério atual
                            const criteriaName = criteriaData[criteriaId].criteria_name; // Pegue o nome do critério

                            return `<b>{{ __('project/reporting.study-selection.criteria-marked-user.criteria') }}:</b> ${criteriaId} - ${criteriaName}<br/>` +
                                `<b>{{ __('project/reporting.study-selection.criteria-marked-user.user') }}:</b> ${this.series.name}<br/>` +
                                `<b>{{ __('project/reporting.study-selection.criteria-marked-user.value') }}:</b> ${this.y}`;
                        }
                    },
                    series: series // Dados formatados dos usuários e suas contagens
                });
            });

                document.addEventListener('DOMContentLoaded', function() {
                    // Dados para o gráfico
                    const papersByUserAndStatus = @json($papersByUserAndStatus);

                    // Extrair os usuários (categorias do eixo X)
                    const users = Object.keys(papersByUserAndStatus);

                    // Criar as séries por status
                    const statuses = [...new Set(Object.values(papersByUserAndStatus).flatMap(user => Object.keys(user.statuses)))];

                    // Criar as séries de dados para cada status
                    const series = statuses.map(status => {
                        return {
                            name: status,
                            data: users.map(user => {
                                // Retorna a contagem de papers por status para cada usuário, ou 0 se não houver
                                return papersByUserAndStatus[user].statuses[status] || 0;
                            })
                        };
                    });

                    // Configurar o gráfico
                    Highcharts.chart('status_per_members', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: '{{ __('project/reporting.study-selection.number-papers-user-status-selection.title') }}'
                        },
                        xAxis: {
                            categories: users,
                            title: {
                                text: '{{ __('project/reporting.study-selection.number-papers-user-status-selection.users') }}'
                            }
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: '{{ __('project/reporting.study-selection.number-papers-user-status-selection.number-papers') }}'
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

        @if(count($papersPerStatus) == 0)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('papers_per_selection').innerHTML = '<p style="text-align:center; margin-top:2em;">{{ __("project/reporting.check.no_selected_studies") }}</p>';
                });
            </script>
        @endif

        @if(count($criteriaData) == 0)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('total_per_criterias').innerHTML = '<p style="text-align:center; margin-top:2em;">{{ __("project/reporting.check.no_criteria_signed_by_anyone") }}</p>';
                });
            </script>
        @endif

        @if(count($papersByUserAndStatus) == 0)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('status_per_members').innerHTML = '<p style="text-align:center; margin-top:2em;">{{ __("project/reporting.check.no_selected_studies") }}</p>';
                });
            </script>
        @endif

    @endpush
@endsection
