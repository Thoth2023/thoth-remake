<div class="card-body col-md-6 pt-3">
    <div class="card">
        <form role="form" method="POST" action="{{ route('project.planning_overall.studyTAdd') }}"
            enctype="multipart/form-data">
            @csrf
            <div>
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0">Study type</p>
                        @include ('components.help-button', ['dataTarget' => 'StudyTypeModal'])

                        <!-- Help Button Description -->
                        @include('components.help-modal', [
                            'modalId' => 'StudyTypeModal',
                            'modalLabel' => 'exampleModalLabel',
                            'modalTitle' => 'Help for Keywords',
                            'modalContent' => 'test',
                        ])
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Types</label>
                                <select class="form-control" name="id_study_type">
                                    @forelse ($studyTypes as $studyType)
                                        <option value="{{ $studyType->id_study_type }}">{{ $studyType->description }}
                                        </option>
                                    @empty
                                        <option>No study types in the database.</option>
                                    @endforelse
                                </select>
                                <input class="form-control" type="hidden" name="id_project"
                                    value="{{ $id_project }}">
                            </div>
                            <button type="submit" class="btn btn-success mt-1">Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="table-responsive p-0">
            <table class="table align-items-center justify-content-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Types</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projectStudyTypes as $pStudyType)
                        <tr>
                            <td>
                                <p class="text-sm font-weight-bold mb-0">
                                    <?= convert_study_type_name($pStudyType->id_study_type) ?></p>
                            </td>
                            <td class="align-middle">
                                <form
                                    action="{{ route('project.planning_overall.studyTDestroy', $pStudyType->id_study_type) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button style="border:0; background: none; padding: 0px;" type="submit"
                                        class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                        data-original-title="Delete study type">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No study types found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
