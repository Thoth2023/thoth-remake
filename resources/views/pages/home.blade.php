@extends('layouts.app')

@section('content')
    @include('layouts.navbars.guest.navbar', ['title' => 'Home'])

    <div class="row mt-2 mx-2">
        <div class="col-12">
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
        Questions
      </a>
      <p class="card-description mb-4">
        Defining a question and agreeing an objective method.
      </p>
    </div>
  </div>
  <div class="card p-3">
    <div class="card-body pt-2">
      <a href="javascript:" class="card-title h5 d-block text-darker">
        Relevant data
      </a>
      <p class="card-description mb-4">
        A search for relevant data from research that matches certain criteria. For example, only selecting research that is good quality and answers the defined question.
      </p>
    </div>
  </div>
  <div class="card p-3">
    <div class="card-body pt-2">
      <a href="javascript:" class="card-title h5 d-block text-darker">
        Quality
      </a>
      <p class="card-description mb-4">
        Assess the quality of the data by judging it against criteria identified at the first stage.
      </p>
    </div>
  </div>
  <div class="card p-3">
    <div class="card-body pt-2">
      <a href="javascript:" class="card-title h5 d-block text-darker">
        Analyse the data
      </a>
      <p class="card-description mb-4">
      Analyse and combine the data (using complex statistical methods) which give an overall result from all of the data. Once these stages are complete, the review may be published, disseminated and translated into practice after being adopted as evidence.
      </p>
    </div>
  </div>
</div>
        </div></div>

@endsection
