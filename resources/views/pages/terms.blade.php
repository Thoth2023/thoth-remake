@extends("layouts.app")

@section("content")
@include("layouts.navbars.guest.navbar", ["title" => "Home"])

<div class="container mt-8 mb-3">
    <div class="page-header d-flex flex-column pt-4 pb-11 border-radius-lg">
        <div class="row justify-content-center rounded-3 py-4 bg-gradient-faded-dark opacity-8" style=" width: 100%">
            <div class="col-lg-6 text-center mx-auto">
                <h1 class="text-white">
                    {{ __("pages/terms.terms") }}
                </h1>
                <p class="text-lead text-white">
                    <!-- {{ __("pages/terms.what") }} -->
                </p>
            </div>
        </div>
    </div>
	<!-- Displays various sections of the terms using cards. Each section includes a title and a description. -->
    <div class="row">
        <div class="mt-lg-n12 mt-md-n13 mt-n12 justify-content-center">
            <div class="card d-inline-flex p-3 mt-5">
                <div class="card-body pt-2">
                    <a href="#" onclick="event.preventDefault();" class="card-title h4 d-block text-darker" style="cursor: default; transition: color 0.2s;">
                        {{ __("pages/terms.what") }}
                    </a>
                    <p>
                        {{ __("pages/terms.what_text") }}
                        <a href="https://thoth-rsl.com">https://thoth-rsl.com</a>
                    </p>

                    <p>{{ __("pages/terms.objective") }}</p>
                    <p>{{ __("pages/terms.author") }}</p>
                </div>
                <div class="card-body pt-2">
                <a href="#" onclick="event.preventDefault();" class="card-title h4 d-block text-darker" style="cursor: default; transition: color 0.2s;">
                        {{ __("pages/terms.authoral") }}
                    </a>
                    <p>{{ __("pages/terms.authoral_text") }}</p>
                </div>
                <div class="card-body pt-2">
                    <a href="#" onclick="event.preventDefault();" class="card-title h4 d-block text-darker" style="cursor: default; transition: color 0.2s;">
                        {{ __("pages/terms.who") }}
                    </a>
                    <p>{{ __("pages/terms.who_text") }}</p>
                </div>
                <div class="card-body pt-2">
                    <a href="#" onclick="event.preventDefault();" class="card-title h4 d-block text-darker" style="cursor: default; transition: color 0.2s;">
                        {{ __("pages/terms.commitment") }}
                    </a>
                    <p>{{ __("pages/terms.commitment_text") }}</p>
                    <ul>
                        <li>
                            <a class="card-title h6 d-block text-darker">
                                {{ __("pages/terms.commitment_1") }}
                            </a>
                        </li>
                        <li>
                            <a class="card-title h6 d-block text-darker">
                                {{ __("pages/terms.commitment_2") }}
                            </a>
                        </li>
                        <li>
                            <a class="card-title
                            h6 d-block text-darker">
                                {{ __("pages/terms.commitment_3") }}
                            </a>
                        </li>
                        <li>
                            <a class="card-title h6 d-block text-darker">
                                {{ __("pages/terms.commitment_4") }}
                            </a>
                        </li>
                        <li>
                            <a class="card-title h6 d-block text-darker">
                                {{ __("pages/terms.commitment_5") }}
                            </a>
                        </li>
                        <li>
                            <a class="card-title h6 d-block text-darker">
                                {{ __("pages/terms.commitment_6") }}
                            </a>
                        </li>
                        <li>
                            <a class="card-title h6 d-block text-darker">
                                {{ __("pages/terms.commitment_7") }}
                            </a>
                        </li>
                        <li>
                            <a class="card-title h6 d-block text-darker">
                                {{ __("pages/terms.commitment_8") }}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body pt-2">
                    <a href="#" onclick="event.preventDefault();" class="card-title h4 d-block text-darker" style="cursor: default; transition: color 0.2s;">
                        {{ __("pages/terms.responsability") }}
                    </a>
                    <p>{{ __("pages/terms.responsability_text") }}</p>
                </div>
                <div class="card-body pt-2">
                    <a href="#" onclick="event.preventDefault();" class="card-title h4 d-block text-darker" style="cursor: default; transition: color 0.2s;">
                        {{ __("pages/terms.privacy") }}
                    </a>
                    <p>{!!  __("pages/terms.privacy_text") !!}</p>
                </div>

                <div class="card-body pt-2">
                    <a href="#" onclick="event.preventDefault();" class="card-title h4 d-block text-darker" style="cursor: default; transition: color 0.2s;">
                        {{ __("pages/terms.delete_data") }}
                    </a>
                    <p>{!!  __("pages/terms.delete_data_text")  !!}</p>
                </div>
                <div class="card-body pt-2">
                    <a href="#" onclick="event.preventDefault();" class="card-title h4 d-block text-darker" style="cursor: default; transition: color 0.2s;">
                        {{ __("pages/terms.exclusion_data") }}
                    </a>
                    <p>{!!  __("pages/terms.exclusion_data_text")  !!}</p>
                </div>
                <div class="card-body pt-2">
                    <a href="#" onclick="event.preventDefault();" class="card-title h4 d-block text-darker" style="cursor: default; transition: color 0.2s;">
                        {{ __("pages/terms.security_data") }}
                    </a>
                    <p>{!!  __("pages/terms.security_data_text")  !!}</p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
