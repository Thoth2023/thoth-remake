@extends("layouts.app", ["class" => "g-sidenav-show bg-gray-100"])

@section("content")
    @include("layouts.navbars.auth.topnav", ["title" => "Projects"])

    <div class="container-fluid py-2">
        <div class="container-fluid py-2">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="col-12 text-end">
                                <a
                                    class="btn bg-gradient-dark mb-0"
                                    href="{{ route("projects.create") }}"
                                >
                                    <i class="fas fa-plus"></i>
                                    &nbsp;&nbsp;{{ __("project/projects.project.new") }}
                                </a>
                            </div>

                            <h6>
                                <i
                                    class="ni ni-single-copy-04 text-primary text-sm opacity-10"
                                ></i>
                                {{ __("project/projects.project.table.title") }}
                            </h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table
                                    class="table align-items-center justify-content-center mb-0"
                                >
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                            >
                                                {{ __("project/projects.project.table.headers.title") }}
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                            >
                                                {{ __("project/projects.project.table.headers.created_by") }}
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                            >
                                                {{ __("project/projects.project.table.headers.status") }}
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2"
                                            >
                                                {{ __("project/projects.project.table.headers.completion") }}
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2"
                                            >
                                                {{ __("project/projects.project.table.headers.options") }}
                                            </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($merged_projects as $project)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2">
                                                        <div class="my-auto">
                                                            <h6
                                                                class="mb-0 text-sm"
                                                            >
                                                                {{ $project->title }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p
                                                        class="text-sm font-weight-bold mb-0"
                                                    >
                                                        {{ $project->created_by }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-xs font-weight-bold"
                                                    >
                                                        done
                                                    </span>
                                                </td>
                                                <td
                                                    class="align-middle text-center"
                                                >
                                                    <div
                                                        class="d-flex align-items-center justify-content-center"
                                                    >
                                                        <span
                                                            class="me-2 text-xs font-weight-bold"
                                                        >
                                                            100%
                                                        </span>
                                                        <div>
                                                            <div
                                                                class="progress"
                                                            >
                                                                <div
                                                                    class="progress-bar bg-gradient-success"
                                                                    role="progressbar"
                                                                    aria-valuenow="100"
                                                                    aria-valuemin="0"
                                                                    aria-valuemax="100"
                                                                    style="
                                                                        width: 100%;
                                                                    "
                                                                ></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td
                                                    class="d-flex align-items-center justify-content-center"
                                                >
                                                    <a
                                                        href="{{ route("projects.show", $project->id_project) }}"
                                                        class="text-secondary font-weight-bold text-xs"
                                                        data-toggle="tooltip"
                                                        data-original-title="View Project"
                                                    >
                                                        {{ __("project/projects.project.options.view") }}
                                                        |
                                                    </a>
                                                    <a
                                                        href="{{ route("projects.edit", $project->id_project) }}"
                                                        class="text-secondary font-weight-bold text-xs"
                                                        data-toggle="tooltip"
                                                        data-original-title="Edit Project"
                                                    >
                                                        {{ __("project/projects.project.options.edit") }}
                                                        |
                                                    </a>
                                                    <a
                                                        href="{{ route("projects.add", $project->id_project) }}"
                                                        class="text-secondary font-weight-bold text-xs"
                                                        data-toggle="tooltip"
                                                        data-original-title="Add member"
                                                    >
                                                        {{ __("project/projects.project.options.add_member") }}
                                                        |
                                                    </a>
                                                    <form
                                                        id="delete-project-{{ $project->id_project }}"
                                                        action="{{ route("projects.destroy", $project) }}"
                                                        method="POST"
                                                        style="display: none"
                                                    >
                                                        @csrf
                                                        @method("DELETE")
                                                    </form>
                                                    <x-helpers.confirm-modal
                                                        modalTitle="{{ __('project/projects.project.modal.delete.title') }}"
                                                        modalContent="{{ __('project/projects.project.modal.delete.content') }}"
                                                        textClose="{{ __('project/projects.project.modal.delete.close') }}"
                                                        textConfirm="{{ __('project/projects.project.modal.delete.confirm') }}"
                                                        class="font-weight-bold text-xs btn btn-link text-danger text-gradient px-1 py-0 mb-0"
                                                        onConfirmNativeClick="document.getElementById('delete-project-{{ $project->id_project }}').submit();"
                                                    >
                                                        {{ __("project/projects.project.options.delete") }}
                                                    </x-helpers.confirm-modal>
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
        @include("layouts.footers.auth.footer")
    </div>
@endsection
