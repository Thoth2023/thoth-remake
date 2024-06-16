@extends("layouts.app")

@section("content")
@include("layouts.navbars.guest.navbar", ["title" => __("pages/home.home")])

<div class="container mt-8 mb-3">
    <div class="page-header d-flex flex-column pt-4 pb-11 border-radius-lg">
        <div class="row justify-content-center rounded-3 py-4 bg-gradient-faded-dark opacity-8" style="width: 100%">
            <div class="col-lg-6 text-center mx-auto">
                <h1 class="text-white">
                    {{ __("pages/home.welcome") }}
                </h1>
                <p class="text-lead text-white">
                    {{ __("pages/home.project_description") }}
                </p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="mt-lg-n12 mt-md-n13 mt-n12 justify-content-center">
            <div class="card d-inline-flex mt-5">
                <div class="card-body">
                    <a href="javascript:" class="card-title h5 d-block text-darker">
                        {{ __("pages/home.thoth") }}
                    </a>
                    <p class="card-description mb-0">
                        {{ __("pages/home.thoth_description") }}
                    </p>
                </div>
            </div>

            <div class="grid-items-2 gap-3 card-group mt-4 pb-3">
                @foreach ([
                "questions" => "ni ni-bullet-list-67",
                "relevant_data" => "ni ni-single-copy-04",
                "quality" => "ni ni-like-2",
                "analyse_data" => "ni ni-chart-bar-32"
                ]
                as $key => $icon)
                <div class="card rounded-3 p-3 d-flex flex-column h-100">
                    <div class="card-body pt-2 d-flex flex-column">
                        <a href="javascript:" class="card-title h5 d-flex align-items-center gap-2 text-darker">
                            <i class="{{ $icon }}"></i>
                            {{ __("pages/home." . $key) }}
                        </a>
                        <p class="card-description mb-4">
                            {{ __("pages/home." . $key . "_description") }}
                        </p>
                        <div class="mt-auto"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <a href="javascript:">
                        <i class="fas fa-project-diagram fa-2x mb-2"></i>
                        <h2 class="h2 card-title mt-auto">123</h2>
                        <h6 class="h6 card-text">{{ __("pages/home.total_projects") }} </h6>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <a href="javascript:">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <h2 class="card-title mt-auto hover-text">456</h2>
                        <h6 class="card-text">{{ __("pages/home.total_users") }}</h6>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <a href="javascript:">
                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                        <h2 class="card-title mt-auto">78</h2>
                        <h6 class="card-text">{{ __("pages/home.completed_projects") }}</h6>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <a href="javascript:">
                        <i class="fas fa-spinner fa-2x mb-2"></i>
                        <h2 class="card-title mt-auto">34</h2>
                        <h6 class="card-text">{{ __("pages/home.ongoing_projects") }}</h6>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection