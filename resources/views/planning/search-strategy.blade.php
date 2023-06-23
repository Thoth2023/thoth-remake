@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Search Strategy'])

<div class="row mt-4 mx-4">
   <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>
                {{ $project->title }}
                </h4>
            </div>
            <div class="card-body">
            <div class="nav-wrapper position-relative end-0">
            <ul class="nav nav-pills nav-fill p-1">
                <li class="nav-item">
                    <a class="btn bg-gradient-faded-white mb-0" href="{{ route('projects.show', $project->id_project) }}">
                        <i class="fas fa-plus"></i>Overview</a>
                </li>
                <li class="nav-item">
                    <a class="btn bg-gradient-dark mb-0" href="{{ route('planning.index', $project->id_project) }}">
                        <i class="fas fa-plus"></i>Planning</a>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn bg-gradient-default">Conducting</button>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn bg-gradient-default">Reporting</button>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn bg-gradient-default">Export</button>
                </li>
            </ul>
        </div>
        </div>
    </div>
</div>

<div class="container-fluid py-4">
<div class="card shadow-lg mx-4">
    <div class="container-fluid py-4">
    <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Planning</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                    <div class="nav-wrapper position-relative end-0">
                    <ul class="nav nav-pills nav-fill p-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 active" href="{{ route('planning.index', $project->id_project) }}" aria-controls="Overallinformation">
                                Overall information
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" href="{{ route('planning.research_questions', $project->id_project) }}" aria-controls="ResearchQuestions">
                                Research Questions
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" href="{{ route('planning.databases', $project->id_project) }}" aria-controls="Databases">
                                Data Bases
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" href="#SearchString" aria-controls="SearchString">
                                Search String
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" href="{{ route('search-strategy.edit', $project->id_project) }}" aria-controls="SearchStrategy" style="background-color: #212229; color: white;">
                                Search Strategy
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" href="{{ route('planning.criteria', $project->id_project) }}" aria-controls="Criteria">
                                Criteria
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" href="#QualityAssessment" aria-controls="QualityAssessment">
                                Quality Assessment
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" href="{{ route('planning.dataExtraction', $project->id_project) }}" role="tab" aria-controls="DataExtraction">
                                Data Extraction
                                </a>
                            </li>
                        </ul>
                    </div>
                    </div>
        <div class="d-flex justify-content-between">
            <p class="text-uppercase text-sm">Search Strategy</p>
            <a class="btn btn-secondary" data-bs-toggle="collapse" href="#collapseHelp" role="button" aria-expanded="false" aria-controls="collapseHelp">
                <i class="fas fa-question-circle"></i> Help
            </a>
        </div>
        <div class="collapse" id="collapseHelp">
            <div class="card card-body mb-4 p-3">
                <div class="modal-body">
                    <p>In the planning phase, it is necessary to determine and follow a search strategy. This should be developed in consultation with librarians or others with relevant experience. Search strategies are usually iterative and benefit from:</p>
                    <ul>
                        <li>Conducting preliminary searches aimed at both identifying existing systematic reviews and assessing the volume of potentially relevant studies.</li>
                        <li>Performing trial searches using various combinations of search terms derived from the research question.</li>
                        <li>Cross-checking the trial research string against lists of already known primary studies.</li>
                        <li>Seeking consultations with experts in the field.</li>
                    </ul>
                    <p>Describe here the strategy that will be used in your research.</p>
                </div>
            </div>
        </div>
        @if(session()->has('message'))
        <div class="alert alert-{{ session('message_type') }} alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <form method="POST" action="{{ route('search-strategy.update', ['projectId' => $project->id_project]) }}">
            @csrf
            @method('post')
            <div class="form-group">
                <label for="searchStrategyTextarea">Search Strategy</label>
                <textarea name="search_strategy" class="form-control @error('search_strategy') is-invalid @enderror" id="searchStrategyTextarea" rows="8" placeholder="Enter the search strategy">{{ $project->searchStrategy->description ?? old('search_strategy') }}</textarea>

                @error('search_strategy')
                <span class="invalid-feedback" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="d-flex align-items-center mt-4">
                <button type="submit" class="btn btn-primary btn-sm ms-auto">
                    Save
                </button>
            </div>
        </form>

        @include('layouts.footers.auth.footer')
    </div>
</div>
</div>
@endsection
