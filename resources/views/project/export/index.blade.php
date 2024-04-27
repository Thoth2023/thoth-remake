@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

<style>
    .form-check {
        display: inline-block;
        margin-right: 10px;
    }

    .form-check-input {
    width: 30px; /* largura */
    height: 30px; /* altura */
}
    
.form-check-label {
    font-size: 20px; /* tamanho da fonte */
   margin-top: 5px
}

</style>
@stack('styles')


    @include('layouts.navbars.auth.topnav', ['title' => 'Export'])

    <div class="row mt-4 mx-4">

        @include('project.components.project-header', ['project' => $project, 'activePage' => 'Export'])

        <div class="container-fluid py-4">
            <div class="container-fluid py-4">
                
                <div class="card card-frame mt-5">
                    <div class="card-group justify-content-center">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <h3 class="card-title>">Export</h3>
                                        <div class="checkbox-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                <label class="form-check-label" for="flexCheckDefault1">
                                                    Opção 1
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                <label class="form-check-label" for="flexCheckDefault2" >
                                                    Opção 2
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                <label class="form-check-label" for="flexCheckDefault3">
                                                    Opção 3
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4" width="50" height="50">
                                                <label class="form-check-label" for="flexCheckDefault4" >
                                                    Opção 4
                                                </label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success mt-3">
                                            Exportar
                                        </button>
                                    </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
            
        <div class="card card-frame mt-5">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h3 class="card-title>">BibTex</h3>
                        <textarea name="bibTex-generated" class="form-control " id="bibTex-generated" rows="8" data-lt-tmp-id="lt-532503" spellcheck="false" data-gramm="false"></textarea>
                    </div>
            </div>
        </div>



     </div>
        

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
