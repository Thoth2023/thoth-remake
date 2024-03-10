<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <form role="form" method="POST"
                action="{{ route('project.planning.criteria.store', ['projectId' => $id_project]) }}"
                enctype="multipart/form-data">
                @csrf
                <label for="example-text-input" class="form-control-label">ID</label>
                <input class="form-control" type="text" name="id" required>

                <label for="example-text-input" class="form-control-label">Description</label>
                <input class="form-control" type="text" name="description" required>

                <label for="example-text-input" class="form-control-label">Type</label>
                <select class="form-control" name="type">
                    <option value="Inclusion">Inclusion</option>
                    <option value="Exclusion">Exclusion</option>
                </select>

                <input class="form-control" type="hidden" name="id_project" value="{{ $id_project }}">
                <input class="form-control" type="hidden" name="pre_selected" value="0">

                <button type="submit" class="btn btn-success mt-3">Add</button>
            </form>
        </div>
    </div>
</div>
