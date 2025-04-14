@extends("layouts.app")

@section("content")
    @include("layouts.navbars.guest.navbar", ["title" => "Início"])

    <div class="container mt-8 mb-3">
        <!-- Cabeçalho -->
        <div class="page-header d-flex flex-column pt-4 pb-11 border-radius-lg">
            <div class="row justify-content-center rounded-3 py-4 bg-gradient-faded-dark opacity-8" style="width: 100%">
                <div class="col-lg-6 text-center mx-auto">
                    <h1 class="text-white">{{ __("pages/about.about") }}</h1>
                    <p class="text-lead text-white">{{ __("pages/about.description") }}</p>
                </div>
            </div>
        </div>

        <!-- Conteúdo Principal -->
        <div class="row">
            <div class="mt-lg-n12 mt-md-n13 mt-n12 justify-content-center">
                <div class="card d-inline-flex p-3 mt-5">
                    <div class="card-body pt-2">
                        <h4 class="card-title text-darker">Thoth 2.0</h4>

                        <!-- Novas Funcionalidades -->
                        <div class="card-body pt-2">
                            <h5 class="card-title text-darker">{{ __("pages/about.new_features") }}</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-unlock-alt me-2 text-primary"></i>{{ __("pages/about.recover_password") }}</li>
                                <li><i class="fas fa-bug me-2 text-danger"></i>{{ __("pages/about.bug_databases") }}</li>
                                <li><i class="fas fa-lightbulb me-2 text-warning"></i>{{ __("pages/about.suggest_databases") }}</li>
                                <li><i class="fas fa-question-circle me-2 text-info"></i>{{ __("pages/about.new_qa") }}</li>
                                <li><i class="fas fa-paint-brush me-2 text-success"></i>{{ __("pages/about.new_interface") }}</li>
                                <li><i class="fas fa-code me-2 text-secondary"></i>{{ __("pages/about.new_framework") }}</li>
                                <li><i class="fas fa-globe me-2 text-primary"></i>{{ __("pages/about.internationalization") }}</li>
                                <li><i class="fas fa-mouse-pointer me-2 text-dark"></i>{{ __("pages/about.usability") }}</li>
                                <li><i class="fas fa-users-cog me-2 text-info"></i>{{ __("pages/about.users_management") }}</li>
                                <li><i class="fas fa-id-badge me-2 text-warning"></i>{{ __("pages/about.profile_management") }}</li>
                                <li><i class="fas fa-user-plus me-2 text-success"></i>{{ __("pages/about.members_invitation") }}</li>
                                <li><i class="fas fa-mobile-alt me-2 text-danger"></i>{{ __("pages/about.pwa") }}</li>
                                <li><i class="fas fa-snowflake me-2 text-info"></i>{{ __("pages/about.snowballing") }}</li>
                                <li><i class="fas fa-search me-2 text-primary"></i>{{ __("pages/about.algolia_api") }}</li>
                                <li><i class="fas fa-database me-2 text-secondary"></i>{{ __("pages/about.crossref_api") }}</li>
                            </ul>
                        </div>

                        <!-- Funcionalidades Principais -->
                        <div class="card-body pt-2">
                            <h5 class="card-title text-darker">{{ __("pages/about.main_features") }}</h5>
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title text-darker">{{ __("pages/about.manage_projects") }}</h5>
                                            <p><i class="fas fa-tasks me-2 text-primary"></i>{{ __("pages/about.manage_projects_description") }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title text-darker">{{ __("pages/about.activity_view") }}</h5>
                                            <p><i class="fas fa-history me-2 text-warning"></i>{{ __("pages/about.activity_view_description") }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title text-darker">{{ __("pages/about.progress_display") }}</h5>
                                            <p><i class="fas fa-chart-line me-2 text-success"></i>{{ __("pages/about.progress_display_description") }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr style="border: 1px solid #ddd; margin: 20px 0;">
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title text-darker">{{ __("pages/about.protocol_management") }}</h5>
                                            <p><i class="fas fa-cogs me-2 text-secondary"></i>{{ __("pages/about.protocol_management_description") }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title text-darker">{{ __("pages/about.study_import") }}</h5>
                                            <p><i class="fas fa-file-import me-2 text-info"></i>{{ __("pages/about.study_import_description") }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title text-darker">{{ __("pages/about.selection_of_studies") }}</h5>
                                            <p><i class="fas fa-check-circle me-2 text-danger"></i>{{ __("pages/about.selection_of_studies_description") }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                        <a href="/terms" class="text-decoration-none">
                            <i class="fas fa-file-alt me-1"></i>{{ __("pages/home.terms_and_conditions") }}
                        </a>
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
