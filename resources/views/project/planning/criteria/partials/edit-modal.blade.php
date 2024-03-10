<div class="modal fade" id="modal-form{{ $criterion->id_criteria }}" tabindex="-1" role="dialog"
    aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Criteria Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="POST"
                    action="{{ route('project.planning.criteria.update', ['projectId' => $project->id_project, 'criterion' => $criterion]) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label">ID</label>
                        <input class="form-control" type="text" name="id" value="{{ $criterion->id }}" required>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label">Description</label>
                        <input class="form-control" type="text" name="description"
                            value="{{ $criterion->description }}" required>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label">Type</label>
                        <select class="form-control" name="type">
                            <option value="{{ $criterion->type }}">{{ $criterion->type }}</option>
                            <option value="Exclusion">Exclusion</option>
                        </select>
                    </div>
                    <input class="form-control" type="hidden" name="id_project" value="{{ $id_project }}">
                    <input class="form-control" type="hidden" name="pre_selected"
                        value="{{ $criterion->pre_selected }}">
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-gradient-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
