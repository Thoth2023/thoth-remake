<div>

    <div class="grid-items-2 gap-4">
            <div id="papers_per_quality" style="height: 300px;" class="card my-2 p-2 ">
                <x-helpers.modal
                    target="reliability-agreement"
                    modalTitle="{{ translationReporting('reliability.agreement.title') }}"
                    modalContent="{!!  translationReporting('reliability.agreement.content') !!} "
                />
                <div id="papers_concordance" style="height: 290px;" class="card my-2 p-2"></div>
            </div>
            <div id="papers_gen_score" style="height: 300px;" class="card my-2 p-2 ">
                <x-helpers.modal
                    target="reliability-kappa"
                    modalTitle="{{ translationReporting('reliability.kappa.title') }}"
                    modalContent="{!!  translationReporting('reliability.kappa.content') !!} "
                />
                <div id="kappa_concordance" style="height: 290px;" class="card my-2 p-2"></div>
            </div>


    </div>

    <div class="card card-body col-md-12 mt-3">

        <div class="card-header mb-0 pb-0">
            <x-helpers.modal
                target="reliability-selection"
                modalTitle="{{ translationReporting('reliability.selection.title') }}"
                modalContent="{!!  translationReporting('reliability.selection.content') !!} "
            />
        </div>
        @livewire('reporting.peer-review-selection-table')
    </div>

    <div class="card card-body col-md-12 mt-3">

        <div class="card-header mb-0 pb-0">
            <x-helpers.modal
                target="reliability-quality"
                modalTitle="{{ translationReporting('reliability.quality.title') }}"
                modalContent="{!!  translationReporting('reliability.quality.content') !!} "
            />
        </div>
        @livewire('reporting.peer-review-quality-table')
    </div>

</div>

@section('scripts')
    @parent
    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Garantir que os dados foram passados da variável PHP para JavaScript corretamente
                const studySelectionAgreement = @json($studySelectionAgreement);
                const qualityAssessmentAgreement = @json($qualityAssessmentAgreement);
                const studySelectionKappa = @json($studySelectionAgreementkappa);
                const qualityAssessmentKappa = @json($qualityAssessmentAgreementkappa);

                // Função para renderizar o gráfico de Concordância
                function renderConcordanceChart() {
                    Highcharts.chart('papers_concordance', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: 'Análise Concordância nas Etapas',
                            align: 'left'
                        },
                        xAxis: {
                            categories: ['Study Selection', 'Quality Assessment'] // Cada barra com sua própria categoria
                        },
                        yAxis: {
                            min: 0,
                            max: 100,
                            title: {
                                text: 'Percentual de Concordância (%)'
                            }
                        },
                        plotOptions: {
                            series: {
                                pointWidth: 30, // Largura fixa das barras, altere o valor conforme necessário
                                dataLabels: {
                                    enabled: true,
                                    formatter: function () {
                                        return Highcharts.numberFormat(this.y, 2) + '%'; // Exibir 2 casas decimais
                                    }
                                }
                            }
                        },
                        series: [
                            {
                                name: 'Study Selection', // Nome da primeira série
                                data: [studySelectionAgreement, null], // Valor para Study Selection
                                color: '#7cb5ec'
                            },
                            {
                                name: 'Quality Assessment', // Nome da segunda série
                                data: [null, qualityAssessmentAgreement], // Valor para Quality Assessment
                                color: '#90ed7d'
                            }
                        ]
                    });
                }

                // Função para renderizar o gráfico de Kappa
                function renderKappaChart() {
                    Highcharts.chart('kappa_concordance', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: 'Análise Kappa nas Etapas',
                            align: 'left'
                        },
                        xAxis: {
                            categories: ['Study Selection', 'Quality Assessment']
                        },
                        yAxis: {
                            min: 0,
                            max: 1, // O valor de Kappa varia de -1 a 1, então o limite superior é 1
                            title: {
                                text: 'Valor de Kappa'
                            }
                        },
                        plotOptions: {
                            series: {
                                pointWidth: 30, // Largura das barras
                                dataLabels: {
                                    enabled: true,
                                    formatter: function () {
                                        return Highcharts.numberFormat(this.y, 2); // Exibir 2 casas decimais
                                    }
                                }
                            }
                        },
                        series: [
                            {
                                name: 'Study Selection',
                                data: [studySelectionKappa, null], // Valor calculado para Study Selection
                                color: '#7cb5ec'
                            },
                            {
                                name: 'Quality Assessment',
                                data: [null, qualityAssessmentKappa], // Valor calculado para Quality Assessment
                                color: '#90ed7d'
                            }
                        ]
                    });
                }

                // Renderizar os gráficos após o DOM estar completamente carregado
                renderConcordanceChart();
                renderKappaChart();
            });
        </script>
    @endpush
@endsection








