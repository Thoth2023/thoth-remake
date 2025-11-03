<div class="col-12" wire:ignore>

    <!--<div id="overviewRslTimeline" style="height: 300px;" class="card my-2 p-2"></div>-->
    <div class="col-12" >
        <div class="grid-items-2 gap-4">
            <figure class="highcharts-figure">
                <div id="publicOverviewFunnelChart" style="height: 300px;" class="card my-2 p-2"></div>
            </figure>

            <figure class="highcharts-figure">
                <div id="publicOverviewRslPhases" style="height: 300px;" class="card my-2 p-2"></div>
            </figure>
        </div>

        <div id="publicOverviewChart" style="height: 300px;" class="card my-2 p-2"></div>

    </div>


</div>

@section('scripts')
    @parent
    @push('scripts')
        {{-- Highcharts via jsDelivr (compatível com seu CSP) --}}
        <script src="https://cdn.jsdelivr.net/npm/highcharts@11/highcharts.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/highcharts@11/modules/funnel.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/highcharts@11/modules/sankey.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/highcharts@11/modules/organization.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/highcharts@11/modules/timeline.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/highcharts@11/modules/exporting.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/highcharts@11/modules/export-data.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/highcharts@11/modules/accessibility.min.js" defer></script>

        <script>
            // --- helpers ---
            function hcReady(cb) {
                if (window.Highcharts) return cb();
                // aguarda os scripts "defer"
                const id = setInterval(() => {
                    if (window.Highcharts) {
                        clearInterval(id);
                        cb();
                    }
                }, 50);
            }

            function renderPublicOverviewCharts() {
                // Evita recriar se já foi renderizado
                if (document.getElementById('publicOverviewFunnelChart')?.dataset.hc) return;

                // Marcar containers como renderizados
                ['publicOverviewFunnelChart','publicOverviewChart','publicOverviewRslPhases'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.dataset.hc = '1';
                });

                // ==== FUNNEL ====
                Highcharts.chart('publicOverviewFunnelChart', {
                    chart: { type: 'funnel' },
                    title: { text: @json(__('project/reporting.overview.systematic-mapping-study.title')) },
                    plotOptions: {
                        series: {
                            dataLabels: { enabled: true, format: '<b>{point.name}</b> ({point.y:,.0f})', softConnector: true },
                            center: ['40%', '50%'], neckWidth: '30%', neckHeight: '25%', width: '80%'
                        }
                    },
                    legend: { enabled: false },
                    series: [{
                        name: @json(__('project/reporting.overview.systematic-mapping-study.studies')),
                        data: [
                            [@json(__('project/reporting.overview.systematic-mapping-study.imported-studies')), {{ $importedStudiesCount }}],
                            [@json(__('project/reporting.overview.systematic-mapping-study.not-duplicate')), {{ $notDuplicateStudiesCount }}],
                            [@json(__('project/reporting.overview.systematic-mapping-study.status-selection')), {{ $studiesSelectionCount }}],
                            [@json(__('project/reporting.overview.systematic-mapping-study.status-quality')), {{ $studiesQualityCount }}],
                            [@json(__('project/reporting.overview.systematic-mapping-study.status-extration')), {{ $studiesExtractionCount }}]
                        ]
                    }],
                    responsive: {
                        rules: [{
                            condition: { maxWidth: 550 },
                            chartOptions: {
                                plotOptions: { series: { dataLabels: { inside: true }, center: ['50%','50%'], width: '100%' } }
                            }
                        }]
                    }
                });

                // ==== LINE: atividades por data ====
                const dates = @json($activitiesData['dates']);
                const projectTotalActivities = @json($activitiesData['projectTotalActivities']);
                const activitiesByUser = @json($activitiesData['activitiesByUser']);

                const seriesData = [{ name: @json(__('project/reporting.overview.project')), data: projectTotalActivities }];
                Object.keys(activitiesByUser).forEach(user => {
                    seriesData.push({ name: user, data: activitiesByUser[user] });
                });

                Highcharts.chart('publicOverviewChart', {
                    chart: { type: 'line' },
                    title: { text: @json(__('project/reporting.overview.project-activities-overtime')) },
                    xAxis: { categories: dates },
                    yAxis: { title: { text: @json(__('project/reporting.overview.total-activities')) } },
                    plotOptions: { line: { dataLabels: { enabled: true }, enableMouseTracking: true } },
                    series: seriesData
                });

                // ==== ORGANIZATION: fases RSL ====
                Highcharts.chart('publicOverviewRslPhases', {
                    chart: { type: 'organization', inverted: true, height: 575 },
                    title: {
                        text: @json(__('project/reporting.overview.stages-systematic-review')),
                        style: { fontSize: '18px' }
                    },
                    series: [{
                        type: 'organization',
                        name: 'Phase',
                        keys: ['from','to'],
                        data: [
                            ['Search in Digital Libraries', 'imported studies'],
                            ['imported studies', 'Duplicates Removal'],
                            ['Duplicates Removal', 'studies included'],
                            ['studies included', 'Inclusion/Exclusion Criteria'],
                            ['Inclusion/Exclusion Criteria', 'I/E studies'],
                            ['I/E studies', 'QA Assessment'],
                            ['QA Assessment', 'DE studies'],
                        ],
                        nodes: [
                            { id:'Search in Digital Libraries',
                                title:@json(__('project/reporting.overview.systematic-mapping-study.database.content')),
                                name:@json(__('project/reporting.overview.systematic-mapping-study.database.title')),
                                color:'#D0D0D0' },
                            { id:'Duplicates Removal',
                                title:'{{ $duplicateStudiesCount }} ' + @json(__('project/reporting.overview.systematic-mapping-study.duplicates.content')),
                                name:@json(__('project/reporting.overview.systematic-mapping-study.duplicates.title')),
                                color:'#F7C5C5' },
                            { id:'Inclusion/Exclusion Criteria',
                                title:'{{ $studiesSelectionRejectedCount }} ' + @json(__('project/reporting.overview.systematic-mapping-study.study-selection.content')),
                                name:@json(__('project/reporting.overview.systematic-mapping-study.study-selection.title')),
                                color:'#F8E8A2' },
                            { id:'QA Assessment',
                                title:'{{ $studiesQualityRejectedCount }} ' + @json(__('project/reporting.overview.systematic-mapping-study.quality-assessment.content')),
                                name:@json(__('project/reporting.overview.systematic-mapping-study.quality-assessment.title')),
                                color:'#D5FAD9' },
                            { id:'Data Extraction', title:'Data Extraction', name:'Data Extraction', color:'#D5FAD9' },
                            { id:'imported studies',
                                name:'{{ $importedStudiesCount }} ' + @json(__('project/reporting.overview.systematic-mapping-study.imported-studies')),
                                color:'#ffffff' },
                            { id:'studies included',
                                name:'{{ $notDuplicateStudiesCount }} ' + @json(__('project/reporting.overview.systematic-mapping-study.studies')),
                                color:'#ffffff' },
                            { id:'I/E studies',
                                name:'{{ $studiesSelectionCount }} ' + @json(__('project/reporting.overview.systematic-mapping-study.studies-I/E-included')),
                                color:'#ffffff' },
                            { id:'DE studies',
                                name:'{{ $studiesQualityCount }} ' + @json(__('project/reporting.overview.systematic-mapping-study.studies-accepted.content')),
                                title:@json(__('project/reporting.overview.systematic-mapping-study.studies-accepted.title')),
                                color:'#ffffff' },
                        ],
                        dataLabels: { style: { fontSize:'10px' } },
                        nodeHeight: 'auto'
                    }],
                    tooltip: { outside: true },
                    exporting: { allowHTML: true, sourceWidth: 600, sourceHeight: 800 }
                });

                // (Opcional) Se quiser o timeline, crie também um div com id=publicOverviewRslTimeline
                // e descomente abaixo:
                /*
                Highcharts.chart('publicOverviewRslTimeline', {
                    chart: { type: 'timeline', height: 250 },
                    title: { text: 'Systematic Literature Review Timeline', style: { fontSize: '14px' } },
                    xAxis: { visible: false }, yAxis: { visible: false },
                    series: [{ data: [
                        { name: 'Search in Digital Libraries', description: '6740 estudos encontrados.' },
                        { name: 'Duplicates Removal',        description: '28 estudos duplicados. 6712 estudos restantes.' },
                        { name: 'Inclusion/Exclusion Criteria', description: '6677 estudos removidos. 35 estudos restantes.' },
                        { name: 'QA Assessment', description: '11 estudos rejeitados. 24 estudos restantes.' },
                        { name: 'Data Extraction', description: 'Extração de dados dos 24 estudos finais.' }
                    ]}]
                });
                */
            }

            document.addEventListener('shown.bs.tab', (e) => {
                const target = e.target?.getAttribute('data-bs-target');
                if (target === '#tab-reports') {
                    // A função correta
                    window.hcReady(() => setTimeout(window.renderPublicOverviewCharts, 500));
                }
            });

            document.addEventListener('livewire:initialized', () => {
                // Evento para o caso do modal abrir e a aba 'reports' ser a ativa
                Livewire.on('public-reports-attempt-render', () => {
                    const reportsPane = document.querySelector('#tab-reports');

                    // Se a aba estiver visível (i.e., já tem a classe 'show' e 'active' ao carregar)
                    if (reportsPane && reportsPane.classList.contains('show')) {
                        hcReady(() => setTimeout(renderPublicOverviewCharts, 500));
                    }
                });
            });

        </script>
    @endpush
@endsection


