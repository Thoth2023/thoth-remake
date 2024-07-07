@extends('layouts.app')

@section('content')
    @include('layouts.navbars.guest.navbar', ['title' => 'Help'])
    <div class="container mt-8 mb-3">
        <div class="page-header d-flex flex-column pt-4 pb-9 border-radius-lg">
            <div
                class="row justify-content-center rounded-3 py-4 bg-gradient-faded-dark opacity-8 "
                style="width: 100%"
            >
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
                <div class="card d-inline-flex p-3 mt-8 mb-5">
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
                             @foreach ($faqs as $faq)
                                <div class="accordion-item{{$faq->id}}">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
                                            <a href="javascript:" class="card-title h5 d-block text-darker">
                                            {{ $faq->question }}
                                            </a>
                                        </button>
                                    </h2>
                                    <div id="collapse{{$faq->id}}" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                        {{ $faq->response }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
