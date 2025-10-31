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
                                                    <div class="d-flex px-3">
                                                        <div class="my-auto">
                                                            <h6 class="mb-0 text-sm" title="{{ $project->title }}" data-toggle="tooltip">
                                                                {{ Str::limit($project->title, 50) }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $project->created_by }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <span class="me-2 text-xs font-weight-bold">100%</span>
                                                        <div>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-gradient-success"
                                                                    role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                                                    aria-valuemax="100" style="width: 100%;"></div>
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
    </div>
@endsection
