@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Project'])

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
            <ul class="nav nav-pills nav-fill p-1" role="tablist">
                <li class="nav-item">
                    <a class="btn bg-gradient-dark mb-0" href="{{ route('projects.show', $project->id_project) }}">
                        <i class="fas fa-plus"></i>Overview</a>

                </li>
                <li class="nav-item">
                    <a class="btn bg-gradient-faded-white mb-0" href="{{ route('planning.index', $project->id_project) }}">
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
</div>

<div class="row mx-4 mx-auto mt-5">
    <div class="col-12">
        <div class="card bg-secondary-overview">
            <div class="card-header bg-secondary-overview">
                <h4>Overview</h4>
            </div>
            <div class="card-body">
            @include('projects.project-overview', ['project' => $project])
            </div>
        </div>
    </div>
</div>
@endsection
