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

                    <img src="/img/about/AboutTool.PNG" class="img-fluid" alt="Imagem" />

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
                        'improvement_of_search_strings'
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
