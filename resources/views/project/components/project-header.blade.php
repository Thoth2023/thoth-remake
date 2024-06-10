<!-- resources/views/components/project-header.blade.php -->

@props(['project', 'activePage'])

@php
    $tabs = [
        'overview' => [
            'icon' => 'fas fa-info-circle',
            'label' => __("project/header.overview"),
            'route' => 'projects.show',
        ],
        'planning' => [
            'icon' => 'fas fa-calendar-alt',
            'label' => __("project/header.planning" ),
            'route' => 'project.planning.index',
        ],
        'conducting' => [
            'icon' => 'fas fa-tasks',
            'label' => __("project/header.conducting"),
            'route' => 'conducting.index',
        ],
        'reporting' => [
            'icon' => 'fas fa-chart-bar',
            'label' => __("project/header.reporting"),
            'route' => 'reporting.index',
        ],
        'export' => [
            'icon' => 'fas fa-file-export',
            'label' => __("project/header.export"),
            'route' => null,
        ],
    ];
@endphp

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4>{{ $project->title }}</h4>
        </div>
        <div class="card-body pt-0">
            <div class="nav-wrapper position-relative end-0">
                <ul class="d-flex gap-2 nav nav-fill p-1" id="myTabs">
                    @foreach ($tabs as $page => $pageDetails)
                        <li class="nav-item" style="flex-grow: 1;">
                            @if ($pageDetails['route'])
                                <a class="w-100 btn btn-md mb-0 {{ $activePage === $page ? 'bg-gradient-dark' : '' }}"
                                    href="{{ route($pageDetails['route'], $project->id_project) }}">
                                    <i class="{{ $pageDetails['icon'] }}" style="width: 20px;"></i> {{ $pageDetails['label'] }}
                                </a>
                            @else
                                <button type="button" class="w-100 btn btn-md mb-0">
                                    <i class="{{ $pageDetails['icon'] }}" style="width: 20px;"></i> {{ $pageDetails['label'] }}
                                </button>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
