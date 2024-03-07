<div class="card-group card-frame mt-5">
    <div class="card">
        <form role="form" method="POST" action="{{ route('project.planning_overall.studyTAdd') }}" enctype="multipart/form-data">
            @csrf
            <div>
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Study type</p>
                        <button type="button" class="help-thoth-button" data-bs-toggle="modal" data-bs-target="#StudyTypeModal">?</button>
                        <!-- Help Button Description -->
                        <div class="modal fade" id="StudyTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Help for Study type</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Help content goes here -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Help Description Ends Here -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Types</label>
                                <select class="form-control" name="id_study_type">
                                    @forelse ($studyTypes as $studyType)
                                    <option value="{{ $studyType->id_study_type }}">{{ $studyType->description }}</option>
                                    @empty
                                    <option>No study types in the database.</option>
                                    @endforelse
                                </select>
                                <input class="form-control" type="hidden" name="id_project" value="{{ $id_project }}">
                            </div>
                            <button type="submit" class="btn btn-success mt-3">Add</button>
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
                            <p class="text-sm font-weight-bold mb-0"><?=convert_study_type_name($pStudyType->id_study_type)?></p>
                        </td>
                        <td class="align-middle">
                            <form action="{{ route('project.planning_overall.studyTDestroy', $pStudyType->id_study_type) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button style="border:0; background: none; padding: 0px;" type="submit" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete study type">Delete</button>
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
    <hr class="horizontal dark">
</div>
