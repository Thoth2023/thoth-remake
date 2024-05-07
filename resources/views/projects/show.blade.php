@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Project'])

    <div class="row mt-4 mx-4">
        @include('project.components.project-header', ['project' => $project, 'activePage' => 'overview'])

        <div class="row px-0 mx-auto mt-4 pb-4">
            <div class="col-12">
                <div class="card bg-secondary-overview">
                    <div class="card-header bg-secondary-overview">
                        <h4>Overview</h4>
                    </div>
                    <div class="card-body">
                        @include('projects.project-overview', [
                            'project' => $project,
                            'activities' => $activities,
                        ])
                    </div>
                </div>
            </div>
        </div>
    @endsection
