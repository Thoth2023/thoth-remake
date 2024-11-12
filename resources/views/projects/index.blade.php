@extends("layouts.app", ["class" => "g-sidenav-show bg-gray-100"])

@section("content")
    @include("layouts.navbars.auth.topnav", ["title" => __("project/projects.project.title")])

    <div class="container-fluid py-2">
        <div class="container-fluid py-2">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>
                                        <i class="ni ni-single-copy-04 text-primary text-sm opacity-10"></i>
                                        {{ __("project/projects.project.table.title") }}
                                    </h4>
                                </div>
                                <div class="col-md-6 text-end">
                                    <a class="btn bg-gradient-dark mb-0" href="{{ route("projects.create") }}">
                                        <i class="fas fa-plus"></i>
                                        &nbsp;&nbsp;{{ __("project/projects.project.new") }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            {{ __("project/projects.project.table.headers.title") }}
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            {{ __("project/projects.project.table.headers.created_by") }}
                                        </th>

                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                            {{ __("project/projects.project.table.headers.completion") }}
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                            {{ __("project/projects.project.table.headers.options") }}
                                        </th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($merged_projects as $project)
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
                                                <p class="text-sm font-weight-bold mb-0">
                                                    {{ $project->created_by }}
                                                </p>
                                            </td>

                                            <td class="align-middle text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                        <span class="me-2 text-xs font-weight-bold">
                                                            100%
                                                        </span>
                                                    <div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-end">
                                                    @can('access-project', $project)
                                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                                        <a class="btn py-1 px-3 btn-outline-success" data-toggle="tooltip" data-original-title="View Project" href="{{ route("projects.show", $project->id_project) }}">
                                                            <i class="fas fa-search-plus"></i>
                                                            {{ __("project/projects.project.options.view") }}
                                                        </a>
                                                        <a class="btn py-1 px-3 btn-outline-secondary" data-toggle="tooltip" data-original-title="Edit Project" href="{{ route("projects.edit", $project->id_project) }}">
                                                            <i class="fas fa-edit"></i>
                                                            {{ __("project/projects.project.options.edit") }}
                                                        </a>
                                                        <a class="btn py-1 px-3 btn-outline-dark" data-toggle="tooltip" data-original-title="Add member" href="{{ route("projects.add", $project->id_project) }}">
                                                            <i class="fas fa-user-check"></i>
                                                            {{ __("project/projects.project.options.add_member") }}
                                                        </a>
                                                    </div>
                                                    <form id="delete-project-{{ $project->id_project }}" action="{{ route("projects.destroy", $project) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method("DELETE")
                                                    </form>
                                                    <x-helpers.confirm-modal modalTitle="{{ __('project/projects.project.modal.delete.title') }}" modalContent="{{ __('project/projects.project.modal.delete.content') }}" textClose="{{ __('project/projects.project.modal.delete.close') }}" textConfirm="{{ __('project/projects.project.modal.delete.confirm') }}" class="font-weight-bold btn btn-link text-danger px-1 py-0 mb-0" onConfirmNativeClick="document.getElementById('delete-project-{{ $project->id_project }}').submit();">
                                                        <a class="btn py-1 px-3 btn-outline-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </x-helpers.confirm-modal>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
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
    <!-- Modal LGPD -->
    <div class="modal fade" id="lgpdModal" tabindex="-1" aria-labelledby="lgpdModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content modal-transparent">
                <div class="modal-header">
                    <h5 class="modal-title" id="lgpdModalLabel"><i class="fas fa-user-shield me-1"></i>{{ __("pages/home.terms_and_lgpd") }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __("pages/terms.modal_lgpd") }}</p>
                    <a href="/terms"><i class="fas fa-file-alt"></i>{{ __("pages/home.terms_and_conditions") }}</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="acceptTermsAndLgpd()">
                        Entendi
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @if(session('show_lgpd_modal'))
                var lgpdModal = new bootstrap.Modal(document.getElementById('lgpdModal'));
                lgpdModal.show();
                @endif
            });

            function acceptTermsAndLgpd() {
                fetch("{{ route('accept.lgpd') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            var lgpdModal = bootstrap.Modal.getInstance(document.getElementById('lgpdModal'));
                            lgpdModal.hide();
                        }
                    })
                    .catch(error => console.error('Erro:', error));
            }
        </script>
    @endpush
    @push('scripts')
        <script>
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    @endpush
@endsection
