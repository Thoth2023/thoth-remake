<div>

    <div class="grid-items-2 gap-4">
            <div id="papers_per_quality" style="height: 300px;" class="card my-2 p-2 ">
                <x-helpers.modal
                    target="reliability-agreement"
                    modalTitle="{{ __('project/reporting.reliability.agreement.title') }}"
                    modalContent="{!!  __('project/reporting.reliability.agreement.content') !!} "
                />
                <div id="papers_concordance" style="height: 290px;" class="card my-2 p-2"></div>
            </div>
            <div id="papers_gen_score" style="height: 300px;" class="card my-2 p-2 ">
                <x-helpers.modal
                    target="reliability-kappa"
                    modalTitle="{{ __('project/reporting.reliability.kappa.title') }}"
                    modalContent="{!!  __('project/reporting.reliability.kappa.content') !!} "
                />
                <div id="kappa_concordance" style="height: 290px;" class="card my-2 p-2"></div>
            </div>


    </div>

    <div class="card card-body col-md-12 mt-3">

        <div class="card-header mb-0 pb-0">
            <x-helpers.modal
                target="reliability-selection"
                modalTitle="{{ __('project/reporting.reliability.selection.title') }}"
                modalContent="{!!  __('project/reporting.reliability.selection.content') !!} "
            />
        </div>
        @livewire('reporting.peer-review-selection-table')
    </div>

    <div class="card card-body col-md-12 mt-3">

        <div class="card-header mb-0 pb-0">
            <x-helpers.modal
                target="reliability-quality"
                modalTitle="{{ __('project/reporting.reliability.quality.title') }}"
                modalContent="{!!  __('project/reporting.reliability.quality.content') !!} "
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
                            text: '{{ __('project/reporting.reliability.agreement.title-modal') }}',
                            align: 'left'
                        },
                        xAxis: {
                            categories: ['{{ __('project/reporting.reliability.study-selection') }}', '{{ __('project/reporting.reliability.quality-assessment') }}'] // Cada barra com sua própria categoria
                        },
                        yAxis: {
                            min: 0,
                            max: 100,
                            title: {
                                text: '{{ __('project/reporting.reliability.agreement.agreement-percentual') }}'
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
                                name: '{{ __('project/reporting.reliability.study-selection') }}', // Nome da primeira série
                                data: [studySelectionAgreement, null], // Valor para Study Selection
                                color: '#7cb5ec'
                            },
                            {
                                name: '{{ __('project/reporting.reliability.quality-assessment') }}', // Nome da segunda série
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
                            text: '{{ __('project/reporting.reliability.kappa.title-modal') }}',
                            align: 'left'
                        },
                        xAxis: {
                            categories: ['{{ __('project/reporting.reliability.study-selection') }}', '{{ __('project/reporting.reliability.quality-assessment') }}']
                        },
                        yAxis: {
                            min: 0,
                            max: 1, // O valor de Kappa varia de -1 a 1, então o limite superior é 1
                            title: {
                                text: '{{ __('project/reporting.reliability.kappa.kappa-value') }}'
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
                                name: '{{ __('project/reporting.reliability.study-selection') }}',
                                data: [studySelectionKappa, null], // Valor calculado para Study Selection
                                color: '#7cb5ec'
                            },
                            {
                                name: '{{ __('project/reporting.reliability.quality-assessment') }}',
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








