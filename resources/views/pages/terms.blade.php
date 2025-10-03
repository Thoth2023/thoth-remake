@extends("layouts.app")

@section("content")
@guest
    @include('layouts.navbars.guest.navbar', ['title' => 'Home'])
@endguest

@auth
    @include("layouts.navbars.auth.topnav", ["title" => __("pages/terms.terms")])
@endauth

<div class="container mt-6 mb-3">

    <!-- Cabeçalho -->
    <div class="page-header d-flex flex-column pt-4 pb-11 border-radius-lg">
        <div class="row justify-content-center rounded-3 py-4 bg-gradient-faded-dark opacity-8 w-100">
            <div class="col-lg-6 text-center mx-auto">
                <h1 class="text-white">
                    {{ __("pages/terms.terms") }}
                </h1>
                {{-- <p class="text-lead text-white">{{ __("pages/terms.what") }}</p> --}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="mt-lg-n12 mt-md-n13 mt-n12 justify-content-center">
            <div class="card d-inline-flex p-3 mt-5">

                {{-- O que é o Thoth --}}
                <div class="card-body pt-2">
                    <h4 class="card-title text-darker">{{ __("pages/terms.what") }}</h4>
                    <p>
                        {{ __("pages/terms.what_text") }}
                        <a href="https://thoth-slr.com">https://thoth-slr.com</a>
                    </p>
                    <p>{{ __("pages/terms.objective") }}</p>
                    <p>{{ __("pages/terms.author") }}</p>
                </div>

                {{-- Direitos Autorais --}}
                <div class="card-body pt-2">
                    <h4 class="card-title text-darker">{{ __("pages/terms.authoral") }}</h4>
                    <p>{{ __("pages/terms.authoral_text") }}</p>
                </div>

                {{-- Quem somos --}}
                <div class="card-body pt-2">
                    <h4 class="card-title text-darker">{{ __("pages/terms.who") }}</h4>
                    <p>{{ __("pages/terms.who_text") }}</p>
                </div>

                {{-- Compromissos --}}
                <div class="card-body pt-2">
                    <h4 class="card-title text-darker">{{ __("pages/terms.commitment") }}</h4>
                    <p>{{ __("pages/terms.commitment_text") }}</p>
                    <ul>
                        @for ($i = 1; $i <= 8; $i++) <li>
                            <h6 class="card-title text-darker">
                                {{ __("pages/terms.commitment_$i") }}
                            </h6>
                            </li>
                            @endfor
                    </ul>
                </div>

                {{-- Responsabilidade --}}
                <div class="card-body pt-2">
                    <h4 class="card-title text-darker">{{ __("pages/terms.responsability") }}</h4>
                    <p>{{ __("pages/terms.responsability_text") }}</p>
                </div>

                {{-- Privacidade --}}
                <div class="card-body pt-2">
                    <h4 class="card-title text-darker">{{ __("pages/terms.privacy") }}</h4>
                    <p>{!! __("pages/terms.privacy_text") !!}</p>
                </div>

                {{-- Exclusão de dados pelo usuário --}}
                <div class="card-body pt-2">
                    <h4 class="card-title text-darker">{{ __("pages/terms.delete_data") }}</h4>
                    <p>{!! __("pages/terms.delete_data_text") !!}</p>
                </div>

                {{-- Exclusão automática de dados --}}
                <div class="card-body pt-2">
                    <h4 class="card-title text-darker">{{ __("pages/terms.exclusion_data") }}</h4>
                    <p>{!! __("pages/terms.exclusion_data_text") !!}</p>
                </div>

                {{-- Segurança dos dados --}}
                <div class="card-body pt-2">
                    <h4 class="card-title text-darker">{{ __("pages/terms.security_data") }}</h4>
                    <p>{!! __("pages/terms.security_data_text") !!}</p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
