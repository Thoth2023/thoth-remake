@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Planning Data Bases'])

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
                                    <a class="nav-link mb-0 px-0 py-1" href="{{ route('planning.index', $project->id_project) }}" aria-controls="Overallinformation">
                                    Overall information
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" href="{{ route('planning.research_questions', $project->id_project) }}" aria-controls="ResearchQuestions">
                                    Research Questions
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1 active" href="{{ route('planning.databases', $project->id_project) }}" aria-controls="Databases">
                                    Data Bases
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" href="#SearchString" aria-controls="SearchString">
                                    Search String
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="{{ route('search-strategy.edit', ['projectId' => $project->id_project]) }}" role="tab" aria-controls="SearchStrategy" aria-selected="false">
                                    Search Strategy
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" href="#Criteria" aria-controls="Criteria">
                                    Criteria
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" href="#QualityAssessment" aria-controls="QualityAssessment">
                                    Quality Assessment
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" href="#DataExtraction" role="tab" aria-controls="DataExtraction" style="background-color: #212229; color: white;">
                                    Data Extraction
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card bg-secondary-overview">
                            <div class="card-body">
                                <div class="card-group card-frame mt-5">
                                    <!-- create data extraction -->
                                    <div class="card">
                                        <div class="card-body">
                                            <form role="form" method="POST" action="{{ route('planning.dataExtractionCreate', $project->id_project) }}" enctype="multipart/form-data">
                                                @csrf
                                                <label class="form-control-label" for="id">ID</label>
                                                <input class="form-control" id="id" type="text" name="id">
                                                <label class="form-control-label" for="description">Description</label>
                                                <input class="form-control" id="description" type="text" name="description">
                                                <label class="form-control-label" for="type">Type</label>
                                                <select class="form-control" name="type" id="type" placeholder="Departure">
                                                    <option value="" selected=""></option>
                                                    @foreach($types as $type)
                                                        <option value="{{ $type->id_type }}">{{ $type->type }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="sumbit" class="btn btn-success mt-3">Add Question</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <form role="form" method="POST" action="{{ route('planning.dataExtractionOptionCreate', $project->id_project) }}" enctype="multipart/form-data">
                                                @csrf
                                                <label class="form-control-label" for="question-id">Question</label>
                                                <select class="form-control" name="questionId" id="question-id" placeholder="Departure">
                                                    <option value="" selected=""></option>
                                                    @foreach($project->questionExtractions as $question)
                                                        @if ($question->question_type->type == "Multiple Choice List" || $question->question_type->type == "PickOneList")
                                                            <option value="{{ $question->id_de }}">{{ $question->id }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <label class="form-control-label" for="option">Option</label>
                                                <input class="form-control" id="option" type="text" name="option">
                                                <button type="sumbit" class="btn btn-success mt-3">Add option</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-3 p-4">
                                    <ul class="list-group">
                                            <li class="list-group-item m-1">
                                                <div class="row">
                                                    <div class="col-1">
                                                        <b>ID</b>
                                                    </div>
                                                    <div class="col">
                                                        <b>Description</b>
                                                    </div>
                                                    <div class="col">
                                                        <b>Question Type</b>
                                                    </div>
                                                    <div class="col-5">
                                                        <b>Options</b>
                                                    </div>
                                                    <div class="col-md-auto">
                                                        <b>Actions</b>
                                                    </div>
                                                </div>
                                            </li>
                                            @foreach($project->questionExtractions as $question)
                                                <li class="list-group-item m-1">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <span>{{ $question->id }}</span>
                                                        </div>
                                                        <div class="col">
                                                            <span>{{ $question->description }}</span>
                                                        </div>
                                                        <div class="col">
                                                            <span>{{ $question->question_type->type }}</span>
                                                        </div>
                                                        <div class="col-5">
                                                            <ul class="list-group">
                                                                @foreach($question->options as $option)
                                                                    <li class="list-group-item m-1">
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <span>{{ $option->description }}</span>
                                                                            </div>
                                                                            <div class="col-md-auto d-flex">
                                                                                <form class="m-1">
                                                                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>
                                                                                </form>
                                                                                <form class="m-1" role="form" method="POST" action="{{ route('planning.dataExtractionDeleteOption', [$project->id_project, $option->id_option]) }}">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-auto d-flex">
                                                            <form class="m-1" role="form" method="POST" action="{{ route('planning.dataExtractionUpdateQuestion', [$project->id_project, $question->id_de]) }}" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>
                                                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Edit Question</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <label class="form-control-label" for="id">ID</label>
                                                                                <input class="form-control" id="id" value="{{ $question->id }}">
                                                                                <label class="form-control-label" for="description">Description</label>
                                                                                <input class="form-control" id="description" value="{{ $question->description }}">
                                                                                <label class="form-control-lavel" for="type">Type</label>
                                                                                <select class="form-control" name="type" id="type" placeholder="Departure">
                                                                                    <option value="" selected=""></option>
                                                                                    @foreach($types as $type)
                                                                                        <option value="{{ $type->id_type }}">{{ $type->type }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn bg-gradient-primary">Save changes</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <form class="m-1" role="form" method="POST" action="{{ route('planning.dataExtractionDeleteQuestion', [$project->id_project, $question->id_de]) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footers.auth.footer')
</div>
@endsection

