<div class="col-12">
    <div class="grid-items-2 gap-4">
        <figure class="highcharts-figure">
        <div id="papers_per_database" style="height: 400px;" class="card my-2 p-2"></div>
        </figure>
        <figure class="highcharts-figure">
        <div id="container-papers-by-year-and-database" style="height: 400px;" class="card my-2 p-2"></div>
        </figure>
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

        @if(!empty($papersPerDatabase))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
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
                        data: @json($papersPerDatabase) // Dados do Livewire convertidos para JSON
                    }]
                });

                const papersByYearAndDatabase = @json($papersByYearAndDatabase);

                // Extrair os anos (categorias do eixo X)
                const years = Object.keys(papersByYearAndDatabase);

                // Extrair as bases de dados e organizar as séries
                const databases = [...new Set(Object.values(papersByYearAndDatabase).flatMap(year => Object.keys(year)))];

                const series = databases.map(database => {
                    return {
                        name: database,
                        data: years.map(year => papersByYearAndDatabase[year][database] || 0),
                        stack: 'databases' // Configuração para empilhamento
                    };
                });
                // Criar o gráfico Highcharts
                Highcharts.chart('container-papers-by-year-and-database', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Number of Papers by Year',
                        align: 'left'
                    },
                    xAxis: {
                        categories: years, // Usamos os anos como categorias no eixo X
                        title: {
                            text: 'Year'
                        }
                    },
                    yAxis: {
                        allowDecimals: false,
                        min: 0,
                        title: {
                            text: 'Number of Papers'
                        }
                    },
                    plotOptions: {
                        column: {
                            stacking: 'normal', // Empilhamento normal
                            dataLabels: {
                                enabled: true, // Habilitar exibição dos rótulos de dados
                                formatter: function() {
                                    return this.y > 0 ? this.y : ''; // Exibir apenas valores maiores que 0
                                }
                            }
                        }
                    },
                    series: series // Séries geradas dinamicamente com base nos dados do Livewire
                });

            });

        </script>
        @else
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('papers_per_database').innerHTML = '<p style="text-align:center; margin-top:2em;">{{ __("project/reporting.check.no_imported_studies") }}</p>';
                document.getElementById('container-papers-by-year-and-database').innerHTML = '<p style="text-align:center; margin-top:2em;">{{ __("project/reporting.check.no_imported_studies") }}</p>';;
            });
        </script>
        @endif
    @endpush
@endsection
