@extends('layouts.app')

@section('content')
    @include('layouts.navbars.guest.navbar', ['title' => 'Home'])
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
         style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signup-cover.jpg'); background-position: top;">
        <span class="mask bg-gradient-faded-warning opacity-5"></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center mx-auto">
                    <h1 class="text-white mb-2 mt-5">Welcome!</h1>
                    <p class="text-lead text-white">Use these awesome forms to login or create new account in your
                        project for free.</p>
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
            Thoth
            </a>
            <p class="card-description mb-4">
            Systematic reviews are a type of literature review that uses systematic methods to collect secondary data, critically appraise research studies, and synthesize studies. Systematic reviews formulate research questions that are broad or narrow in scope, and identify and synthesize studies that directly relate to the systematic review question.hey are designed to provide a complete, exhaustive summary of current evidence relevant to a research question. Systematic reviews of randomized controlled trials are key to the practice of evidence-based medicine, and a review of existing studies is often quicker and cheaper than embarking on a new study.
            </p>
        </div>
    </div>
    <div class="card-group ">
  <div class="card p-3">
    <div class="card-body pt-2">
      <a href="javascript:" class="card-title h5 d-block text-darker">
          <i class="ni ni-bullet-list-67"></i> Questions
      </a>
      <p class="card-description mb-4">
        Defining a question and agreeing an objective method.
      </p>
    </div>
  </div>
  <div class="card p-3">
    <div class="card-body pt-2">
      <a href="javascript:" class="card-title h5 d-block text-darker">
          <i class="ni ni-single-copy-04"></i> Relevant data
      </a>
      <p class="card-description mb-4">
        A search for relevant data from research that matches certain criteria. For example, only selecting research that is good quality and answers the defined question.
      </p>
    </div>
  </div>
  <div class="card p-3">
    <div class="card-body pt-2">
      <a href="javascript:" class="card-title h5 d-block text-darker">
          <i class="ni ni-like-2"> </i> Quality
      </a>
      <p class="card-description mb-4">ni ni-chart-bar-32
        Assess the quality of the data by judging it against criteria identified at the first stage.
      </p>
    </div>
  </div>
  <div class="card p-3">
    <div class="card-body pt-2">
      <a href="javascript:" class="card-title h5 d-block text-darker">
          <i class="ni ni-chart-bar-32"> </i> Analyse the data
      </a>
      <p class="card-description mb-4">
      Analyse and combine the data (using complex statistical methods) which give an overall result from all of the data. Once these stages are complete, the review may be published, disseminated and translated into practice after being adopted as evidence.
      </p>
    </div>
  </div>
</div>

        </div>   </div></div>

@endsection
