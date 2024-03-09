<div class="card-body col-md-6 pt-3">
    <div class="card">

        <form role="form" method="POST"
            action="{{ route('project.planning.domains.store', ['projectId' => $project->id_project]) }}"
            enctype="multipart/form-data">
            @csrf
            <div>
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0">{{ __('project/planning.overall.domain.title') }}</p>
                        @include ('components.help-button', ['dataTarget' => 'DomainModal'])
                        <!-- Help Button Description -->
                        @include('components.help-modal', [
                            'modalId' => 'DomainModal',
                            'modalLabel' => 'exampleModalLabel',
                            'modalTitle' => __('project/planning.overall.domain.help.title'),
                            'modalContent' => __('project/planning.overall.domain.help.content'),
                        ])
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">
                                    {{ __('project/planning.overall.domain.description') }}
                                </label>
                                <input class="form-control" type="text" name="description">
                                <input class="form-control" type="hidden" name="id_project"
                                    value="{{ $id_project }}">
                            </div>
                            <button type="submit" class="btn btn-success mt-1">
                                {{ __('project/planning.overall.domain.add') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="table-responsive p-0">
            <table class="table align-items-center justify-content-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            {{ __('project/planning.overall.domain.description') }}
                        </th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projectDomains as $domain)
                        <tr>
                            <td>
                                <p class="text-sm font-weight-bold mb-0">{{ $domain->description }}</p>
                            </td>
                            <td class="align-middle">
                                <button style="border:0; background: none; padding: 0px;" type="button"
                                    class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal"
                                    data-bs-target="#modal-domain-{{ $domain->id_domain }}"
                                    data-original-title="{{ __('project/planning.overall.domain.list.actions.edit.button') }}">
                                    {{ __('project/planning.overall.domain.list.actions.edit.button') }}
                                </button>
                                <!-- Modal for Editing -->
                                <div class="col-md-4">
                                    <div class="modal fade" id="modal-domain-{{ $domain->id_domain }}" tabindex="-1"
                                        role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body p-0">
                                                    <div class="card card-plain">
                                                        <div class="card-header pb-0 text-left">
                                                            <h3>
                                                                {{ __('project/planning.overall.domain.list.actions.edit.modal.title') }}
                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <form role="form text-left" method="POST"
                                                                action="{{ route('project.planning.domains.update', ['domain' => $domain, 'projectId' => $project->id_project]) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <label>
                                                                    {{ __('project/planning.overall.domain.list.actions.edit.modal.description') }}
                                                                </label>
                                                                <div class="input-group mb-3">
                                                                    <input class="form-control" type="text"
                                                                        name="description"
                                                                        value="{{ $domain->description }}">
                                                                </div>
                                                                <div class="text-center">
                                                                    <button type="submit"
                                                                        class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">
                                                                        {{ __('project/planning.overall.domain.list.actions.edit.modal.save') }}
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Ends Here -->
                            </td>
                            <td class="align-middle">
                                <form
                                    action="{{ route('project.planning.domains.destroy', ['domain' => $domain, 'projectId' => $project->id_project]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="border:0; background: none; padding: 0px;"
                                        class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                        data-original-title="{{ __('project/planning.overall.domain.list.actions.delete.button') }}">
                                        {{ __('project/planning.overall.domain.list.actions.delete.button') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                {{ __('project/planning.overall.domain.list.empty') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
