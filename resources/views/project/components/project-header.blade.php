<!-- resources/views/components/project-header.blade.php -->

@props(['project', 'activePage'])

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4>{{ $project->title }}</h4>
        </div>
        <div class="card-body">
            <div class="nav-wrapper position-relative end-0">
                <ul class="nav nav-pills nav-fill p-1" id="myTabs">
                    <li class="nav-item">
                        <a class="btn mb-0 {{ $activePage === 'overview' ? 'bg-gradient-dark' : 'bg-gradient-faded-white' }}"
                           href="{{ route('projects.show', $project->id_project) }}">
                            <i class="fas fa-info-circle"></i> Overview
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn mb-0 {{ $activePage === 'planning' ? 'bg-gradient-dark' : 'bg-gradient-faded-white' }}"
                           href="{{ route('project.planning.index', $project->id_project) }}">
                            <i class="fas fa-calendar-alt"></i> Planning
                        </a>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn bg-gradient-default"><i class="fas fa-tasks"></i> Conducting</button>
                    </li>
                    <li class="nav-item">
                        <a class="btn mb-0 {{ $activePage === 'reporting' ? 'bg-gradient-dark' : 'bg-gradient-faded-white' }}"
                           href="{{ route('reporting.index', $project->id_project) }}">
                            <i class="fas fa-chart-bar"></i> Reporting
                        </a>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn bg-gradient-default"><i class="fas fa-file-export"></i> Export</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

