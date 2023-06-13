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
                                    <a class="nav-link mb-0 px-0 py-1" href="#QualityAssessment" aria-controls="QualityAssessment" style="background-color: #212229; color: white;">
                                    Quality Assessment
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" href="#DataExtraction" role="tab" href="{{ route('planning.dataExtraction', $project->id_project) }}" aria-controls="DataExtraction">
                                    Data Extraction
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card bg-secondary-overview">
                            <div class="card-header bg-secondary-overview">
                                <h4>Quality Assessment</h4>
                            </div>
                            <div class="card-body">
                                <div class="card-group card-frame">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>General Score</h5>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" method="POST" action="{{ route('planning.createGeneralScoreInterval', $project->id_project) }}" enctype="multipart/form-data">
                                                @csrf
                                                <label class="form-control-label">Intervals</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" name="start" min="0" step="0.1" placeholder="Start Score Interval" aria-label="Start Score Interval Input" aria-describedby="button-addon4">
                                                    <input type="number" class="form-control" name="end" min="0" step="0.1" placeholder="End Score Interval" aria-label="End Score Interval Input" aria-describedby="button-addon4">
                                                </div>
                                                <label class="form-control-label" for="gs-description">General Score Description</label>
                                                <input class="form-control" type="text" id="gs-description" name="gs_description">
                                                <button class="btn btn-success mt-3" type="submit">Add</button>
                                            </form>
                                            <form role="form" method ="POST" action="{{ route('planning.setMinToApp', $project->id_project) }}" enctype="multipart/form-data">
                                                @csrf
                                                <label class="form-control-label" for="minimum">Minimum General Score to Approve</label>
                                                <select class="form-control" name="minimum" id="minimum" placeholder="Departure">
                                                    <option value="" selected=""></option>
                                                    @foreach($project->generalScores as $generalScore)
                                                        <option value="{{ $generalScore->id_general_score }}">{{ $generalScore->description }}</option>
                                                    @endforeach
                                                </select>
                                                <button class="btn btn-success mt-3" type="submit">Change</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card"></div>
                                </div>
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5>List of General Scores</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <li class="list-group-item m-1">
                                                <div class="row">
                                                    <div class="col">
                                                        <b>Start Score Interval</b>
                                                    </div>
                                                    <div class="col">
                                                        <b>End Score Interval</b>
                                                    </div>
                                                    <div class="col">
                                                        <b>Score Description</b>
                                                    </div>
                                                    <div class="col-md-auto d-flex">
                                                        <b>Actions</b>
                                                    </div>
                                                </div>
                                            </li>
                                            @foreach($project->generalScores as $generalScore)
                                                <li class="list-group-item m-1">
                                                    <div class="row">
                                                        <div class="col">
                                                            <span>{{ $generalScore->start }}</span>
                                                        </div>
                                                        <div class="col">
                                                            <span>{{ $generalScore->end }}</span>
                                                        </div>
                                                        <div class="col">
                                                            <span>{{ $generalScore->description }}</span>
                                                        </div>
                                                        <div class="col-md-auto d-flex">
                                                            <form class="m-1" role="form" action="{{ route('planning.editGeneralScoreInterval', [$project->id_project, $generalScore->id_general_score]) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#generalScoreModal">Edit</button>
                                                                <div class="modal fade" id="generalScoreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Edit Score Interval</h5>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <label class="form-control-label">Intervals</label>
                                                                                <div class="input-group">
                                                                                    <input type="number" value="{{ $generalScore->start }}" class="form-control" name="start" min="0" step="0.1" placeholder="Start Score Interval" aria-label="Start Score Interval Input" aria-describedby="button-addon4">
                                                                                    <input type="number" value="{{ $generalScore->end }}" class="form-control" name="end" min="0" step="0.1" placeholder="End Score Interval" aria-label="End Score Interval Input" aria-describedby="button-addon4">
                                                                                </div>
                                                                                <label class="form-control-label" for="gs-description">General Score Description</label>
                                                                                <input class="form-control" type="text" id="gs-description" value="{{ $generalScore->description }}" name="gs_description">
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn bg-gradient-primary">Save changes</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <form class="m-1" role="form" method="POST">
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
                                <div class="card-group card-frame mt-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Question Quality</h5>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" method ="POST" enctype="multipart/form-data">
                                                <label class="form-control-label" for="id">ID</label>
                                                <input class="form-control" id="id" type="text" name="id">
                                                <label class="form-control-label" for="description">Description</label>
                                                <input class="form-control" id="description" type="text" name="description">
                                                <label class="form-control-label" for="weight">Weight</label>
                                                <input class="form-control" id="weight" type="number" name="weight">
                                                <button class="btn btn-success mt-3" type="submit">Add</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Question Score</h5>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" method ="POST" enctype="multipart/form-data">
                                                <label class="form-control-label" for="question">Question</label>
                                                <select class="form-control" name="question" id="question" placeholder="Departure">
                                                    <option value="" selected=""></option>
                                                    @foreach($project->questionQualities as $questionQuality)
                                                        <option value="{{ $questionQuality->id_qa}}">{{ $questionQuality->id }}</option>
                                                    @endforeach
                                                </select>
                                                <label class="form-control-label" for="score-rule">Score rule</label>
                                                <input class="form-control" id="score-rule" type="text" name="scoreRule">
                                                <label class="form-control-label" for="score">Score</label>
                                                <input class="form-control" id="score" type="range" name="score">
                                                <label class="form-control-label" for="qs-description">Description</label>
                                                <input class="form-control" id="qs-description" type="text" name="description">
                                                <button class="btn btn-success mt-3">Create</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5>Question Quality List</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <li class="list-group-item m-1">
                                                <div class="row">
                                                    <div class="col">
                                                        <b>ID</b>
                                                    </div>
                                                    <div class="col">
                                                        <b>Description</b>
                                                    </div>
                                                    <div class="col">
                                                        <b>Score Rules</b>
                                                    </div>
                                                    <div class="col-md-auto d-flex">
                                                        <b>Weight</b>
                                                    </div>
                                                    <div class="col-md-auto d-flex">
                                                        <b>Minimum to Approve</b>
                                                    </div>
                                                    <div class="col-md-auto d-flex">
                                                        <b>Actions</b>
                                                    </div>
                                                </div>
                                            </li>
                                            @foreach($project->questionQualities as $questionQuality)
                                                <li class="list-group-item m-1">
                                                    <div class="row">
                                                        <div class="col">
                                                            <span>{{ $questionQuality->id }}</span>
                                                        </div>
                                                        <div class="col">
                                                            <span>{{ $questionQuality->description }}</span>
                                                        </div>
                                                        <div class="col">
                                                            <ul class="list-group">
                                                                @foreach($questionQuality->scoreQualities as $scoreQuality)
                                                                    <li class="list-group-item m-1">
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <span></span>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-auto d-flex">
                                                            <form class="m-1" role="form" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#generalScoreModal">Edit</button>
                                                                <div class="modal fade" id="generalScoreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Edit Score Interval</h5>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <label class="form-control-label">Intervals</label>
                                                                                <div class="input-group">
                                                                                    <input type="number" class="form-control" placeholder="Start Score Interval" aria-label="Start Score Interval Input" aria-describedby="button-addon4">
                                                                                    <input type="number" class="form-control" placeholder="End Score Interval" aria-label="End Score Interval Input" aria-describedby="button-addon4">
                                                                                </div>
                                                                                <label class="form-control-label" for="gs-description">General Score Description</label>
                                                                                <input class="form-control" type="text" id="gs-description" name="gs_description">
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn bg-gradient-primary">Save changes</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <form class="m-1" role="form" method="POST">
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
</div>
@include('layouts.footers.auth.footer')
</div>
@endsection

