@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
<script src="{{ asset('assets/js/search_string.js')}}"></script>
<script src="{{ asset('assets/js/terms.js') }}"></script>
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
                                                    <div class="card-header pb-0">
                                                        <h5 class="d-inline">Search String</h5>
                                                        <button type="button"
                                                            class="bg-gradient-warning mb-3 help-thoth-button"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-notification-3">?</button>
                                                        @component('partials.help-modal', ['modalId' => 'modal-notification-3', 'title' => 'Help Search String'])
                                                            <h4 class="text-black mt-4">The terms help to focus your search
                                                                appropriately, looking for items that have had a specific term
                                                                applied by an indexer. After determining all relevant terms, you
                                                                should relate them if all their synonyms to make your search
                                                                string broader.</h4>
                                                        @endcomponent
                                                    </div>
                                                    <div class="card-body pb-0">
                                                        {{-- add term --}}
                                                        <form role="form" method="POST"
                                                            action="{{ route('planning_search_string.add_term', $project->id_project) }}"
                                                            style="display: flex;">
                                                            @csrf
                                                            <div class="col-md-5">
                                                                <label for="descriptionTermInput"
                                                                    class="form-control-label">Term</label>
                                                                <div class="form-group d-flex justify-content-between">
                                                                    <div class="col-sm-9">
                                                                        <input class="form-control" type="text"
                                                                            name="description_term"
                                                                            id="descriptionTermInput"
                                                                            placeholder="Enter the term" required>
                                                                    </div>
                                                                    <button type="submit"
                                                                        class="btn btn-primary ps-4 pe-4 py-1 px-2 mt-1"
                                                                        id="addTermButton">Add</button>
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
                                                        @component('partials.help-modal', ['modalId' => 'modal-notification-4', 'title' => 'Help Synonym'])
                                                            <h4 class="text-black mt-4">Synonyms help searching for articles
                                                                that use a different word for the same meaning as the term we
                                                                are searching for.</h4>
                                                        @endcomponent
                                                    </div>
                                                    <div class="card-body pt-0">
                                                        <div class="row align-content-center">
                                                            {{-- add synonym --}}
                                                            <form role="form" method="POST"
                                                                action="{{ route('planning_search_string.add_synonym', $project->id_project) }}"
                                                                style="display: flex;">
                                                                @csrf
                                                                <div class="col-md-5">
                                                                    <div class="col-auto">
                                                                        <label for="termSelect"
                                                                            class="form-control-label">Term</label>
                                                                        <select class="form-select" id="termSelect"
                                                                            name="termSelect" required onchange="related_terms(this.value);">
                                                                            <option value="" disabled selected>Select
                                                                                a Term</option>
                                                                            @forelse ($terms as $term)
                                                                                <option value="{{ $term->id_term }}">
                                                                                    {{ $term->description }}</option>
                                                                            @empty
                                                                                <option value="" disabled>No terms
                                                                                    added</option>
                                                                            @endforelse
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5 text-start">
                                                                    <label for="termSelect"
                                                                        class="form-control-label">Synonym</label>
                                                                    <div class="form-group d-flex justify-content-between">
                                                                        <div class="col-sm-9">
                                                                            <input class="form-control" type="text"
                                                                                name="description_synonym"
                                                                                id="descriptionSynonymInput"
                                                                                placeholder="Enter a synonym" required>
                                                                        </div>
                                                                        <button type="submit"
                                                                            class="btn btn-primary ps-4 pe-4 py-1 px-2 mt-1"
                                                                            id="addSynonymButton">Add</button>
                                                                    </div>
                                                                </div>

                                                            </form>
                                                            <div class="" id="related-terms">

                                                            </div>
                                                            {{-- end synonym --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="mt-4">
                                                    <div class="table-responsive m-4 card shadow-none border">
                                                        <table class="table align-items-center mb-0">
                                                            {{-- <caption class="ps-2 mb-1 mt-3">List of Term</caption> --}}
                                                            <thead>
                                                                <tr>
                                                                    <th class="ps-5">Term</th>
                                                                    <th>Synonyms</th>
                                                                    <th class="text-center">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($terms as $term)
                                                                    <tr>
                                                                        <td class="ps-5">{{ $term->description }}</td>
                                                                        <td>
                                                                            <table class="table">
                                                                                <tbody>
                                                                                    @forelse ($term->synonyms as $synonym)
                                                                                        <tr>
                                                                                            <td class="text-center">{{ $synonym->description }}
                                                                                            </td>
                                                                                            <td>
                                                                                                <div
                                                                                                    class="d-flex justify-content-end">
                                                                                                    <a href="#"
                                                                                                        class="btn btn-link text-secondary mt-2 pt-1 pb-1 mt-3"
                                                                                                        data-bs-toggle="modal"
                                                                                                        data-bs-target="#exampleModalMessage{{ $term->id_term }}_{{ $synonym->id_synonym }}"
                                                                                                        data-original-title="Edit Synonym">Edit</a>
                                                                                                    <!-- Synonym Edit Modal -->
                                                                                                    @component('partials.synonym-modal', ['term' => $term, 'synonym' => $synonym])
                                                                                                    @endcomponent

                                                                                                    <a href="#"
                                                                                                        class="btn btn-link text-danger mt-2 pt-1 pb-1 mt-3"
                                                                                                        data-bs-toggle="modal"
                                                                                                        data-bs-target="#modal-delete-{{ $term->id_term }}_{{ $synonym->id_synonym }}">Delete</a>
                                                                                                    <!-- Synonym Delete Modal -->
                                                                                                    @component('partials.synonym-delete-modal', ['term' => $term, 'synonym' => $synonym])
                                                                                                    @endcomponent
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @empty
                                                                                        <tr>
                                                                                            <td colspan="2">No synonyms
                                                                                                added</td>
                                                                                        </tr>
                                                                                    @endforelse
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex justify-content-center">
                                                                                <a href="#"
                                                                                    class="btn btn-link text-secondary mt-2 pt-1 pb-1 mt-3"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#exampleModalMessage{{ $term->id_term }}"
                                                                                    data-original-title="Edit Term">Edit</a>
                                                                                <!-- Term Edit Modal -->
                                                                                @component('partials.term-modal', ['term' => $term])
                                                                                @endcomponent

                                                                                <a href="#"
                                                                                    class="btn btn-link text-danger mt-2 pt-1 pb-1 mt-3"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#modal-delete-{{ $term->id_term }}">Delete</a>
                                                                                <!-- Term Delete Modal -->
                                                                                @component('partials.term-delete-modal', ['term' => $term])
                                                                                @endcomponent
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="3">No terms</td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <h6 class="ps-4 mt-2 mb-2"><strong><a target="_blank" href="#">String Improver</a></strong></h6>

                                                {{-- <div id="strings">
                                                    <div class="form-inline">
                                                        <label><strong>Strings</strong></label>
                                                        <a onclick="modal_help('modal_help_strings')" class="float-right opt"><i class="fas fa-question-circle "></i></a>
                                                    </div>

                                                    @foreach ($project->get_search_strings() as $search_string)
                                                        <div class="form-group" id="div_string_{{ $search_string->get_database()->get_name() }}">
                                                            <a target="_blank" href="{{ $search_string->get_database()->get_link() }}">
                                                                {{ $search_string->get_database()->get_name() }}
                                                            </a>
                                                            <textarea class="form-control" id="string_{{ $search_string->get_database()->get_name() }}">
                                                                {{ $search_string->get_description() }}
                                                            </textarea>
                                                            <button type="button" class="btn btn-info opt" onclick="generate_string('{{ $search_string->get_database()->get_name() }}');">
                                                                Generate
                                                            </button>
                                                            <hr>
                                                        </div>
                                                    @endforeach
                                                </div> --}}

                                                @include('components.prev-next')
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
