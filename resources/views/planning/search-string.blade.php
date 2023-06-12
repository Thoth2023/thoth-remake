@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Planning Data Bases'])
<style>#h5Search{display: inline;}</style>
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
                                    <a class="nav-link mb-0 px-0 py-1" href="#SearchString" aria-controls="SearchString" style="background-color: #212229; color: white;">
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
                                    <a class="nav-link mb-0 px-0 py-1" role="tab" href="{{ route('planning.dataExtraction', $project->id_project) }}" aria-controls="DataExtraction">
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
                                    <!-- database selector -->
                                    <div class="card">
                                        <!-- Help Start -->
                                            <div class="card-header">
                                                <h5 id="h5Search" >Search String</h5>
                                                <button type="button" class="bg-gradient-warning mb-3 help-thoth-button" data-bs-toggle="modal" data-bs-target="#modal-notification-3">?</button>
                                                <div class="modal fade" id="modal-notification-3" tabindex="-1" role="dialog" aria-labelledby="modal-notification-3" aria-hidden="true">
                                                <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title" id="modal-title-notification-3">Instruction help for register a Search String</h6>
                                                        <button type="button" class="btn btn-danger small-button" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">x</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="py-3 text-center">
                                                        <h4 class="text-gradient text-danger mt-4"><i class="ni ni-single-copy-04"></i> Enter a Term and Select it!</h4>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Ok, Got it</button>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        <!-- End Help -->
                                        
                                        <div class="card-body">
                                            <form role="form" method="POST" action="{{ route('planning.databasesAdd', $project->id_project) }}" enctype="multipart/form-data" style="display: flex;">
                                                @csrf
                                                {{-- <select name="database" class="form-control form-select form-select-lg mb-3" aria-label=".form-select-lg example" placeholder="Departure" id="choices-button">
                                                    <option value=""></option>
                                                        @foreach($databases as $database) 
                                                            <option value="{{ $database->id_database }}">{{ $database->name }}</option> 
                                                        @endforeach 
                                                </select>
                                                <button type="submit" class="btn btn-success">Add</button> --}}

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="example-text-input" class="form-control-label">Term</label>
                                                            <input class="form-control" type="text" name="description">
                                                            <input class="form-control" type="hidden" name="id_project" value="">

                                                        </div>
                                                        <button type="submit" class="btn btn-primary btn-sm ms-auto">Add</button>
                                                    </div>

                                            </form>
                                            <ul class="list-group">
                                            @foreach($project->databases as $database)
                                                <li class="list-group-item">
                                                    <form role="form" 
                                                    method="POST" action="{{ route('planning.databasesRemove', [$project->id_project, $database->id_database]) }}" 
                                                    style="display: flex; align-items: center">
                                                    @csrf
                                                        <span>{{ $database->name }}</span>
                                                        <span style="flex: 1 1 0"></span>
                                                        <button type="submit" class="btn bg-gradient-danger" style="margin-left: 30px;">Remove</button>
                                                    </form>
                                                </li>
                                            @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Add New Data Base</h5>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" method="POST" action="{{ route('planning.databasesCreate', $project->id_project) }}" enctype="multipart/form-data">
                                                @csrf
                                                <label class="form-control-label" for="db-name">Name</label>
                                                <input class="form-control" name="name" type="text" id="db-name">
                                                <label class="form-control-label" for="db-link">Link</label>
                                                <input class="form-control" name="link" type="text" id="db-link">
                                                <button type="sumbit" class="btn btn-success mt-3">Add Data Base</button>
                                            </form>
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
</div>
@include('layouts.footers.auth.footer')
</div>
@endsection
