@extends("layouts.app")

@section("content")
    @include("layouts.navbars.guest.navbar", ["title" => __("pages/home.home")])

    <div class="container mt-8 mb-3">
        <div class="page-header d-flex flex-column pt-4 pb-11 border-radius-lg">
            <div
                class="row justify-content-center rounded-3 py-4 bg-gradient-faded-dark opacity-8"
                style="width: 100%"
            >
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
                        <a
                            href="javascript:"
                            class="card-title h5 d-block text-darker"
                        >
                            {{ __("pages/home.thoth") }}
                        </a>
                        <p class="card-description mb-0">
                            {{ __("pages/home.thoth_description") }}
                        </p>
                    </div>
                </div>

                <div class="grid-items-2 gap-3 card-group mt-4 pb-3">
                    @foreach ($homeObjs as $homeObj)
                        <div class="card rounded-3 p-3">
                            <div class="card-body pt-2">
                                <a
                                    href="javascript:"
                                    class="card-title h5 d-flex align-items-center gap-2 text-darker"
                                >
                                    <i class="{{ $homeObj->icon }}"></i>
                                    {{ $homeObj->title }}
                                </a>
                                <p class="card-description mb-4">
                                    {{ $homeObj->description }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
