@extends("layouts.app")

@section("content")
    @include("layouts.navbars.guest.navbar", ["title" => "pages.home.home"])
    <div class="container mt-8 mb-3">
        <div class="page-header d-flex flex-column pt-4 pb-11 border-radius-lg">
            <div
                class=""
                style="width: 100%"
            >
                <div class="col-lg-6 text-center mx-auto">
                    <h1 class="text-white" style="font-size: 2rem">
                        {{ __("page-management/management.faq-management.title") }}
                    </h1>
                    <p class="text-lead text-white">
                        {{ __("page-management/management.faq-management.description") }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="mt-lg-n12 mt-md-n13 mt-n12 justify-content-center">
                @livewire('faq.faq-manager')
            </div>
        </div>
    </div>
@endsection
