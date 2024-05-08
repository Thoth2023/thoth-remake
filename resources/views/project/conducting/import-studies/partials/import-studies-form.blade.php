<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <form role="form" method="POST" action="{{ route('project.conducting-import-studies.imp.store', ['projectId' => $id_project]) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="database" class="form-control-label">{{ __('project/conducting-import-studies.form.import-database') }}</label>
                    <select class="form-control" name="import-database">
                        <option value="" disabled selected>{{ __('project/conducting-import-studies.form.select-import-database') }}</option>
                        @forelse ($databases as $database)
                            @if ($database->state == 'approved')
                                <option value="{{ $database->id_database }}">{{ $database->name }}</option>
                            @endif
                        @empty
                            <option disabled>{{ __('project/conducting-import-studies.form.no-import-databases') }}</option>
                        @endforelse
                    </select>
                </div>
                <input type="hidden" name="id_project" value="{{ $id_project }}">
                <input type="hidden" name="pre_selected" value="0">
                <button type="submit" class="btn btn-success mt-3">{{ __('project/conducting-import-studies.form.add') }}</button>
            </form>
        </div>
    </div>
</div>

