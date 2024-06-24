@extends("layouts.app")

@section("content")
    @include("layouts.navbars.guest.navbar", ["title" => "pages.home.home"])

    <div class="container mt-8 mb-3">
        <div class="page-header d-flex flex-column pt-4 pb-11 border-radius-lg">
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

    <div class="container">
        <div class="row justify-content-center">
        @livewire('faq.faq-manager')
        </div>
    </div>
@endsection
