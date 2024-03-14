<button class="border-0 bg-transparent" data-bs-toggle="modal"
    data-bs-target="#general-scoreModal_{{ $generalScore->id_general_score }}">
    <i class="fas fa-user-edit text-secondary" aria-hidden="true"></i>
</button>
<form class="m-1" role="form" method="POST"
    action="{{ route('project.planning.quality-assessment.general-score.update', ['projectId' => $project->id_project, 'general_score' => $generalScore]) }}"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="modal fade" id="general-scoreModal_{{ $generalScore->id_general_score }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit General Score</h5>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Min</span>
                            <input value="{{ $generalScore->start }}" name="start" min="0.0" step="5"
                                max="100" type="number" class="form-control" placeholder="minScore"
                                aria-label="minScore" aria-describedby="basic-addon1">
                            <span class="input-group-text" id="maxScore">Max</span>
                            <input value="{{ $generalScore->end }}" name="end" min="0.0" step="5"
                                max="100" type="number" class="form-control" placeholder="maxScore"
                                aria-label="maxScore" aria-describedby="maxScore">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <input value="{{ $generalScore->description }}" name="description" type="text"
                            class="form-control" id="description" placeholder="Enter description">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-gradient-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
