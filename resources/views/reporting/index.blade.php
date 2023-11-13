@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Reporting'])

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
                            <a class="btn bg-gradient-faded-white mb-0"
                                href="{{ route('planning.index', $project->id_project) }}">

                                <i class="fas fa-plus"></i>Planning</a>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="btn bg-gradient-default">Conducting</button>
                        </li>
                        <li class="nav-item">
                            <a class="btn bg-gradient-dark mb-0"
                                href="{{ route('reporting.index', $project->id_project) }}">

                                <i class="fas fa-plus"></i>Reporting</a>
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
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Planning</h6>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" id="overview-tab" data-bs-toggle="tab"
                                href="#overview">Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="import-studies-tab" data-bs-toggle="tab"
                                href="#import-studies">Import Studies</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="study-selection-tab" data-bs-toggle="tab"
                                href="#study-selection">Study Selection</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="quality-assessment-tab" data-bs-toggle="tab"
                                href="#quality-assessment">Quality Assessment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="data-extraction-tab" data-bs-toggle="tab"
                                href="#data-extraction">Data Extraction</a>
                        </li>
                        <!-- Add the rest of the tabs in a similar manner -->
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="overview">
                        </div>
                        <div>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum
                            voluptates. Quisquam, voluptatum voluptates. Quisquam, voluptatum voluptates.
                            Quisquam, voluptatum voluptates. Quisquam, voluptatum voluptates. Quisquam,
                        </div>
                    </div>
                    <div class="tab-pane fade" id="import-studies">
                    </div>
                    <div class="tab-pane fade" id="study-selection">
                    </div>
                    <div class="tab-pane fade" id="quality-assessment">
                    </div>
                    <div class="tab-pane fade" id="data-extraction">
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
        document.cookie = "activeReportingTab=" + tabId + ";path=/";
    }
</script>
