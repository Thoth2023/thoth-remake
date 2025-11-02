@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => __('nav/topnav.projects')])

    <div class="container-fluid py-4">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h4>
                                <i class="ni ni-single-copy-04 text-primary text-sm opacity-10"></i>
                                {{ __('project/search.results_of')}} {{ $searchProject }}
                            </h4>

                            <x-helpers.modal
                                target="permissions-modal"
                                modalTitle=""
                                modalContent="{!! __('project/permissions.modal.content') !!}"
                                textClose="{{ __('project/permissions.modal.close') }}"
                            >
                                <x-slot:trigger>
                                <span class="ms-2" data-bs-toggle="tooltip" title="{{ __('project/permissions.modal.title') }}">
                                    <i class="fas fa-question-circle text-primary" style="cursor:pointer; font-size:18px;"></i>
                                </span>
                                </x-slot:trigger>
                            </x-helpers.modal>


                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center justify-content-start mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                {{ __('project/search.project.table.headers.title') }}</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('project/search.project.table.headers.created_by') }}</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                {{ __('project/search.project.table.headers.completion') }}</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                {{ __('project/search.project.table.headers.options') }}</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($projects as $project)
                                            <tr>
                                                <td>
                                                    <div class="px-3">
                                                        <!-- Título -->
                                                        <h6 class="mb-1 text-sm fw-bold" title="{{ $project->title }}" data-toggle="tooltip">
                                                            {{ Str::limit($project->title, 40) }}
                                                        </h6>

                                                        <!-- Descrição -->
                                                        <div class="text-muted fst-italic"
                                                             style="font-size: 0.75rem; white-space: normal; word-wrap: break-word; max-width: 320px;"  title="{{ $project->description }}" data-toggle="tooltip">
                                                            {{ Str::limit($project->description, 105) }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $project->created_by }}</p>
                                                </td>
                                                @php
                                                    $progress = (float) ($project->progress_percent ?? 0);
                                                    $progress = max(0, min(100, $progress)); // clamp 0..100

                                                    $color = $progress < 30
                                                        ? 'bg-gradient-danger'
                                                        : ($progress < 60 ? 'bg-gradient-warning' : 'bg-gradient-success');
                                                @endphp

                                                <td class="align-middle text-center">

                                                    @isset($project->dbg_error)
                                                        <div class="text-danger text-xs">error: {{ $project->dbg_error }}</div>
                                                    @endisset

                                                    <div class="d-flex align-items-center justify-content-center">
                                                    <span class="me-2 text-xs font-weight-bold">
                                                        {{ number_format($progress, 2) }}%
                                                    </span>

                                                        <div style="min-width:120px;">
                                                            <div class="progress">
                                                                <div class="progress-bar {{ $color }}"
                                                                     role="progressbar"
                                                                     aria-valuenow="{{ $progress }}"
                                                                     aria-valuemin="0"
                                                                     aria-valuemax="100"
                                                                     style="width: {{ $progress }}%;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                @php
                                                    $user = auth()->user();

                                                    // nível do membro no projeto
                                                    $isAdmin = $project->userHasLevel($user, '1'); // Admin
                                                    $isViewer = $project->userHasLevel($user, '2'); // Viewer
                                                    $isResearcherOrReviewer = $project->userHasLevel($user, '3') || $project->userHasLevel($user, '4'); // Level Researcher/Reviewer

                                                    // verifica status na tabela members
                                                    $memberStatus = optional(
                                                        $project->users()->where('id_user', $user->id)->first()
                                                    )->pivot->status ?? null;

                                                    $isAcceptedMember = $memberStatus === 'accepted';
                                                @endphp

                                                <td class="d-flex mt-3 align-items-center justify-content-end gap-1">

                                                    {{-- Se usuário tem acesso ao projeto --}}
                                                    @can('access-project', $project)

                                                        {{-- Botão protocolo SEMPRE aparece --}}
                                                        @livewire('projects.public-protocol', ['project' => $project], key('public-protocol-'.$project->id_project))

                                                        {{--  Admin (level 1) pode tudo --}}
                                                        @if($isAdmin)
                                                            <a class="btn py-1 px-3 btn-outline-success" href="{{ route("projects.show", $project->id_project) }}">
                                                                <i class="fas fa-search-plus"></i>
                                                                {{ __("project/projects.project.options.view") }}
                                                            </a>

                                                            <a class="btn py-1 px-3 btn-outline-secondary" href="{{ route("projects.edit", $project->id_project) }}">
                                                                <i class="fas fa-edit"></i>
                                                                {{ __("project/projects.project.options.edit") }}
                                                            </a>

                                                            <a class="btn py-1 px-3 btn-outline-dark" href="{{ route("projects.add", $project->id_project) }}">
                                                                <i class="fas fa-user-check"></i>
                                                                {{ __("project/projects.project.options.add_member") }}
                                                            </a>

                                                            {{--  Researcher/Reviewer (3-4) só vê se accepted --}}
                                                        @elseif($isResearcherOrReviewer && $isAcceptedMember)
                                                            <a class="btn py-1 px-3 btn-outline-success" href="{{ route("projects.show", $project->id_project) }}">
                                                                <i class="fas fa-search-plus"></i>
                                                                {{ __("project/projects.project.options.view") }}
                                                            </a>

                                                            {{-- Viewer (level 2) → só protocolo (já mostrado acima) --}}
                                                        @elseif($isViewer)
                                                            {{-- nada além do protocolo --}}
                                                        @endif

                                                    @else
                                                        {{-- Sem acesso mas público → só protocolo --}}
                                                        @if($project->is_public)
                                                            @livewire('projects.public-protocol', ['project' => $project], key('public-protocol-'.$project->id_project))
                                                        @endif
                                                    @endcan

                                                </td>





                                                {{-- @endif --}}
                                            </tr>
                                        @empty
                                            <tr>
                                                <td
                                                    colspan="5"
                                                    class="text-center"
                                                >
                                                    {{ __("project/projects.project.table.empty") }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
    <style>
        @media (max-width: 768px) {
            table thead {
                display: none !important;
            }

            .project-row-card {
                display: block;
                margin-bottom: 12px;
                border: 1px solid #e0e6ed;
                border-radius: 10px;
                padding: 12px;
                background: #fff;
            }

            .project-row-card td {
                display: flex;
                justify-content: space-between;
                padding: 6px 0;
                width: 100%;
                font-size: 14px;
            }

            .project-row-card td::before {
                content: attr(data-title);
                font-weight: 600;
                color: #6c757d;
                margin-right: 8px;
            }

            .project-row-card .btn {
                width: 32px;
                padding: 4px;
                text-align: center;
            }
        }
    </style>

@endsection
