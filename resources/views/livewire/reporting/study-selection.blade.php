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
                        name: 'Papers',
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
                        text: 'Critérios assinalados por Usuário'
                    },
                    xAxis: {
                        categories: criterias,
                        title: {
                            text: 'Critérios Assinalados na Seleção de Estudos'
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Quantidade de vezes'
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

                            return `<b>Critério:</b> ${criteriaId} - ${criteriaName}<br/>` +
                                `<b>Usuário:</b> ${this.series.name}<br/>` +
                                `<b>Valor:</b> ${this.y}`;
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
                            text: 'Número de Papers por Usuário e Status Selection'
                        },
                        xAxis: {
                            categories: users,
                            title: {
                                text: 'Usuários'
                            }
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Número de Papers'
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
