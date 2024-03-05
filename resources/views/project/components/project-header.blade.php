<!-- resources/views/components/project-header.blade.php -->

@props(['project', 'activePage'])

@php
    $tabs = [
        'overview' => [
            'icon' => 'fas fa-info-circle',
            'label' => 'Overview',
            'route' => 'projects.show'
        ],
        'planning' => [
            'icon' => 'fas fa-calendar-alt',
            'label' => 'Planning',
            'route' => 'project.planning.index'
        ],
        'conducting' => [
            'icon' => 'fas fa-tasks',
            'label' => 'Conducting',
            'route' => null
        ],
        'reporting' => [
            'icon' => 'fas fa-chart-bar',
            'label' => 'Reporting',
            'route' => 'reporting.index'
        ],
        'export' => [
            'icon' => 'fas fa-file-export',
            'label' => 'Export',
            'route' => null
        ],
    ];
@endphp

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4>{{ $project->title }}</h4>
        </div>
        <div class="card-body">
            <div class="nav-wrapper position-relative end-0">
                <ul class="nav nav-pills nav-fill p-1" id="myTabs">
                    @foreach($tabs as $page => $pageDetails)
                        <li class="nav-item">
                            @if($pageDetails['route'])
                                <a class="btn mb-0 {{
                                    $activePage === $page ? 'bg-gradient-dark' : 'bg-gradient-faded-white'
                                }}" href="{{ route($pageDetails['route'], $project->id_project) }}">
                                    <i class="{{ $pageDetails['icon'] }}"></i> {{ $pageDetails['label'] }}
                                </a>
                            @else
                                <button type="button" class="btn bg-gradient-default">
                                    <i class="{{ $pageDetails['icon'] }}"></i> {{ $pageDetails['label'] }}
                                </button>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

