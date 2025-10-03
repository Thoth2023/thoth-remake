@extends("layouts.app")
@section("content")

    @guest
        @include("layouts.navbars.guest.navbar", ["title" => "Home"])
    @endguest

    @auth
        @include("layouts.navbars.auth.topnav", ["title" => __("pages/collaborators.collaborators")])
    @endauth

    <div class="container mt-3 mb-3">
        <div class="page-header d-flex flex-column pt-4 pb-11 border-radius-lg">
            <div
                class="row justify-content-center rounded-3 py-4 bg-gradient-faded-dark opacity-8 "
                style="width: 100%"
            >
                <div class="col-lg-6 text-center mx-auto">
                    <h1 class="text-white">
                        {{ __("pages/collaborators.collaborators") }}
                    </h1>
                    <p class="text-lead text-white">
                        {{ __("pages/collaborators.description") }}
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
                            {{ __("pages/collaborators.join_us") }}
                        </a>

                        <div class="card-body pt-2">
                            <p>{{ __("pages/collaborators.join_description") }}</p>

                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body text-center">
                                            <i class="fas fa-code fa-3x mb-3 text-primary"></i>
                                            <h5 class="card-title">{{ __("pages/collaborators.developers") }}</h5>
                                            <p class="card-text">{{ __("pages/collaborators.developers_description") }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body text-center">
                                            <i class="fas fa-paint-brush fa-3x mb-3 text-success"></i>
                                            <h5 class="card-title">{{ __("pages/collaborators.ui_ux") }}</h5>
                                            <p class="card-text">{{ __("pages/collaborators.ui_ux_description") }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body text-center">
                                            <i class="fas fa-chart-line fa-3x mb-3 text-danger"></i>
                                            <h5 class="card-title">{{ __("pages/collaborators.analysts") }}</h5>
                                            <p class="card-text">{{ __("pages/collaborators.analysts_description") }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-2">
                        <a
                            href="javascript:;"
                            class="card-title h4 d-block text-darker"
                        >
                            {{ __("pages/collaborators.how_to_contribute") }}
                        </a>
                        <p>{{ __("pages/collaborators.how_to_contribute_description") }}</p>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-transparent">
                                <i class="fab fa-github me-2"></i>
                                <a href="https://github.com/Thoth2023/thoth2.0" target="_blank" class="text-decoration-none">
                                    {{ __("pages/collaborators.github_repository") }}
                                </a>
                            </li>
                            <li class="list-group-item bg-transparent">
                                <i class="fas fa-book me-2"></i>
                                <a href="https://github.com/Thoth2023/thoth2.0/wiki" target="_blank" class="text-decoration-none">
                                    {{ __("pages/collaborators.documentation") }}
                                </a>
                            </li>
                            <li class="list-group-item bg-transparent">
                                <i class="fas fa-bug me-2"></i>
                                <a href="https://github.com/Thoth2023/thoth2.0/issues" target="_blank" class="text-decoration-none">
                                    {{ __("pages/collaborators.issues") }}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body pt-2">
                        <a
                            href="javascript:;"
                            class="card-title h4 d-block text-darker"
                        >
                            {{ __("pages/collaborators.contact") }}
                        </a>
                        <p>{{ __("pages/collaborators.contact_description") }}</p>

                        <div class="d-grid gap-2 col-md-6 mx-auto mt-4">
                            <a href="mailto:thothslr@gmail.com" class="btn btn-primary">
                                <i class="fas fa-envelope me-2"></i>{{ __("pages/collaborators.contact_us") }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
