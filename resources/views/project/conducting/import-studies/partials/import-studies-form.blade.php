<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <form role="form" method="POST"
                action="{{ route('project.conducting-import-studies.imp.store', ['projectId' => $id_project]) }}"
                enctype="multipart/form-data">
                @csrf
                <label for="example-text-input"
                    class="form-control-label">{{ __('project/conducting-import-studies.form.database') }}</label>
                <select class="form-control" name="database">
                    <option value="Google">{{ __('project/conducting-import-studies.form.google') }}</option>
                </select>

                <input class="form-control" type="hidden" name="id_project" value="{{ $id_project }}">
                <input class="form-control" type="hidden" name="pre_selected" value="0">

                <button type="submit"
                    class="btn btn-success mt-3">{{ __('project/conducting-import-studies.form.add') }}</button>
            </form>
        </div>
    </div>
</div>
