@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Planning Overall Information'])
@include('planning.convert-database')

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
                                <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#Overallinformation" role="tab" aria-controls="Overallinformation " aria-selected="false">
                                Overall information
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#ResearchQuestions" role="tab" aria-controls="ResearchQuestions" aria-selected="false">
                                Research Questions
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#Databases" role="tab" aria-controls="Databases" aria-selected="false">
                                Data Bases
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#SearchString" role="tab" aria-controls="SearchString" aria-selected="false">
                                Search String
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#SearchStrategy" role="tab" aria-controls="SearchStrategy" aria-selected="false">
                                Search Strategy
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#Criteria" role="tab" aria-controls="Criteria" aria-selected="false">
                                Criteria
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#QualityAssessment" role="tab" aria-controls="QualityAssessment" aria-selected="false">
                                Quality Assessment
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#DataExtraction" role="tab" aria-controls="DataExtraction" aria-selected="false">
                                Data Extraction
                                </a>
                            </li>
                        </ul>
                    </div>
                    </div>
                    <div class="row" style="justify-content: space-around;">

                        <!-- Database starts here -->
                        <div class="col-md-6 unique-form-planning">
                            <div class="card">
                                <form role="form" method="POST" action={{ route('planning_overall.databaseAdd') }} enctype="multipart/form-data">
                                    @csrf
                                    <div>
                                        <div class="card-header pb-0">
                                            <div class="d-flex align-items-center">
                                                <p class="mb-0">Databases</p>
                                                <button type="button" class="help-thoth-button" data-bs-toggle="modal" data-bs-target="#DatabaseModal">
                                                    ?
                                                </button>
                                                <!-- Help Button Description -->
                                                <div class="modal fade" id="DatabaseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Help for Data Bases</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ...
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Help Description Ends Here -->
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select class="form-control" name="id_database">
                                                        @forelse ($databases as $database)
                                                            <option value="{{ $database->id_database }}">{{ $database->name }}</option>
                                                        @empty
                                                        <option>No data bases in database.</option>
                                                        @endforelse
                                                        </select>
                                                        <input clas="form-control" type="hidden" name="id_project" value="{{ $id_project }}">

                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm ms-auto">Add</button>
                                                </div>
                                                </form>
                                                <div class="table-responsive p-0">
                                                    <table class="table align-items-center justify-content-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                    Data Bases
                                                                </th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($projectDatabases as $projectDatabase)
                                                            <tr>
                                                                <td>
                                                                    <p class="text-sm font-weight-bold mb-0"><?=convert_databases_name($projectDatabase->id_database)?></p>
                                                                </td>
                                                                <td class="align-middle">
                                                                    <form action="{{ route('planning_overall.databaseDestroy', $projectDatabase->id_database) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button style="border:0; background: none; padding: 0px;" type="submit" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete Database">Delete</button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td colspan="5" class="text-center">No databases found.</td>
                                                            </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <hr class="horizontal dark">
                                        </div>
                                </div>
                            </div>
                        </div>
                        <!-- Database ends here -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footers.auth.footer')
</div>
@endsection
