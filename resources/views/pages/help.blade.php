@extends('layouts.app')

@section('content')
@include('layouts.navbars.guest.navbar', ['title' => 'Help'])
<div class="container mt-8 mb-3">
    <div class="page-header d-flex flex-column pt-4 pb-9 border-radius-lg">
        <div class="row justify-content-center rounded-3 py-4 bg-gradient-faded-dark opacity-8 " style="width: 100%">
            <div class="col-lg-6 text-center mx-auto">
                <h1 class="text-white">FAQ</h1>
                <p class="text-lead text-white">
                    {{ __('pages/help.10_questions') }}
                </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="mt-lg-n12 mt-md-n13 mt-n12 justify-content-center">
            <div class="card p-3 mt-8 mb-5">
                <div class="card-body pt-2">
                    <a href="javascript:;" class="card-title h4 d-block text-darker">
                        Thoth 2.0
                    </a>
                    <div class="card-body pt-2">
                        <a href="javascript:" class="card-title h4 d-block text-darker">
                            {{ __('pages/help.common_questions') }}
                        </a>
                    </div>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <a href="javascript:" class="card-title h5 d-block text-darker">
                                        {{ __('pages/help.question1') }}
                                    </a>
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ __('pages/help.answer1') }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <a href="javascript:" class="card-title h5 d-block text-darker">
                                        {{ __('pages/help.question2') }}
                                    </a>
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ __('pages/help.answer2') }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <a href="javascript:" class="card-title h5 d-block text-darker">
                                        {{ __('pages/help.question3') }}
                                    </a>
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ __('pages/help.answer3') }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <a href="javascript:" class="card-title h5 d-block text-darker">
                                        {{ __('pages/help.question4') }}
                                    </a>
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ __('pages/help.answer4') }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    <a href="javascript:" class="card-title h5 d-block text-darker">
                                        {{ __('pages/help.question5') }}
                                    </a>
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ __('pages/help.answer5') }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    <a href="javascript:" class="card-title h5 d-block text-darker">
                                        {{ __('pages/help.question6') }}
                                    </a>
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ __('pages/help.answer6') }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                    <a href="javascript:" class="card-title h5 d-block text-darker">
                                        {{ __('pages/help.question7') }}
                                    </a>
                                </button>
                            </h2>
                            <div id="collapseSeven" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ __('pages/help.answer7') }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                    <a href="javascript:" class="card-title h5 d-block text-darker">
                                        {{ __('pages/help.question8') }}
                                    </a>
                                </button>
                            </h2>
                            <div id="collapseEight" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ __('pages/help.answer8') }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                    <a href="javascript:" class="card-title h5 d-block text-darker">
                                        {{ __('pages/help.question9') }}
                                    </a>
                                </button>
                            </h2>
                            <div id="collapseNine" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ __('pages/help.answer9') }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                    <a href="javascript:" class="card-title h5 d-block text-darker">
                                        {{ __('pages/help.question10') }}
                                    </a>
                                </button>
                            </h2>
                            <div id="collapseTen" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ __('pages/help.answer10') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection