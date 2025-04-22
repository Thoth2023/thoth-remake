@extends("layouts.app")

@section("content")
    @include("layouts.navbars.guest.navbar", ["title" => "Home"])

    <div class="container mt-8 mb-3">
        <div class="page-header d-flex flex-column pt-4 pb-11 border-radius-lg">
            <div
                class="row justify-content-center rounded-3 py-4 bg-gradient-faded-dark opacity-8 "
                style="width: 100%"
            >
                <div class="col-lg-6 text-center mx-auto">
                    <h1 class="text-white">
                        {{ translationAbout('about') }}
                    </h1>
                    <p class="text-lead text-white">
                        {{ translationAbout('description') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="mt-lg-n12 mt-md-n13 mt-n12 justify-content-center">
                <div class="card d-inline-flex p-3 mt-5">
                    <div class="card-body pt-2">
                        <a
                            href="javascript:;"
                            class="card-title h4 d-block text-darker"
                        >
                            Thoth 2.0
                        </a>

                        <div class="card-body pt-2">
                            <a
                                href="javascript:"
                                class="card-title h5 d-block text-darker"
                            >
                                {{ translationAbout('new_features') }}
                            </a>
                            <ul>
                                <li>{{ translationAbout('recover_password') }}</li>
                                <li>{{ translationAbout('bug_databases') }}</li>
                                <li>{{ translationAbout('suggest_databases') }}</li>
                                <li>{{ translationAbout('new_qa') }}</li>
                                <li>{{ translationAbout('new_interface') }}</li>
                                <li>{{ translationAbout('new_framework') }}</li>
                                <li>{{ translationAbout('internationalization') }}</li>
                                <li>{{ translationAbout('usability') }}</li>
                                <li>{{ translationAbout('users_management') }}</li>
                                <li>{{ translationAbout('profile_management') }}</li>
                                <li>{{ translationAbout('members_invitation') }}</li>
                                <li>{{ translationAbout('pwa') }}</li>
                                <li>{{ translationAbout('snowballing') }}</li>
                                <li>{{ translationAbout('algolia_api') }}</li>
                                <li>{{ translationAbout('crossref_api') }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <a
                            href="javascript:"
                            class="card-title h5 d-block text-darker"
                        >
                            {{ translationAbout('development') }}
                        </a>
                        <p>{{ translationAbout('development_description') }}</p>
                    </div>
                    <div class="card-body pt-2">
                        <a
                            href="javascript:"
                            class="card-title h5 d-block text-darker"
                        >
                            {{ translationAbout('open_source_project') }}
                        </a>
                        <a
                            class="nav-link d-flex align-items-center me-2"
                            href="https://github.com/Thoth2023/thoth2.0/blob/main/LICENSE"
                        >
                            {{ translationAbout('mit_license') }}
                        </a>
                        <a
                            href="javascript:"
                            class="card-title h6 d-block text-darker"
                        >
                            {{ translationAbout('technologies_used') }}
                        </a>
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
                        <a
                            href="javascript:"
                            class="card-title h5 d-block text-darker"
                        >
                            {{ translationAbout('about_the_tool') }}
                        </a>
                        <p>
                            {{ translationAbout('about_the_tool_description') }}
                        </p>

                        <img
                            src="/img/about/AboutTool.PNG"
                            class="img-fluid"
                            alt="Imagem"
                        />

                        <a
                            href="javascript:"
                            class="card-title h6 d-block text-darker"
                        >
                            {{ translationAbout('cross_platform') }}
                        </a>
                        <p>
                            {{ translationAbout('cross_platform_description') }}
                        </p>

                        <a
                            href="javascript:"
                            class="card-title h6 d-block text-darker"
                        >
                            {{ translationAbout('automate_process') }}
                        </a>
                        <p>
                            {{ translationAbout('cross_platform_description') }}
                        </p>

                        <a
                            href="javascript:"
                            class="card-title h6 d-block text-darker"
                        >
                            {{ translationAbout('search_string') }}
                        </a>
                        <p>
                            {{ translationAbout('search_string_description') }}
                        </p>

                        <a
                            href="javascript:"
                            class="card-title h6 d-block text-darker"
                        >
                            {{ translationAbout('management_selection') }}
                        </a>
                        <p>
                            {{ translationAbout('management_selection_description') }}
                        </p>

                        <a
                            href="javascript:"
                            class="card-title h6 d-block text-darker"
                        >
                            {{ translationAbout('management_quality') }}
                        </a>
                        <p>
                            {{ translationAbout('management_quality_description') }}
                        </p>

                        <a
                            href="javascript:"
                            class="card-title h6 d-block text-darker"
                        >
                            {{ translationAbout('data_generation') }}
                        </a>
                        <p>
                            {{ translationAbout('data_generation_description') }}
                        </p>

                        <a
                            href="javascript:"
                            class="card-title h6 d-block text-darker"
                        >
                            {{ translationAbout('graphs_tables_generation') }}
                        </a>
                        <p>
                            {{ translationAbout('graphs_tables_generation_description') }}
                        </p>

                        <a
                            href="javascript:"
                            class="card-title h6 d-block text-darker"
                        >
                            {{ translationAbout('report_generation') }}
                        </a>
                        <p>
                            {{ translationAbout('report_generation_description') }}
                        </p>
                        <p>
                            {{ translationAbout('report_generation_description2') }}
                        </p>
                        <p>
                            {{ translationAbout('report_generation_description3') }}
                        </p>
                        <ul>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ translationAbout('multiple_member_management') }}
                                </a>
                                <p>
                                    {{ translationAbout('multiple_member_management_description') }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ translationAbout('manage_projects') }}
                                </a>
                                <p>
                                    {{ translationAbout('manage_projects_description') }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ translationAbout('activity_view') }}
                                </a>
                                <p>
                                    {{ translationAbout('activity_view_description') }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ translationAbout('progress_display') }}
                                </a>
                                <p>
                                    {{ translationAbout('progress_display_description') }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ translationAbout('protocol_management') }}
                                </a>
                                <p>
                                    {{ translationAbout('protocol_management_description') }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ translationAbout('study_import') }}
                                </a>
                                <p>
                                    {{ translationAbout('study_import_description') }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ translationAbout('selection_of_studies') }}
                                </a>
                                <p>
                                    {{ translationAbout('selection_of_studies_description') }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ translationAbout('checking_duplicate_studies') }}
                                </a>
                                <p>
                                    {{ translationAbout('checking_duplicate_studies_description') }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ translationAbout('selection_ranking_information') }}
                                </a>
                                <p>
                                    {{ translationAbout('selection_ranking_information_description') }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ translationAbout('study_information_visualization') }}
                                </a>
                                <p>
                                    {{ translationAbout('study_information_visualization_description') }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ translationAbout('status_for_each_member') }}
                                </a>
                                <p>
                                    {{ translationAbout('status_for_each_member_description') }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ translationAbout('conflicts_in_selection') }}
                                </a>
                                <p>
                                    {{ translationAbout('conflicts_in_selection_description') }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ translationAbout('resolution_of_conflicts_in_selection') }}
                                </a>
                                <p>
                                    {{ translationAbout('resolution_of_conflicts_in_selection_description') }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ translationAbout('quality_assessment_of_studies') }}
                                </a>
                                <p>
                                    {{ translationAbout('quality_assessment_of_studies_description') }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ translationAbout('quality_conflicts') }}
                                </a>
                                <p>
                                    {{ translationAbout('quality_conflicts_description') }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ translationAbout('data_extraction') }}
                                </a>
                                <p>
                                    {{ translationAbout('data_extraction_description') }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ translationAbout('report') }}
                                </a>
                                <p>
                                    {{ translationAbout('report_description') }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ translationAbout('export_to_latex') }}
                                </a>
                                <p>
                                    {{ translationAbout('export_to_latex_description') }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ translationAbout('export_to_bibtex') }}
                                </a>
                                <p>
                                    {{ translationAbout('export_to_bibtex_description') }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ translationAbout('improvement_of_search_strings') }}
                                </a>
                                <p>
                                    {{ translationAbout('improvement_of_search_strings_description') }}
                                </p>
                            </li>
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
                    <h5 class="modal-title" id="lgpdModalLabel"><i class="fas fa-user-shield me-1"></i>{{ translationHome('terms_and_lgpd') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ translationTerms('modal_lgpd') }}</p>
                    <a href="/terms"><i class="fas fa-file-alt"></i>{{ translationHome('terms_and_conditions') }}</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="acceptTermsAndLgpd()">
                        Entendi
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @if(session('show_lgpd_modal'))
                var lgpdModal = new bootstrap.Modal(document.getElementById('lgpdModal'));
                lgpdModal.show();
                @endif
            });

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
                            var lgpdModal = bootstrap.Modal.getInstance(document.getElementById('lgpdModal'));
                            lgpdModal.hide();
                        }
                    })
                    .catch(error => console.error('Erro:', error));
            }
        </script>
    @endpush
@endsection
