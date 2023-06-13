@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Planning Search String'])
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
                                <a class="btn bg-gradient-faded-white mb-0"
                                    href="{{ route('projects.show', $project->id_project) }}">
                                    <i class="fas fa-plus"></i>Overview</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn bg-gradient-dark mb-0"
                                    href="{{ route('planning.index', $project->id_project) }}">
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
                                                <a class="nav-link mb-0 px-0 py-1"
                                                    href="{{ route('planning.index', $project->id_project) }}"
                                                    aria-controls="Overallinformation">
                                                    Overall information
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link mb-0 px-0 py-1"
                                                    href="{{ route('planning.research_questions', $project->id_project) }}"
                                                    aria-controls="ResearchQuestions">
                                                    Research Questions
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link mb-0 px-0 py-1 active"
                                                    href="{{ route('planning.databases', $project->id_project) }}"
                                                    aria-controls="Databases">
                                                    Data Bases
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link mb-0 px-0 py-1" href="#SearchString"
                                                    aria-controls="SearchString"
                                                    style="background-color: #212229; color: white;">
                                                    Search String
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab"
                                                    href="{{ route('search-strategy.edit', ['projectId' => $project->id_project]) }}"
                                                    role="tab" aria-controls="SearchStrategy" aria-selected="false">
                                                    Search Strategy
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link mb-0 px-0 py-1" href="#Criteria"
                                                    aria-controls="Criteria">
                                                    Criteria
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link mb-0 px-0 py-1" href="#QualityAssessment"
                                                    aria-controls="QualityAssessment">
                                                    Quality Assessment
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link mb-0 px-0 py-1" role="tab"
                                                    href="{{ route('planning.dataExtraction', $project->id_project) }}"
                                                    aria-controls="DataExtraction">
                                                    Data Extraction
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card bg-secondary-overview">
                                        <div class="card-body">
                                            <div class="dflex column card mt-0">
                                                <div class="mt-4">
                                                    {{-- Start modal help  --}}
                                                    <div class="card-header pb-0">
                                                        <h5 class="d-inline">Search String</h5>
                                                        <button type="button"
                                                            class="bg-gradient-warning mb-3 help-thoth-button"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-notification-3">?</button>
                                                        <div class="modal fade" id="modal-notification-3" tabindex="-1"
                                                            role="dialog" aria-labelledby="modal-notification-3"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-danger modal-dialog-centered modal-"
                                                                role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h6 class="modal-title"
                                                                            id="modal-title-notification-3">Help Search
                                                                            String</h6>
                                                                        <button type="button"
                                                                            class="btn btn-danger small-button"
                                                                            data-bs-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">x</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="py-3 text-center">
                                                                            <h4 class="text-black mt-4">The terms help to
                                                                                focus your search appropriately, looking for
                                                                                items that have had a specific term applied
                                                                                by an indexer.
                                                                                After determining all relevant terms, you
                                                                                should relate them if all their synonyms to
                                                                                make your search string broader.</h4>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-white"
                                                                            data-bs-dismiss="modal">Ok, Got it</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Help -->

                                                    <div class="card-body">
                                                        {{-- add term --}}
                                                        <form role="form" method="POST"
                                                            action="{{ route('planning_search_string.add_term', $project->id_project) }}"
                                                            style="display: flex;">
                                                            @csrf
                                                            <div class="col-md-5">
                                                                <label for="example-text-input"
                                                                    class="form-control-label">Term</label>
                                                                <div class="form-group d-flex justify-content-between">
                                                                    <div class="col-sm-9">
                                                                        <input class="form-control" type="text"
                                                                            name="description_term"
                                                                            id="descriptionTermInput"
                                                                            placeholder="Enter the term">
                                                                    </div>
                                                                    <button type="submit"
                                                                        class="btn btn-primary btn-sm ms-auto">Add</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        {{-- end term --}}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="mt-4">
                                                    <div class="card-header pt-2 pb-0">
                                                        <h5 class="d-inline">Synonym</h5>
                                                        <button type="button"
                                                            class="bg-gradient-warning mb-3 help-thoth-button"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-notification-4">?</button>
                                                        <div class="modal fade" id="modal-notification-4" tabindex="-1"
                                                            role="dialog" aria-labelledby="modal-notification-4"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-danger modal-dialog-centered modal-"
                                                                role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h6 class="modal-title"
                                                                            id="modal-title-notification-4">Help
                                                                            Synonym</h6>
                                                                        <button type="button"
                                                                            class="btn btn-danger small-button"
                                                                            data-bs-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">x</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="py-3 text-center">
                                                                            <h4 class="text-black mt-4">Fill in
                                                                                this
                                                                                help.</h4>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-white"
                                                                            data-bs-dismiss="modal">Ok, Got
                                                                            it</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body pt-0">
                                                        <div class="row align-content-center">
                                                            <div class="col-md-5">
                                                                <div class="col-auto">
                                                                    <label for="example-text-input"
                                                                        class="form-control-label">Term</label>
                                                                    <select class="form-select" id="termSelect"
                                                                        name="term">
                                                                        <option value="" disabled selected>
                                                                            Select a Term</option>
                                                                        @foreach ($terms as $term)
                                                                            <option value="{{ $term->id_term }}">
                                                                                {{ $term->description }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5 text-start">
                                                                <label for="example-text-input"
                                                                    class="form-control-label">Synonym</label>
                                                                <div class="form-group d-flex justify-content-between">
                                                                    <div class="col-sm-9">
                                                                        <input class="form-control" type="text"
                                                                            name="description">
                                                                    </div>
                                                                    <button type="submit"
                                                                        class="btn btn-primary btn-sm">Add</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="mt-4">
                                                    <div class="table-responsive m-4 card shadow-none border">
                                                        <table class="table align-items-center mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Term</th>
                                                                    <th>Synonyms</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($terms as $term)
                                                                    <tr>
                                                                        {{-- <td rowspan="{{ count($synonyms) }}"> --}}
                                                                        <td>
                                                                            {{ $term->description }}
                                                                        </td>
                                                                        {{-- <td>{{ $synonyms[0] }}</td> --}}
                                                                        <td></td>
                                                                    </tr>
                                                                    {{-- @for ($i = 1; $i < count($synonyms); $i++) --}}
                                                                    {{--     <tr> --}}
                                                                    {{--         <td>{{ $synonyms[$i] }}</td> --}}
                                                                    {{--     </tr> --}}
                                                                    {{-- @endfor --}}
                                                                @endforeach
                                                            </tbody>
                                                        </table>
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
