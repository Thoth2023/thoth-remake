@extends("layouts.app")
@section("content")

@guest
    @include("layouts.navbars.guest.navbar", ["title" => "Home"])
@endguest

@auth
    @include("layouts.navbars.auth.topnav", ["title" => __("pages/about.about")])
@endauth


<div class="container mt-6 mb-3">
    <!-- cabeçalho -->
    <div class="page-header d-flex flex-column pt-4 pb-11 border-radius-lg">
        <div class="row justify-content-center rounded-3 py-4 bg-gradient-faded-dark opacity-8 w-100">
            <div class="col-lg-6 text-center mx-auto">
                <h1 class="text-white">{{ __("pages/about.about") }}</h1>
                <p class="text-lead text-white">{{ __("pages/about.description") }}</p>

            </div>
        </div>
        <div class="row">
            <div class="mt-lg-n12 mt-md-n13 mt-n12 justify-content-center">
                <div class="card d-inline-flex p-3 mt-6">
                    <div class="card-body pt-2">
                        <span
                            href="#"
                            onclick="event.preventDefault();"
                            class="card-title h4 d-block text-darker"
                            style="cursor: default; transition: color 0.2s;"
                        >
                            Thoth 2.0
                        </span>

                        <div class="card-body pt-2">
                            <span
                                href="#"
                                onclick="event.preventDefault();"
                                class="card-title h5 d-block text-darker"
                                style="cursor: default; transition: color 0.2s;"
                            >
                                {{ __("pages/about.new_features") }}
                            </span>
                            <ul>
                                <li>{{ __("pages/about.recover_password") }}</li>
                                <li>{{ __("pages/about.login_google") }}</li>
                                <li>{{ __("pages/about.bug_databases") }}</li>
                                <li>{{ __("pages/about.suggest_databases") }}</li>
                                <li>{{ __("pages/about.new_qa") }}</li>
                                <li>{{ __("pages/about.new_interface") }}</li>
                                <li>{{ __("pages/about.new_framework") }}</li>
                                <li>{{ __("pages/about.internationalization") }}</li>
                                <li>{{ __("pages/about.usability") }}</li>
                                <li>{{ __("pages/about.users_management") }}</li>
                                <li>{{ __("pages/about.profile_management") }}</li>
                                <li>{{ __("pages/about.members_invitation") }}</li>
                                <li>{{ __("pages/about.pwa") }}</li>
                                <li>{{ __("pages/about.snowballing") }}</li>
                                <li>{{ __("pages/about.algolia_api") }}</li>
                                <li>{{ __("pages/about.crossref_api") }}</li>
                                <li>{{ __("pages/about.references") }}</li>
                                <li>{{ __("pages/about.chat_project") }}</li>
                                <li>{{ __("pages/about.lgpd") }}</li>
                                <li>{{ __("pages/about.docs") }}</li>
                                <li>{{ __("pages/about.reports") }}</li>
                                <li>{{ __("pages/about.availability") }}</li>
                                <li>{{ __("pages/about.module_notification") }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <span
                            href="#"
                            onclick="event.preventDefault();"
                            class="card-title h5 d-block text-darker"
                            style="cursor: default; transition: color 0.2s;"
                        >
                            {{ __("pages/about.development") }}
                        </span>
                        <p>{{ __("pages/about.development_description") }}</p>
                    </div>
                    {{-- ==================== CITE-NOS ==================== --}}
                    <div class="card-body pt-2">
    <span
        href="#"
        onclick="event.preventDefault();"
        class="card-title h5 d-block text-darker"
        style="cursor: default; transition: color 0.2s;"
    >
        {{ __("pages/about.cite_us") }}
    </span>
                        <p>{{ __("pages/about.cite_us_description") }}</p>

                        <div class="border-start border-4 border-primary ps-3 mb-3">
                            <p class="fw-bold mb-1">Diego Comis and Elder Rodrigues. 2025.</p>
                            <p class="mb-1"><em>Thoth 2.0: Advancing an RSL Tool for Enhanced Snowballing Support.</em></p>
                            <p class="mb-1">Anais do XXXIX Simpósio Brasileiro de Engenharia de Software (SBES), Recife/PE.</p>
                            <p class="mb-0">
                                DOI: <a href="https://doi.org/10.5753/sbes.2025.11616" target="_blank">10.5753/sbes.2025.11616</a> —
                                <a href="https://sol.sbc.org.br/index.php/sbes/article/view/37092" target="_blank">
                                    {{ __("pages/about.access_article") }}
                                </a>
                            </p>
                        </div>

                        {{-- Botões para formatos de citação --}}
                        <div class="mt-3">
                            <p class="fw-bold">{{ __("pages/about.select_format") }}</p>
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-outline-primary btn-sm" onclick="showCitationModal('abnt')">ABNT</button>
                                <button class="btn btn-outline-primary btn-sm" onclick="showCitationModal('bibtex')">BibTeX</button>
                                <button class="btn btn-outline-primary btn-sm" onclick="showCitationModal('ris')">RIS</button>
                                <button class="btn btn-outline-primary btn-sm" onclick="showCitationModal('acm')">ACM</button>
                                <button class="btn btn-outline-primary btn-sm" onclick="showCitationModal('ieee')">IEEE</button>
                            </div>
                        </div>
                    </div>

                    {{-- Modal para exibir citação --}}
                    <div class="modal fade" id="citationModal" tabindex="-1" aria-labelledby="citationModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-dark">
                                    <h5 class="modal-title" id="citationModalLabel">{{ __("pages/about.citation_modal_title") }}</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <textarea id="citationText" class="form-control" rows="10" readonly></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __("pages/about.close") }}</button>
                                    <button type="button" class="btn btn-success" onclick="copyCitation()">{{ __("pages/about.copy") }}</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @push('js')
                        <script>
                            function showCitationModal(format) {
                                const citations = {
                                    abnt: `COMIS, Diego; RODRIGUES, Elder Thoth 2.0: Advancing an RSL Tool for Enhanced Snowballing Support. In: Anais do XXXIX Simpósio Brasileiro de Engenharia de Software, Recife/PE, 2025. Porto Alegre: SBC. DOI: 10.5753/sbes.2025.11616.`,
                                    bibtex: `@inproceedings{sbes,
  author = {Diego Comis and Elder Rodrigues},
  title = {Thoth 2.0: Advancing an RSL Tool for Enhanced Snowballing Support},
  booktitle = {Anais do XXXIX Simpósio Brasileiro de Engenharia de Software},
  location = {Recife/PE},
  year = {2025},
  issn = {2833-0633},
  pages = {1010--1016},
  publisher = {SBC},
  address = {Porto Alegre, RS, Brasil},
  doi = {10.5753/sbes.2025.11616},
  url = {https://sol.sbc.org.br/index.php/sbes/article/view/37092}
}`,
                                    ris: `TY  - CONF
AU  - Comis, Diego
AU  - Rodrigues, Elder
TI  - Thoth 2.0: Advancing an RSL Tool for Enhanced Snowballing Support
T2  - Anais do XXXIX Simpósio Brasileiro de Engenharia de Software
CY  - Recife/PE
PY  - 2025
DO  - 10.5753/sbes.2025.11616
UR  - https://sol.sbc.org.br/index.php/sbes/article/view/37092
PB  - SBC
ER  -`,
                                    acm: `Comis, Diego and Rodrigues, Elder 2025. Thoth 2.0: Advancing an RSL Tool for Enhanced Snowballing Support. In Proceedings of the XXXIX Simpósio Brasileiro de Engenharia de Software (SBES 2025). SBC, Porto Alegre, Brasil, 1010–1016. DOI:https://doi.org/10.5753/sbes.2025.11616.`,
                                    ieee: `Diego Comis and Elder Rodrigues, "Thoth 2.0: Advancing an RSL Tool for Enhanced Snowballing Support," Anais do XXXIX Simpósio Brasileiro de Engenharia de Software, Recife/PE, 2025, pp. 1010–1016, doi: 10.5753/sbes.2025.11616.`
                                };

                                document.getElementById('citationText').value = citations[format];
                                const modal = new bootstrap.Modal(document.getElementById('citationModal'));
                                modal.show();
                            }

                            function copyCitation() {
                                const citation = document.getElementById('citationText');
                                citation.select();
                                document.execCommand('copy');
                                alert("{{ __('pages/about.copied_success') }}");
                            }
                        </script>
                    @endpush

                    <div class="card-body pt-2">
                        <span
                            href="#"
                            onclick="event.preventDefault();"
                            class="card-title h5 d-block text-darker"
                            style="cursor: default; transition: color 0.2s;"
                        >
                            {{ __("pages/about.open_source_project") }}
                        </span>
                        <a
                            class="nav-link d-flex align-items-center me-2"
                            href="https://github.com/Thoth2023/thoth2.0/blob/main/LICENSE"
                        >
                            {{ __("pages/about.mit_license") }}
                        </a>
                        <span
                            href="#"
                            onclick="event.preventDefault();"
                            class="card-title h6 d-block text-darker"
                            style="cursor: default; transition: color 0.2s;"
                        >
                            {{ __("pages/about.technologies_used") }}
                        </span>
                        <ul>
                            <li>PHP Language</li>
                            <li>MySQL</li>
                            <li>Git</li>
                            <li>Laravel Framework</li>
                            <li>Docker</li>
                            <li>Bootstrap</li>
                            <li>Migrations</li>
                            <li>PHPSpreadSheet</li>
                            <li>League/CSV</li>
                            <li>PHPUnit</li>
                            <li>JavaScript</li>
                            <li>Git Actions</li>
                        </ul>
                    </div>

                    <div class="card-body pt-2">
                        <span
                            href="#"
                            onclick="event.preventDefault();"
                            class="card-title h5 d-block text-darker"
                            style="cursor: default; transition: color 0.2s;"
                        >
                            {{ __("pages/about.about_the_tool") }}
                        </span>
                        <p>
                            {{ __("pages/about.about_the_tool_description") }}
                        </p>

                        <div class="text-center my-4">
                            @if (App::getLocale() === 'en')
                                <img src="/img/about/english_thoth.png" class="img-fluid mx-auto d-block" alt="System Structure (English)" style="max-width: 90%;">
                            @else
                                <img src="/img/about/thoth_estrutura_sistema.png" class="img-fluid mx-auto d-block" alt="Estrutura do Sistema (Português)" style="max-width: 90%;">
                            @endif
                        </div>


                    @foreach([
                    'cross_platform', 'automate_process', 'search_string',
                    'management_selection', 'management_quality', 'data_generation',
                    'graphs_tables_generation', 'report_generation'
                    ] as $section)
                    <h6 class="card-title text-darker mt-3">{{ __("pages/about.$section") }}</h6>
                    <p>{{ __("pages/about.{$section}_description") }}</p>
                    @endforeach

                    <p>{{ __("pages/about.report_generation_description2") }}</p>
                    <p>{{ __("pages/about.report_generation_description3") }}</p>

                    <ul>
                        @foreach([
                        'multiple_member_management',
                        'manage_projects',
                        'activity_view',
                        'progress_display',
                        'protocol_management',
                        'study_import',
                        'selection_of_studies',
                        'checking_duplicate_studies',
                        'selection_ranking_information',
                        'study_information_visualization',
                        'status_for_each_member',
                        'conflicts_in_selection',
                        'resolution_of_conflicts_in_selection',
                        'quality_assessment_of_studies',
                        'quality_conflicts',
                        'data_extraction',
                        'report',
                        'export_to_latex',
                        'export_to_bibtex',
                        'improvement_of_search_strings',
                        ] as $item)
                        <li>
                            <h5 class="card-title text-darker">{{ __("pages/about.$item") }}</h5>
                            <p>{{ __("pages/about.{$item}_description") }}</p>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal LGPD -->
<div class="modal fade" id="lgpdModal" tabindex="-1" aria-labelledby="lgpdModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content modal-transparent">
            <div class="modal-header">
                <h5 class="modal-title" id="lgpdModalLabel">
                    <i class="fas fa-user-shield me-1"></i>{{ __("pages/home.terms_and_lgpd") }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __("pages/terms.modal_lgpd") }}</p>
                <a href="/terms"><i class="fas fa-file-alt"></i>{{ __("pages/home.terms_and_conditions") }}</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="acceptTermsAndLgpd()">Entendi</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('show_lgpd_modal'))
    new bootstrap.Modal(document.getElementById('lgpdModal')).show();
    @endif
});

// Function to accept terms and LGPD
function acceptTermsAndLgpd() {
    fetch("{{ route('accept.lgpd') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('lgpdModal')).hide();
            }
        })
        .catch(error => console.error('Erro:', error));
}
</script>
@endpush
@endsection
