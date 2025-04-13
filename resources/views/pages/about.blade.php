@extends("layouts.app")

@section("content")
    @include("layouts.navbars.guest.navbar", ["title" => "Home"])

    <div class="container mt-8 mb-3">
        <div class="page-header d-flex flex-column pt-4 pb-11 border-radius-lg" style="background: linear-gradient(135deg, rgba(255, 255, 255, 0.8) 30%, rgba(0, 0, 0, 0.1) 70%); box-shadow: 0px 8px 15px rgba(0,0,0,0.1);">
            <div class="row justify-content-center rounded-3 py-4 bg-gradient-dark opacity-8" style="width: 100%">
                <div class="col-lg-6 text-center mx-auto">
                    <h1 class="text-white font-weight-bold">
                        {{ __("pages/about.about") }}
                    </h1>
                    <p class="text-lead text-white mb-5">
                        {{ __("pages/about.description") }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-light shadow-lg rounded-lg p-4 mt-5">
                    <div class="card-body">
                        <h3 class="text-dark font-weight-semibold mb-4">{{ __("pages/about.main_features") }}</h3>
                        <ul class="list-unstyled">
                            <li class="py-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __("pages/about.recover_password") }}</li>
                            <li class="py-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __("pages/about.bug_databases") }}</li>
                            <li class="py-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __("pages/about.suggest_databases") }}</li>
                            <li class="py-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __("pages/about.new_qa") }}</li>
                            <li class="py-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __("pages/about.new_interface") }}</li>
                            <li class="py-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __("pages/about.new_framework") }}</li>
                            <li class="py-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __("pages/about.internationalization") }}</li>
                            <li class="py-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __("pages/about.usability") }}</li>
                            <li class="py-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __("pages/about.users_management") }}</li>
                            <li class="py-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __("pages/about.profile_management") }}</li>
                            <li class="py-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __("pages/about.members_invitation") }}</li>
                            <li class="py-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __("pages/about.pwa") }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-5">
            <div class="col-lg-10">
                <div class="card border-light shadow-lg rounded-lg p-4">
                    <div class="card-body">
                        <h3 class="text-dark font-weight-semibold mb-4">{{ __("pages/about.advanced_features") }}</h3>
                        <ul class="list-unstyled">
                            <li class="py-3 px-4 mb-2 bg-gradient-light rounded-3 shadow-sm hover-shadow-lg">
                                <a href="javascript:" class="d-block text-dark h5">
                                    {{ __("pages/about.manage_projects") }}
                                </a>
                                <p>{{ __("pages/about.manage_projects_description") }}</p>
                            </li>
                            <li class="py-3 px-4 mb-2 bg-gradient-light rounded-3 shadow-sm hover-shadow-lg">
                                <a href="javascript:" class="d-block text-dark h5">
                                    {{ __("pages/about.activity_view") }}
                                </a>
                                <p>{{ __("pages/about.activity_view_description") }}</p>
                            </li>
                            <li class="py-3 px-4 mb-2 bg-gradient-light rounded-3 shadow-sm hover-shadow-lg">
                                <a href="javascript:" class="d-block text-dark h5">
                                    {{ __("pages/about.progress_display") }}
                                </a>
                                <p>{{ __("pages/about.progress_display_description") }}</p>
                            </li>
                            <li class="py-3 px-4 mb-2 bg-gradient-light rounded-3 shadow-sm hover-shadow-lg">
                                <a href="javascript:" class="d-block text-dark h5">
                                    {{ __("pages/about.protocol_management") }}
                                </a>
                                <p>{{ __("pages/about.protocol_management_description") }}</p>
                            </li>
                            <li class="py-3 px-4 mb-2 bg-gradient-light rounded-3 shadow-sm hover-shadow-lg">
                                <a href="javascript:" class="d-block text-dark h5">
                                    {{ __("pages/about.study_import") }}
                                </a>
                                <p>{{ __("pages/about.study_import_description") }}</p>
                            </li>
                            <li class="py-3 px-4 mb-2 bg-gradient-light rounded-3 shadow-sm hover-shadow-lg">
                                <a href="javascript:" class="d-block text-dark h5">
                                    {{ __("pages/about.selection_of_studies") }}
                                </a>
                                <p>{{ __("pages/about.selection_of_studies_description") }}</p>
                            </li>
                            <li class="py-3 px-4 mb-2 bg-gradient-light rounded-3 shadow-sm hover-shadow-lg">
                                <a href="javascript:" class="d-block text-dark h5">
                                    {{ __("pages/about.checking_duplicate_studies") }}
                                </a>
                                <p>{{ __("pages/about.checking_duplicate_studies_description") }}</p>
                            </li>
                            <li class="py-3 px-4 mb-2 bg-gradient-light rounded-3 shadow-sm hover-shadow-lg">
                                <a href="javascript:" class="d-block text-dark h5">
                                    {{ __("pages/about.selection_ranking_information") }}
                                </a>
                                <p>{{ __("pages/about.selection_ranking_information_description") }}</p>
                            </li>
                            <li class="py-3 px-4 mb-2 bg-gradient-light rounded-3 shadow-sm hover-shadow-lg">
                                <a href="javascript:" class="d-block text-dark h5">
                                    {{ __("pages/about.study_information_visualization") }}
                                </a>
                                <p>{{ __("pages/about.study_information_visualization_description") }}</p>
                            </li>
                            <li class="py-3 px-4 mb-2 bg-gradient-light rounded-3 shadow-sm hover-shadow-lg">
                                <a href="javascript:" class="d-block text-dark h5">
                                    {{ __("pages/about.status_for_each_member") }}
                                </a>
                                <p>{{ __("pages/about.status_for_each_member_description") }}</p>
                            </li>
                            <li class="py-3 px-4 mb-2 bg-gradient-light rounded-3 shadow-sm hover-shadow-lg">
                                <a href="javascript:" class="d-block text-dark h5">
                                    {{ __("pages/about.conflicts_in_selection") }}
                                </a>
                                <p>{{ __("pages/about.conflicts_in_selection_description") }}</p>
                            </li>
                            <li class="py-3 px-4 mb-2 bg-gradient-light rounded-3 shadow-sm hover-shadow-lg">
                                <a href="javascript:" class="d-block text-dark h5">
                                    {{ __("pages/about.resolution_of_conflicts_in_selection") }}
                                </a>
                                <p>{{ __("pages/about.resolution_of_conflicts_in_selection_description") }}</p>
                            </li>
                            <li class="py-3 px-4 mb-2 bg-gradient-light rounded-3 shadow-sm hover-shadow-lg">
                                <a href="javascript:" class="d-block text-dark h5">
                                    {{ __("pages/about.quality_assessment_of_studies") }}
                                </a>
                                <p>{{ __("pages/about.quality_assessment_of_studies_description") }}</p>
                            </li>
                            <li class="py-3 px-4 mb-2 bg-gradient-light rounded-3 shadow-sm hover-shadow-lg">
                                <a href="javascript:" class="d-block text-dark h5">
                                    {{ __("pages/about.quality_conflicts") }}
                                </a>
                                <p>{{ __("pages/about.quality_conflicts_description") }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal LGPD -->
        <div class="modal fade" id="lgpdModal" tabindex="-1" aria-labelledby="lgpdModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content modal-transparent shadow-lg rounded-lg">
                    <div class="modal-header">
                        <h5 class="modal-title" id="lgpdModalLabel"><i class="fas fa-user-shield me-1"></i>{{ __("pages/home.terms_and_lgpd") }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ __("pages/terms.modal_lgpd") }}</p>
                        <a href="/terms" class="btn btn-link text-dark"><i class="fas fa-file-alt"></i>{{ __("pages/home.terms_and_conditions") }}</a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="acceptTermsAndLgpd()">
                            {{ __("pages/home.understood") }}
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __("pages/home.cancel") }}
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
    </div>
@endsection
