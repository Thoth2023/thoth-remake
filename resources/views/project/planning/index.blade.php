@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Planning'])
@include('project.planning.convert-language-name')
@include('project.planning.convert-study-type-name')
@include('project.planning.convert-database')

<div class="row mt-4 mx-4">

    @include('project.components.project-header', ['activePage' => 'planning'], ['project' => $project])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                @include('project.components.project-tabs', [
                    'header' => 'Planning',
                    'tabs' => [
                        ['id' => 'overall-info-tab', 'label' => 'Overall Information', 'href' => '#overall-info'],
                        ['id' => 'research-questions-tab', 'label' => 'Research Questions', 'href' => '#research-questions'],
                        ['id' => 'data-bases-tab', 'label' => 'Data Bases', 'href' => '#data-bases'],
                        ['id' => 'search-string-tab', 'label' => 'Search String', 'href' => '#search-string'],
                        ['id' => 'search-strategy-tab', 'label' => 'Search Strategy', 'href' => '#search-strategy'],
                        ['id' => 'criteria-tab', 'label' => 'Criteria', 'href' => '#criteria'],
                        ['id' => 'quality-assessment-tab', 'label' => 'Quality Assessment', 'href' => '#quality-assessment'],
                        ['id' => 'data-extraction-tab', 'label' => 'Data Extraction', 'href' => '#data-extraction'],
                    ],
                    'activeTab' => 'overall-info-tab'
                ])

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="overall-info">
                        @include('project.planning.overall')
                    </div>
                    <div class="tab-pane fade" id="data-bases">
                        @include('project.planning.databases')
                    </div>
                    <div class="tab-pane fade" id="data-extraction">
                        @include('project.planning.data_extraction')
                    </div>
                    <div class="tab-pane fade" id="search-strategy">
                        @include('project.planning.search-strategy')
                    </div>
                    <div class="tab-pane fade" id="research-questions">
                        @include('project.planning.research_questions')
                    </div>
                    <div class="tab-pane fade" id="criteria">
                        @include('project.planning.criteria')
                    </div>

                </div>

            </div>
            @include('layouts.footers.auth.footer')
        </div>
    </div>
</div>
@endsection

<script>
    // Function to store the active tab in a cookie
    function storeActiveTab(tabId) {
        document.cookie = "activePlanningTab=" + tabId + ";path=/";
    }
</script>
