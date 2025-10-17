<div class="col-12">

    {{-- Resumo do relatório --}}
    @if($totalPapers > 0)
        <div class="card">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-3 text-sm text-blue-900 d-flex align-items-center gap-2">
                <i class="fas fa-file-alt text-primary me-2"></i>
                <div>
                    {{ trans_choice('project/reporting.snowballing.seed_papers', (int) $totalSeeds, ['count' => (int) $totalSeeds]) }} —
                    <strong>{{ $totalPapers }}</strong> {{ __('project/reporting.snowballing.relevant_papers') }} —
                    {{ trans_choice('project/reporting.snowballing.levels', (int) $maxDepth, ['count' => (int) $maxDepth]) }}
                </div>

            </div>
        </div>
    @else
        <div class="text-center text-gray-500 text-sm mb-4">
            {{ __('project/reporting.snowballing.no_data') }}
        </div>
    @endif

    {{-- Gráfico Treegraph --}}
    <figure class="highcharts-figure">
        <div id="snowballingChart" style="height: 800px;" class="card my-2 p-2 shadow-sm rounded-lg border bg-white"></div>
    </figure>

    {{-- Legenda --}}
    <div class="card-footer d-flex justify-content-center align-items-center gap-4 text-sm text-gray-700 mt-3">
        <span><b>{{ __('project/reporting.snowballing.legend') }}:</b></span>
        <span><i class="fas fa-circle me-1" style="color:#16a34a;"></i> {{ __('project/reporting.snowballing.seed') }}</span>
        <span><i class="fas fa-circle me-1" style="color:#f39c12;"></i> {{ __('project/reporting.snowballing.forward') }}</span>
        <span><i class="fas fa-circle me-1" style="color:#0a3d62;"></i> {{ __('project/reporting.snowballing.backward') }}</span>
    </div>

    {{-- Scripts --}}
    @section('scripts')
        @parent
        @push('js')
            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/modules/treemap.js"></script>
            <script src="https://code.highcharts.com/modules/treegraph.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>
            <script src="https://code.highcharts.com/modules/accessibility.js"></script>
            <script src="https://code.highcharts.com/themes/adaptive.js"></script>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    let chartData = @json($chartData);

                    try {
                        if (typeof chartData === 'string') {
                            chartData = JSON.parse(chartData);
                        }
                    } catch (e) {
                        console.error("Erro ao converter chartData:", e);
                        return;
                    }

                    if (!chartData || chartData.length === 0) {
                        document.getElementById('snowballingChart').innerHTML =
                            '<p class="text-center text-gray-500 mt-8">{{ __("project/reporting.snowballing.no_chart_data") }}</p>';
                        return;
                    }

                    // Converte árvore hierárquica para formato plano
                    function flattenTree(node, parent = '') {
                        const idMatch = node.name?.match(/ID:\s*(\d+)/);
                        const shortName = idMatch ? `ID: ${idMatch[1]}` : node.id;

                        let arr = [{
                            id: node.id,
                            parent: parent,
                            name: shortName,
                            fullName: node.name || '{{ __("project/reporting.snowballing.no_title") }}',
                            value: node.value || 1,
                            color: node.color || '#999'
                        }];

                        if (node.children && node.children.length > 0) {
                            node.children.forEach(child => {
                                arr = arr.concat(flattenTree(child, node.id));
                            });
                        }
                        return arr;
                    }

                    let flatData = [];
                    chartData.forEach(node => {
                        flatData = flatData.concat(flattenTree(node));
                    });


                    // Renderiza o gráfico
                    Highcharts.chart('snowballingChart', {
                        chart: {
                            inverted: true,
                            type: 'treegraph',
                            backgroundColor: '#fff',
                            height: '800px',
                            marginBottom: 160,
                            style: { fontFamily: 'Inter, sans-serif' }
                        },
                        title: {
                            text: '{{ __("project/reporting.snowballing.chart_title") }}',
                            align: 'left',
                            style: { fontSize: '18px', color: '#111827', fontWeight: '600' }
                        },
                        credits: { enabled: false },
                        exporting: { enabled: true },

                        tooltip: {
                            useHTML: true,
                            formatter: function () {
                                const fullText = this.point.fullName || this.point.name;
                                const isSeed = this.point.color === '#16a34a';
                                const type = isSeed
                                    ? '{{ __("project/reporting.snowballing.seed") }}'
                                    : (fullText.includes('(forward)')
                                        ? '{{ __("project/reporting.snowballing.forward") }}'
                                        : (fullText.includes('(backward)')
                                            ? '{{ __("project/reporting.snowballing.backward") }}'
                                            : '{{ __("project/reporting.snowballing.unknown") }}'));

                                return `
                                    <div style="min-width: 240px;">
                                        <strong>${fullText}</strong><br/>
                                        <span style="color:${this.point.color}">●</span>
                                        {{ __("project/reporting.snowballing.tooltip_type") }}:
                                        <b>${type}</b><br/>
                                        {{ __("project/reporting.snowballing.tooltip_relevance") }}:
                                        ${this.point.value?.toFixed(3) ?? '-'}
                                    </div>
                                `;
                            }
                        },

                        plotOptions: {
                            series: {
                                animation: true,
                                marker: { radius: 6 },
                                dataLabels: {
                                    enabled: true,
                                    pointFormat: '{point.name}',
                                    style: {
                                        whiteSpace: 'nowrap',
                                        color: '#000',
                                        textOutline: 'none',
                                        fontSize: '11px',
                                        fontWeight: '500'
                                    },
                                    crop: false
                                }
                            }
                        },

                        series: [{
                            type: 'treegraph',
                            data: flatData,
                            allowTraversingTree: true,
                            connectors: {
                                color: '#b0b0b0',
                                width: 1.3,
                                dashStyle: 'solid'
                            },
                            levels: [
                                { level: 1, dataLabels: { align: 'left', x: 25 }, color: '#16a34a' },
                                { level: 2, colorByPoint: true, dataLabels: { verticalAlign: 'bottom', y: -20 } },
                                { level: 3, colorVariation: { key: 'brightness', to: -0.3 }, dataLabels: { rotation: 0, y: 15 } }
                            ]
                        }]
                    });
                });
            </script>
        @endpush
    @endsection
</div>
