@extends("layouts.app")
@section("content")

    @guest
        @include("layouts.navbars.guest.navbar", ["title" => "Home"])
    @endguest

    @auth
        @include("layouts.navbars.auth.topnav", ["title" => __("pages/donations.donations")])
    @endauth

    <div class="container mt-3 mb-3">
        <div class="page-header d-flex flex-column pt-4 pb-11 border-radius-lg">
            <div
                class="row justify-content-center rounded-3 py-4 bg-gradient-faded-dark opacity-8"
                style="width: 100%"
            >
                <div class="col-lg-6 text-center mx-auto">
                    <h1 class="text-white">
                        {{ __("pages/donations.donations") }}
                    </h1>
                    <p class="text-lead text-white">
                        {{ __("pages/donations.description") }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="mt-lg-n12 mt-md-n13 mt-n12 justify-content-center">
                <div class="card d-inline-flex p-3 mt-5">
                    <div class="card-body pt-2">
                        <h4 class="card-title text-darker mb-4">
                            {{ __("pages/donations.why_donate") }}
                        </h4>
                        <p class="mb-4">{{ __("pages/donations.why_donate_description") }}</p>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fas fa-server text-primary me-2"></i>
                                            {{ __("pages/donations.infrastructure") }}
                                        </h5>
                                        <p class="card-text">{{ __("pages/donations.infrastructure_description") }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fas fa-tools text-success me-2"></i>
                                            {{ __("pages/donations.new_features") }}
                                        </h5>
                                        <p class="card-text">{{ __("pages/donations.new_features_description") }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <h4 class="mb-4">{{ __("pages/donations.how_to_donate") }}</h4>
                            <p class="mb-4">{{ __("pages/donations.contact_description") }}</p>
                            <a href="mailto:thothslr@gmail.com" class="btn btn-primary btn-lg">
                                <i class="fas fa-envelope me-2"></i>{{ __("pages/donations.contact_us") }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
