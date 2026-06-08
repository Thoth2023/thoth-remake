@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => __('nav/topnav.project')])

    <div class="row mt-4 mx-4">
        @include('project.components.project-header', ['project' => $project, 'activePage' => 'overview'])

        <div class="card shadow-lg mx-4 mt-1">
            <div class="container-fluid py-2 px-2">
                    <div class="card-body">
                        @include('projects.project-overview', [
                            'project' => $project,
                            'activities' => $activities,
                            'planningProgress' => $planningProgress,
                            'conductingProgress' => $conductingProgress,
                        ])
                    </div>
            </div>
            @include("layouts.footers.auth.footer")
        </div>
    @endsection
