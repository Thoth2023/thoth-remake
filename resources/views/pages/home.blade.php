@extends('layouts.app')

@section('content')
    @include('layouts.navbars.guest.navbar', ['title' => __('pages/home.home')])

    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg">
        <span class="mask bg-gradient-faded-dark opacity-5"></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center mx-auto">
                    <h1 class="text-white mb-2 mt-5">{{ __('pages/home.welcome') }}</h1>
                    <p class="text-lead text-white">{{ __('pages/home.project_description') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="mt-lg-n12 mt-md-n13 mt-n12 justify-content-center">

                <div class="card d-inline-flex p-3 mt-8">
                    <div class="card-body pt-2">
                        <a href="javascript:" class="card-title h5 d-block text-darker">
                            {{ __('pages/home.thoth') }}
                        </a>
                        <p class="card-description mb-4">
                            {{ __('pages/home.thoth_description') }}
                        </p>
                    </div>
                </div>

                <div class="card-group">
                    @foreach([
                        'questions' => 'ni ni-bullet-list-67',
                        'relevant_data' => 'ni ni-single-copy-04',
                        'quality' => 'ni ni-like-2',
                        'analyse_data' => 'ni ni-chart-bar-32',
                    ] as $key => $icon)
                        <div class="card p-3">
                            <div class="card-body pt-2">
                                <a href="javascript:" class="card-title h5 d-block text-darker">
                                    <i class="{{ $icon }}"></i> {{ __('pages/home.' . $key) }}
                                </a>
                                <p class="card-description mb-4">
                                    {{ __('pages/home.' . $key . '_description') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

@endsection

