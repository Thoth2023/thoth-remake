<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <form role="form" method="POST"
                action="{{ route('project.planning.criteria.store', ['projectId' => $id_project]) }}"
                enctype="multipart/form-data">
                @csrf
                <label for="example-text-input"
                    class="form-control-label">{{ __('project/planning.criteria.form.id') }}</label>
                    <input class="form-control" type="text" name="id" required pattern="[a-zA-Z0-9]+" placeholder="{{ __('project/planning.criteria.form.dont-use') }}">

                <label for="example-text-input"
                    class="form-control-label">{{ __('project/planning.criteria.form.description') }}</label>
                <input class="form-control" type="text" name="description" required>

                <label for="example-text-input"
                    class="form-control-label">{{ __('project/planning.criteria.form.type') }}</label>
                <select class="form-control" name="type">
                    <option value="Inclusion">{{ __('project/planning.criteria.form.inclusion') }}</option>
                    <option value="Exclusion">{{ __('project/planning.criteria.form.exclusion') }}</option>
                </select>

                <input class="form-control" type="hidden" name="id_project" value="{{ $id_project }}">
                <input class="form-control" type="hidden" name="pre_selected" value="0">

                <button type="submit"
                    class="btn btn-success mt-3">{{ __('project/planning.criteria.form.add') }}</button>
            </form>
        </div>
    </div>
</div>
