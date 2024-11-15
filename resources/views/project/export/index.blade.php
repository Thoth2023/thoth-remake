@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => __('nav/topnav.export')])

    <div class="row mt-4 mx-4">

        @include('project.components.project-header', ['project' => $project, 'activePage' => 'export'])

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="grid-items-2 gap-4">
                        @livewire('export.latex', ['projectId' => $project->id_project])
                        @livewire("export.bibtex", ['projectId' => $project->id_project])
                    </div>
                </div>
            </div>
            @include('layouts.footers.auth.footer')
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    @push('js')
        <script>
            // Function to store the active tab in a cookie
            function storeActiveTab(tabId) {
                document.cookie = "activeReportingTab=" + tabId + ";path=/";
            }
        </script>
    @endpush
@endsection
