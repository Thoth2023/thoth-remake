@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Planning Criteria'])

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
                                <a class="nav-link mb-0 px-0 py-1 active" href="{{ route('planning.index', $id_project) }}" aria-controls="Overallinformation">
                                Overall information
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" href="{{ route('planning.research_questions', $project->id_project) }}" aria-controls="ResearchQuestions">
                                Research Questions
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" href="#Databases" aria-controls="Databases">
                                Data Bases
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" href="#SearchString" aria-controls="SearchString">
                                Search String
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" href="#SearchStrategy" aria-controls="SearchStrategy">
                                Search Strategy
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" href="{{ route('planning.criteria', $project->id_project) }}" aria-controls="Criteria" style="background-color: #212229; color: white;">
                                Criteria
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" href="#QualityAssessment" aria-controls="QualityAssessment">
                                Quality Assessment
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" href="#DataExtraction" role="tab" aria-controls="DataExtraction">
                                Data Extraction
                                </a>
                            </li>
                        </ul>
                    </div>
                    </div>
                    <div class="row" style="justify-content: space-around;">
                        <!-- Criteria starts here -->
                        <div class="col-md-6 unique-form-planning" style="width: 100%;">
                            <div class="card">
                                <form role="form" method="POST" action="{{ route('planning_criteria.Add') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div>
                                        <div class="card-header pb-0">
                                            <div class="d-flex align-items-center">
                                                <p class="mb-0">Criteria</p>
                                                <button type="button" class="help-thoth-button" data-bs-toggle="modal" data-bs-target="#Criteria">
                                                    ?
                                                </button>
                                                <!-- Help Button Description -->
                                                <div class="modal fade" id="Criteria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Help for Criteria</h5>
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
                                                        <label for="example-text-input" class="form-control-label">ID</label>
                                                        <input class="form-control" type="text" name="id" required>
                                                        <label for="example-text-input" class="form-control-label">Description</label>
                                                        <input class="form-control" type="text" name="description" required>
                                                        <label for="example-text-input" class="form-control-label">Type</label>
                                                        <select class="form-control" name="type">
                                                            <option value="Inclusion">Inclusion</option>
                                                            <option value="Exclusion">Exclusion</option>
                                                        </select>
                                                        <input class="form-control" type="hidden" name="id_project" value="{{ $id_project }}">
                                                        <input class="form-control" type="hidden" name="pre_selected" value="0">

                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm ms-auto">Add</button>
                                                </div>
                                                </form>
                                                <hr>
                                                <h6>Inclusion Criterias</h6>
                                                <div class="table-responsive p-0">
                                                    <table class="table align-items-center justify-content-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                    ID
                                                                </th>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                    Description
                                                                </th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($inclusion_criterias as $criteria)
                                                            <tr>
                                                                <td>
                                                                    <p class="text-sm font-weight-bold mb-0">{{ $criteria->id }}</p>
                                                                </td>
                                                                <td>
                                                                    <p class="text-sm font-weight-bold mb-0">{{ $criteria->description }}</p>
                                                                </td>
                                                                <td class="align-middle">
                                                                    <button style="border:0; background: none; padding: 0px;" type="button" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#modal-form{{ $criteria->id_criteria }}" data-original-title="Edit criteria">Edit</button>
                                                                    <!-- Modal Here Edition -->
                                                                    <div class="col-md-4">
                                                                        <div class="modal fade" id="modal-form{{ $criteria->id_criteria }}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                                            <div class="modal-content">
                                                                            <div class="modal-body p-0">
                                                                                <div class="card card-plain">
                                                                                <div class="card-header pb-0 text-left">
                                                                                    <h3>Criteria Update</h3>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <form role="form text-left" method="POST" action="{{ route('planning_criteria.Edit', $criteria->id_criteria) }}">
                                                                                        @csrf
                                                                                        @method('PUT')
                                                                                        <label>ID</label>
                                                                                        <div class="input-group mb-3">
                                                                                            <input class="form-control" type="text" name="id" value="{{ $criteria->id }}" required>
                                                                                        </div>
                                                                                        <label>Description</label>
                                                                                        <div class="input-group mb-3">
                                                                                            <input class="form-control" type="text" name="description" value="{{ $criteria->description }}" required>
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
                                                                    <form action="{{ route('planning_criteria.Destroy', $criteria->id_criteria) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button style="border:0; background: none; padding: 0px;" type="submit" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete Criteria">Delete</button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td colspan="5" class="text-center">No criteria found.</td>
                                                            </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                    <hr>
                                                    <h6>Exclusion Criterias</h6>
                                                    <div class="table-responsive p-0">
                                                        <table class="table align-items-center justify-content-center mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                        ID
                                                                    </th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                        Description
                                                                    </th>
                                                                    <th></th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($exclusion_criterias as $criteria)
                                                                <tr>
                                                                    <td>
                                                                        <p class="text-sm font-weight-bold mb-0">{{ $criteria->id }}</p>
                                                                    </td>
                                                                    <td>
                                                                        <p class="text-sm font-weight-bold mb-0">{{ $criteria->description }}</p>
                                                                    </td>
                                                                    <td class="align-middle">
                                                                        <button style="border:0; background: none; padding: 0px;" type="button" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#modal-form{{ $criteria->id_criteria }}" data-original-title="Edit criteria">Edit</button>
                                                                        <!-- Modal Here Edition -->
                                                                        <div class="col-md-4">
                                                                            <div class="modal fade" id="modal-form{{ $criteria->id_criteria }}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                                                <div class="modal-content">
                                                                                <div class="modal-body p-0">
                                                                                    <div class="card card-plain">
                                                                                    <div class="card-header pb-0 text-left">
                                                                                        <h3>Criteria Update</h3>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        <form role="form text-left" method="POST" action="{{ route('planning_criteria.Edit', $criteria->id_criteria) }}">
                                                                                            @csrf
                                                                                            @method('PUT')
                                                                                            <label>ID</label>
                                                                                            <div class="input-group mb-3">
                                                                                                <input class="form-control" type="text" name="id" value="{{ $criteria->id }}" required>
                                                                                            </div>
                                                                                            <label>Description</label>
                                                                                            <div class="input-group mb-3">
                                                                                                <input class="form-control" type="text" name="description" value="{{ $criteria->description }}" required>
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
                                                                        <form action="{{ route('planning_criteria.Destroy', $criteria->id_criteria) }}" method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button style="border:0; background: none; padding: 0px;" type="submit" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete Criteria">Delete</button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                    <td colspan="5" class="text-center">No criteria found.</td>
                                                                </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                            </div>
                        </div>
                        <!-- Research Questions ends here -->
                    </div>
                </div>
            </div>
        </div>
    @error('id') <div class="alert alert-dark alert-dismissible fade show" role="alert" style="position: absolute; color: white;">
        <span class="alert-text"><strong>Alert!</strong> {{$message}} </span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>@enderror
    @error('duplicate') <div class="alert alert-dark alert-dismissible fade show" role="alert" style="position: absolute; color: white;">
        <span class="alert-text"><strong>Alert!</strong> {{$message}} </span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>@enderror
    </div>
</div>
@include('layouts.footers.auth.footer')
</div>
@endsection

