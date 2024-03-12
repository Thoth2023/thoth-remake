<div class="card-body col-md-6 pt-3">
    <div class="card">
        <div>
            <div class="card-header pb-0">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="mb-0">{{ __('project/planning.overall.keyword.title') }}</p>
                    @include ('components.help-button', ['dataTarget' => 'KeywordModal'])
                    <!-- Help Button Description -->
                    @include('components.help-modal', [
                        'modalId' => 'KeywordModal',
                        'modalLabel' => 'exampleModalLabel',
                        'modalTitle' => __('project/planning.overall.keyword.help.title'),
                        'modalContent' => __('project/planning.overall.keyword.help.content'),
                    ])
                </div>
            </div>
            <div class="card-body">
                <form role="form"
                    action="{{ route('project.planning.keywords.store', ['projectId' => $project->id_project]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control" type="text" name="description">
                                <input class="form-control" type="hidden" name="id_project"
                                    value="{{ $id_project }}">
                            </div>
                            <button type="submit"
                                class="btn btn-success mt-1">{{ __('project/planning.overall.keyword.add') }}</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive p-0">
                    <table class="table align-items-center justify-content-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('project/planning.overall.keyword.description') }}</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($projectKeywords as $keyword)
                                <tr>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $keyword->description }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <button type="button" style="padding: 7px;" class="btn btn-outline-secondary btn-group-sm btn-sm"
                                            class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal"
                                            data-bs-target="#modal-form{{ $keyword->id_keyword }}"
                                            data-original-title="{{ __('project/planning.overall.keyword.list.actions.edit.button') }}">
                                            {{ __('project/planning.overall.keyword.list.actions.edit.button') }}
                                        </button>
                                        <!-- Modal for Editing -->
                                        <div class="col-md-4">
                                            <div class="modal fade" id="modal-form{{ $keyword->id_keyword }}"
                                                tabindex="-1" role="dialog" aria-labelledby="modal-form"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-md"
                                                    role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="card card-plain">
                                                                <div class="card-header pb-0 text-left">
                                                                    <h3>
                                                                        {{ __('project/planning.overall.keyword.list.actions.edit.modal.title') }}
                                                                    </h3>
                                                                </div>
                                                                <div class="card-body">
                                                                    <form role="form text-left" method="POST"
                                                                        action="{{ route('project.planning.keywords.update', ['keyword' => $keyword, 'projectId' => $project->id_project]) }}">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <label>
                                                                            {{ __('project/planning.overall.keyword.list.actions.edit.modal.description') }}
                                                                        </label>
                                                                        <div class="input-group mb-3">
                                                                            <input class="form-control" type="text"
                                                                                name="description"
                                                                                value="{{ $keyword->description }}">
                                                                        </div>
                                                                        <div class="text-center">
                                                                            <button type="submit"
                                                                                class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">
                                                                                {{ __('project/planning.overall.keyword.list.actions.edit.modal.save') }}
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
                                            action="{{ route('project.planning.keywords.destroy', ['keyword' => $keyword, 'projectId' => $project->id_project]) }}"
                                            + method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="padding: 7px;" class="btn btn-outline-danger btn-group-sm btn-sm"
                                                class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                                data-original-title="{{ __('project/planning.overall.keyword.list.actions.delete.button') }}">
                                                {{ __('project/planning.overall.keyword.list.actions.delete.button') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        {{ __('project/planning.overall.keyword.list.empty') }}
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
