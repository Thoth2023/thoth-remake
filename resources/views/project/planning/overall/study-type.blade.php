<div class="card-body col-md-6 pt-3">
    <div class="card">
        <form role="form"
            action="{{ route('project.planning.studyTypes.store', ['projectId' => $project->id_project]) }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0">{{ __('project/planning.overall.study_type.title') }}</p>
                        @include ('components.help-button', ['dataTarget' => 'StudyTypeModal'])
                        <!-- Help Button Description -->
                        @include('components.help-modal', [
                            'modalId' => 'StudyTypeModal',
                            'modalLabel' => 'exampleModalLabel',
                            'modalTitle' => __('project/planning.overall.study_type.help.title'),
                            'modalContent' => __('project/planning.overall.study_type.help.content'),
                        ])
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input"
                                    class="form-control-label">{{ __('project/planning.overall.study_type.types') }}</label>
                                <select class="form-control" name="id_study_type">
                                    @forelse ($studyTypes as $studyType)
                                        <option value="{{ $studyType->id_study_type }}">{{ $studyType->description }}
                                        </option>
                                    @empty
                                        <option>{{ __('project/planning.overall.study_type.list.empty') }}</option>
                                    @endforelse
                                </select>
                                <input class="form-control" type="hidden" name="id_project"
                                    value="{{ $id_project }}">
                            </div>
                            <button type="submit"
                                class="btn btn-success mt-1">{{ __('project/planning.overall.study_type.add') }}</button>
                        </div>
                    </div>

        </form>
        <div class="table-responsive p-0">
            <table class="table align-items-center justify-content-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            {{ __('project/planning.overall.study_type.list.headers.types') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($project->studyTypes as $projectStudyType)
                        <tr>
                            <td>
                                <p class="text-sm font-weight-bold mb-0">
                                    {{ $projectStudyType->description }}</p>
                            </td>
                            <td class="align-middle">
                                <form
                                    action="{{ route('project.planning.studyTypes.destroy', ['study_type' => $projectStudyType, 'projectId' => $project->id_project]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="padding: 7px;" class="btn btn-outline-danger btn-group-sm btn-sm"
                                        class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                        data-original-title="{{ __('project/planning.overall.study_type.list.actions.delete.button') }}">
                                        {{ __('project/planning.overall.study_type.list.actions.delete.button') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                {{ __('project/planning.overall.study_type.list.empty') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>
