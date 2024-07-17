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
                        {{ __("pages/about.about") }}
                    </h1>
                    <p class="text-lead text-white">
                        {{ __("pages/about.description") }}
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
                                {{ __("pages/about.new_features") }}
                            </a>
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
                        <a
                            href="javascript:"
                            class="card-title h5 d-block text-darker"
                        >
                            {{ __("pages/about.development") }}
                        </a>
                        <p>{{ __("pages/about.development_description") }}</p>
                    </div>
                    <div class="card-body pt-2">
                        <a
                            href="javascript:"
                            class="card-title h5 d-block text-darker"
                        >
                            {{ __("pages/about.open_source_project") }}
                        </a>
                        <a
                            class="nav-link d-flex align-items-center me-2"
                            href="https://github.com/Thoth2023/thoth2.0/blob/main/LICENSE"
                        >
                            {{ __("pages/about.mit_license") }}
                        </a>
                        <a
                            href="javascript:"
                            class="card-title h6 d-block text-darker"
                        >
                            {{ __("pages/about.technologies_used") }}
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
                            {{ __("pages/about.about_the_tool") }}
                        </a>
                        <p>
                            {{ __("pages/about.about_the_tool_description") }}
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
                            {{ __("pages/about.cross_platform") }}
                        </a>
                        <p>
                            {{ __("pages/about.cross_platform_description") }}
                        </p>

                        <a
                            href="javascript:"
                            class="card-title h6 d-block text-darker"
                        >
                            {{ __("pages/about.automate_process") }}
                        </a>
                        <p>
                            {{ __("pages/about.cross_platform_description") }}
                        </p>

                        <a
                            href="javascript:"
                            class="card-title h6 d-block text-darker"
                        >
                            {{ __("pages/about.search_string") }}
                        </a>
                        <p>
                            {{ __("pages/about.search_string_description") }}
                        </p>

                        <a
                            href="javascript:"
                            class="card-title h6 d-block text-darker"
                        >
                            {{ __("pages/about.management_selection") }}
                        </a>
                        <p>
                            {{ __("pages/about.management_selection_description") }}
                        </p>

                        <a
                            href="javascript:"
                            class="card-title h6 d-block text-darker"
                        >
                            {{ __("pages/about.management_quality") }}
                        </a>
                        <p>
                            {{ __("pages/about.management_quality_description") }}
                        </p>

                        <a
                            href="javascript:"
                            class="card-title h6 d-block text-darker"
                        >
                            {{ __("pages/about.data_generation") }}
                        </a>
                        <p>
                            {{ __("pages/about.data_generation_description") }}
                        </p>

                        <a
                            href="javascript:"
                            class="card-title h6 d-block text-darker"
                        >
                            {{ __("pages/about.graphs_tables_generation") }}
                        </a>
                        <p>
                            {{ __("pages/about.graphs_tables_generation_description") }}
                        </p>

                        <a
                            href="javascript:"
                            class="card-title h6 d-block text-darker"
                        >
                            {{ __("pages/about.report_generation") }}
                        </a>
                        <p>
                            {{ __("pages/about.report_generation_description") }}
                        </p>
                        <p>
                            {{ __("pages/about.report_generation_description2") }}
                        </p>
                        <p>
                            {{ __("pages/about.report_generation_description3") }}
                        </p>
                        <ul>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ __("pages/about.multiple_member_management") }}
                                </a>
                                <p>
                                    {{ __("pages/about.multiple_member_management_description") }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ __("pages/about.manage_projects") }}
                                </a>
                                <p>
                                    {{ __("pages/about.manage_projects_description") }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ __("pages/about.activity_view") }}
                                </a>
                                <p>
                                    {{ __("pages/about.activity_view_description") }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ __("pages/about.progress_display") }}
                                </a>
                                <p>
                                    {{ __("pages/about.progress_display_description") }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ __("pages/about.protocol_management") }}
                                </a>
                                <p>
                                    {{ __("pages/about.protocol_management_description") }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ __("pages/about.study_import") }}
                                </a>
                                <p>
                                    {{ __("pages/about.study_import_description") }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ __("pages/about.selection_of_studies") }}
                                </a>
                                <p>
                                    {{ __("pages/about.selection_of_studies_description") }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ __("pages/about.checking_duplicate_studies") }}
                                </a>
                                <p>
                                    {{ __("pages/about.checking_duplicate_studies_description") }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ __("pages/about.selection_ranking_information") }}
                                </a>
                                <p>
                                    {{ __("pages/about.selection_ranking_information_description") }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ __("pages/about.study_information_visualization") }}
                                </a>
                                <p>
                                    {{ __("pages/about.study_information_visualization_description") }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ __("pages/about.status_for_each_member") }}
                                </a>
                                <p>
                                    {{ __("pages/about.status_for_each_member_description") }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ __("pages/about.conflicts_in_selection") }}
                                </a>
                                <p>
                                    {{ __("pages/about.conflicts_in_selection_description") }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ __("pages/about.resolution_of_conflicts_in_selection") }}
                                </a>
                                <p>
                                    {{ __("pages/about.resolution_of_conflicts_in_selection_description") }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ __("pages/about.quality_assessment_of_studies") }}
                                </a>
                                <p>
                                    {{ __("pages/about.quality_assessment_of_studies_description") }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ __("pages/about.quality_conflicts") }}
                                </a>
                                <p>
                                    {{ __("pages/about.quality_conflicts_description") }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ __("pages/about.data_extraction") }}
                                </a>
                                <p>
                                    {{ __("pages/about.data_extraction_description") }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ __("pages/about.report") }}
                                </a>
                                <p>
                                    {{ __("pages/about.report_description") }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ __("pages/about.export_to_latex") }}
                                </a>
                                <p>
                                    {{ __("pages/about.export_to_latex_description") }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ __("pages/about.export_to_bibtex") }}
                                </a>
                                <p>
                                    {{ __("pages/about.export_to_bibtex_description") }}
                                </p>
                            </li>
                            <li>
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-block text-darker"
                                >
                                    {{ __("pages/about.improvement_of_search_strings") }}
                                </a>
                                <p>
                                    {{ __("pages/about.improvement_of_search_strings_description") }}
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
