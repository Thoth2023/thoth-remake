@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Planning Overall Information'])
@include('planning.convert-language-name')
@include('planning.convert-study-type-name')
@include('planning.convert-database')

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
                    <ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" id="overall-info-tab" data-bs-toggle="tab" href="#overall-info">Overall Information</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="research-questions-tab" data-bs-toggle="tab" href="#research-questions">Research Questions</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="data-bases-tab" data-bs-toggle="tab" href="#data-bases">Data Bases</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="search-string-tab" data-bs-toggle="tab" href="#search-string">Search String</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="search-strategy-tab" data-bs-toggle="tab" href="#search-_strategy">Search Strategy</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="criteria-tab" data-bs-toggle="tab" href="#criteria">Criteria</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="quality-assessment-tab" data-bs-toggle="tab" href="#quality-assessment">Quality Assessment</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="data-extraction-tab" data-bs-toggle="tab" href="#data-extraction">Data Extraction</a>
  </li>

  <!-- Add the rest of the tabs in a similar manner -->
</ul>
</div>

<div class="tab-content">
    <div class="tab-pane fade show active" id="overall-info">
        <div class="row" style="justify-content: space-around;">
                        <!-- Domain starts here -->
                        <div class="col-md-6 unique-form-planning">
                            <div class="card">
                                <form role="form" method="POST" action="{{ route('planning_overall.domainUpdate') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div>
                                        <div class="card-header pb-0">
                                            <div class="d-flex align-items-center">
                                                <p class="mb-0">Domains</p>
                                                <button type="button" class="help-thoth-button" data-bs-toggle="modal" data-bs-target="#DomainModal">
                                                    ?
                                                </button>
                                                <!-- Help Button Description -->
                                                <div class="modal fade" id="DomainModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Help for Domains</h5>
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
                                                        <label for="example-text-input" class="form-control-label">Description</label>
                                                        <input class="form-control" type="text" name="description">
                                                        <input class="form-control" type="hidden" name="id_project" value="{{ $id_project }}">

                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm ms-auto">Add</button>
                                                </div>
                                                </form>
                                                <div class="table-responsive p-0">
                                                    <table class="table align-items-center justify-content-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                    Description
                                                                </th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($domains as $domain)
                                                            <tr>
                                                                <td>
                                                                    <p class="text-sm font-weight-bold mb-0">{{ $domain->description }}</p>
                                                                </td>
                                                                <td class="align-middle">
                                                                    <button style="border:0; background: none; padding: 0px;" type="button" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#modal-form{{ $domain->id_domain }}" data-original-title="Edit domain">Edit</button>
                                                                    <!-- Modal Here Edition -->
                                                                    <div class="col-md-4">
                                                                        <div class="modal fade" id="modal-form{{ $domain->id_domain }}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                                            <div class="modal-content">
                                                                            <div class="modal-body p-0">
                                                                                <div class="card card-plain">
                                                                                <div class="card-header pb-0 text-left">
                                                                                    <h3>Domain Update</h3>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <form role="form text-left" method="POST" action="{{ route('planning_overall.domainEdit', $domain->id_domain) }}">
                                                                                        @csrf
                                                                                        @method('PUT')
                                                                                        <label>Domain</label>
                                                                                        <div class="input-group mb-3">
                                                                                        <input class="form-control" type="text" name="description" value="{{ $domain->description }}">
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Update</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Modal Ends Here -->
                                                                </td>
                                                                <td class="align-middle">
                                                                    <form action="{{ route('planning_overall.domainDestroy', $domain->id_domain) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button style="border:0; background: none; padding: 0px;" type="submit" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete domain">Delete</button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td colspan="5" class="text-center">No domains found.</td>
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
                        <!-- Domain ends here -->
                        <!-- Language starts here -->
                        <div class="col-md-6 unique-form-planning">
                            <div class="card">
                                <form role="form" action="{{ route('planning_overall.languageAdd') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div>
                                        <div class="card-header pb-0">
                                            <div class="d-flex align-items-center">
                                                <p class="mb-0">Languages</p>
                                                <button type="button" class="help-thoth-button" data-bs-toggle="modal" data-bs-target="#LanguageModal">
                                                    ?
                                                </button>
                                                <!-- Help Button Description -->
                                                <div class="modal fade" id="LanguageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Help for Languages</h5>
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
                                                        <select class="form-control" name="id_language">
                                                        @forelse ($languages as $language)
                                                            <option value="{{ $language->id_language }}">{{ $language->description }}</option>
                                                        @empty
                                                        <option>No languages in database.</option>
                                                        @endforelse
                                                        </select>
                                                        <input class="form-control" type="hidden" name="id_project" value="{{ $id_project }}">

                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm ms-auto">Add</button>
                                                </div>
                                                </form>
                                                <div class="table-responsive p-0">
                                                    <table class="table align-items-center justify-content-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                    Languages
                                                                </th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($projectLanguages as $projectLanguage)
                                                            <tr>
                                                                <td>
                                                                    <p class="text-sm font-weight-bold mb-0"><?=convert_language_name($projectLanguage->id_language)?></p>
                                                                </td>
                                                                <td class="align-middle">
                                                                    <form action="{{ route('planning_overall.languageDestroy', $projectLanguage->id_language) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button style="border:0; background: none; padding: 0px;" type="submit" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete language">Delete</button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td colspan="5" class="text-center">No languages found.</td>
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
                        <!-- Language ends here -->
                        <!-- Study type starts here -->
                        <div class="col-md-6 unique-form-planning">
                            <div class="card">
                                <form role="form" method="POST" action="{{ route('planning_overall.studyTAdd') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div>
                                        <div class="card-header pb-0">
                                            <div class="d-flex align-items-center">
                                                <p class="mb-0">Study type</p>
                                                <button type="button" class="help-thoth-button" data-bs-toggle="modal" data-bs-target="#StudyTypeModal">
                                                    ?
                                                </button>
                                                <!-- Help Button Description -->
                                                <div class="modal fade" id="StudyTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Help for Study type</h5>
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
                                                        <label for="example-text-input" class="form-control-label">Types</label>
                                                        <select class="form-control" name="id_study_type">
                                                            @forelse ($studyTypes as $studyType)
                                                            <option value="{{ $studyType->id_study_type }}">{{ $studyType->description }}</option>
                                                            @empty
                                                            <option>No study types in database.</option>
                                                            @endforelse
                                                        </select>
                                                        <input class="form-control" type="hidden" name="id_project" value="{{ $id_project }}">

                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm ms-auto">Add</button>
                                                </div>
                                                </form>
                                                <div class="table-responsive p-0">
                                                    <table class="table align-items-center justify-content-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                    Types
                                                                </th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($projectStudyTypes as $pStudyType)
                                                            <tr>
                                                                <td>
                                                                    <p class="text-sm font-weight-bold mb-0"><?=convert_study_type_name($pStudyType->id_study_type)?></p>
                                                                </td>
                                                                <td class="align-middle">
                                                                    <form action="{{ route('planning_overall.studyTDestroy', $pStudyType->id_study_type) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button style="border:0; background: none; padding: 0px;" type="submit" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete domain">Delete</button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td colspan="5" class="text-center">No domains found.</td>
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
                        <!-- Study type ends here -->
                        <!-- Keywords here -->
                        <div class="col-md-6 unique-form-planning">
                            <div class="card">
                                <form role="form" method="POST" action="{{ route('planning_overall.keywordAdd') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div>
                                        <div class="card-header pb-0">
                                            <div class="d-flex align-items-center">
                                                <p class="mb-0">Keywords</p>
                                                <button type="button" class="help-thoth-button" data-bs-toggle="modal" data-bs-target="#KeywordModal">
                                                    ?
                                                </button>
                                                <!-- Help Button Description -->
                                                <div class="modal fade" id="KeywordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Help for Keywords</h5>
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
                                                        <input class="form-control" type="text" name="description">
                                                        <input class="form-control" type="hidden" name="id_project" value="{{ $id_project }}">

                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm ms-auto">Add</button>
                                                </div>
                                                </form>
                                                <div class="table-responsive p-0">
                                                    <table class="table align-items-center justify-content-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                    Keywords
                                                                </th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($keywords as $keyword)
                                                            <tr>
                                                                <td>
                                                                    <p class="text-sm font-weight-bold mb-0">{{ $keyword->description }}</p>
                                                                </td>
                                                                <td class="align-middle">
                                                                    <button style="border:0; background: none; padding: 0px;" type="button" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#modal-form{{ $keyword->id_keyword }}" data-original-title="Edit domain">Edit</button>
                                                                    <!-- Modal Here Edition -->
                                                                    <div class="col-md-4">
                                                                        <div class="modal fade" id="modal-form{{ $keyword->id_keyword }}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                                            <div class="modal-content">
                                                                            <div class="modal-body p-0">
                                                                                <div class="card card-plain">
                                                                                <div class="card-header pb-0 text-left">
                                                                                    <h3>Keyword Update</h3>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <form role="form text-left" method="POST" action="{{ route('planning_overall.keywordEdit', $keyword->id_keyword) }}">
                                                                                        @csrf
                                                                                        @method('PUT')
                                                                                        <label>Keyword</label>
                                                                                        <div class="input-group mb-3">
                                                                                        <input class="form-control" type="text" name="description" value="{{ $keyword->description }}">
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Update</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Modal Ends Here -->
                                                                </td>
                                                                <td class="align-middle">
                                                                    <form action="{{ route('planning_overall.keywordDestroy', $keyword->id_keyword) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button style="border:0; background: none; padding: 0px;" type="submit" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete keyword">Delete</button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td colspan="5" class="text-center">No keywords found.</td>
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
                        <!-- Keywords ends here -->
                      <div class="col-md-6 unique-form-planning">
                        <div class="card p-4">
                         @include('planning.add-date', compact('project'))
                        </div>
                      </div>
                    </div>
  </div>
    <div class="tab-pane fade" id="data-bases">
                        <!-- Database starts here -->
                        <div class="container-fluid py-4">
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
                                                    <button type="submit" class="btn btn-success mt-3">Add Database</button>
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
                                                                        <button type="submit" class="btn btn-danger btn-sm" >Delete</button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            @error('name')
                                                                <p>{{ $message }}</p>
                                                            @enderror
                                                            @empty
                                                            <tr>
                                                                <td colspan="5" class="text-center">No databases found.</td>
                                                            </tr>
                                                            @endforelse
                                                        </tbody>

                                                    </table>
                                                </div>
                                                <div class="container-fluid py-4">
                                                <p class="mb-0">Suggest a new Data Base:</p>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                    <label for="example-text-input" class="form-control-label">Data Base name:</label>
                                                        <input class="form-control" type="text" name="description">
                                                        <input clas="form-control" type="hidden" name="id_project" value="{{ $id_project }}">

                                                        <label for="example-text-input" class="form-control-label">Data Base Link:</label>
                                                        <input class="form-control" type="text" name="description">
                                                        <input clas="form-control" type="hidden" name="id_project" value="{{ $id_project }}">


                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm ms-auto">Send suggestion</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
    </div>
    <div class="tab-pane fade" id="data-extraction">
                    <div class="col-12">
                        <div class="card bg-secondary-overview">
                            <div class="card-body">
                                <div class="card-group card-frame mt-5">
                                    <!-- create data extraction -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Create Data Extraction Question</h5>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" method="POST" action="{{ route('planning.dataExtractionCreate', $project->id_project) }}" enctype="multipart/form-data">
                                                @csrf
                                                <label class="form-control-label" for="id">ID</label>
                                                <input class="form-control" id="id" type="text" name="id">
                                                <label class="form-control-label" for="description">Description</label>
                                                <input class="form-control" id="description" type="text" name="description">
                                                <label class="form-control-label" for="type">Type</label>
                                                <select class="form-control" name="type" id="type" placeholder="Departure">

                                                </select>
                                                <button type="sumbit" class="btn btn-success mt-3">Add Question</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Create Data Extraction Question Option</h5>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" method="POST" action="{{ route('planning.dataExtractionOptionCreate', $project->id_project) }}" enctype="multipart/form-data">
                                                @csrf
                                                <label class="form-control-label" for="question-id">Question</label>
                                                <select class="form-control" name="questionId" id="question-id" placeholder="Departure">
                                                    <option value="" selected=""></option>
                                                    @foreach($project->questionExtractions as $question)
                                                        @if ($question->question_type->type == "Multiple Choice List" || $question->question_type->type == "Pick One List")
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
                                                                            <form class="m-1" role="form" method="POST" action="{{ route('planning.dataExtractionUpdateOption', [$project->id_project, $option->id_option]) }}" enctype="multipart/form-data">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#optionModal">Edit</button>
                                                                                <div class="modal fade" id="optionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                                        <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Option</h5>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <label class="form-control-label" for="option">Option</label>
                                                                                            <input class="form-control" type="text" id="option" name="option" value="{{ $option->description }}">
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                                            <button type="submit" class="btn bg-gradient-primary">Save changes</button>
                                                                                        </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
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
                                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#questionModal">Edit</button>
                                                            <div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Question</h5>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <label class="form-control-label" for="id">ID</label>
                                                                            <input class="form-control" id="id" value="{{ $question->id }}" name="id">
                                                                            <label class="form-control-label" for="description">Description</label>
                                                                            <input class="form-control" id="description" value="{{ $question->description }}" name="description">
                                                                            <label class="form-control-lavel" for="type">Type</label>
                                                                            <select class="form-control" name="type" id="type" placeholder="Departure">
                                                                                <option value="{{ $question->question_type->id_type }}" selected>{{ $question->question_type->type }}</option>
                                                                                @foreach($types as $type)
                                                                                    @if ($type->id_type !== $question->question_type->id_type)
                                                                                        <option value="{{ $type->id_type }}">{{ $type->type }}</option>
                                                                                    @endif
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

</div>
    @include('layouts.footers.auth.footer')
    </div>

    @endsection
