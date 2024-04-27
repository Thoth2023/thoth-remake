@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Export'])

    <div class="row mt-4 mx-4">

        @include('project.components.project-header', ['project' => $project, 'activePage' => 'Export'])

        <div class="container-fluid py-4">
           
            </div>
            @include('layouts.footers.auth.footer')
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    @push('js')
        {{-- <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/funnel.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script> --}}
        <script>
            // Function to store the active tab in a cookie
            function storeActiveTab(tabId) {
                document.cookie = "activeReportingTab=" + tabId + ";path=/";
            }

            // Sample Highcharts chart
            document.addEventListener('DOMContentLoaded', function() {


            });
        </script>
    @endpush
@endsection
