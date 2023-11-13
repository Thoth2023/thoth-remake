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
                    <ul class="nav nav-pills nav-fill p-1" id="myTabs">
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
                            <button type="button"
                                class="btn bg-gradient-default">Conducting</button>
                        </li>
                        <li class="nav-item">
                            <a class="btn bg-gradient-faded-white mb-0"
                                href="{{ route('reporting.index', $project->id_project) }}">

                                <i class="fas fa-plus"></i>Reporting</a>
                        </li>
                        <li class="nav-item">
                            <button type="button"
                                class="btn bg-gradient-default">Export</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Planning</h6>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" id=" "
                                data-bs-toggle="tab" href="#overall-info">Overall
                                Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="research-questions-tab"
                                data-bs-toggle="tab"
                                href="#research-questions">Research
                                Questions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="data-bases-tab"
                                data-bs-toggle="tab" href="#data-bases">Data
                                Bases</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="search-string-tab"
                                data-bs-toggle="tab" href="#search-string">Search
                                String</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="search-strategy-tab"
                                data-bs-toggle="tab" href="#search-strategy">Search
                                Strategy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="criteria-tab"
                                data-bs-toggle="tab" href="#criteria">Criteria</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="quality-assessment-tab"
                                data-bs-toggle="tab"
                                href="#quality-assessment">Quality
                                Assessment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="data-extraction-tab"
                                data-bs-toggle="tab" href="#data-extraction">Data
                                Extraction</a>
                        </li>

                        <!-- Add the rest of the tabs in a similar manner -->
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="overall-info">
                        @include('planning.overall')
                    </div>
                    <div class="tab-pane fade" id="data-bases">
                        @include('planning.databases')
                    </div>
                    <div class="tab-pane fade" id="data-extraction">
                        @include('planning.data_extraction')
                    </div>
                    <div class="tab-pane fade" id="search-strategy">
                        @include('planning.search-strategy')
                    </div>
                    <div class="tab-pane fade" id="research-questions">
                        @include('planning.research_questions')
                    </div>
                    <div class="tab-pane fade" id="criteria">
                        @include('planning.criteria')
                    </div>

                </div>

            </div>
            @include('layouts.footers.auth.footer')
        </div>
    </div>
</div>
@endsection

<script>
function storeActiveTab(tabId) {
  document.cookie = "activeTab=" + tabId + ";path=/";
}
</script>
