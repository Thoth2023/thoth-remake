<!-- data-extraction-question-form.blade.php -->

<div class="card-body col-md-6">
    <div class="card">
        <div class="card-header">
            <h5>Create Data Extraction Question</h5>
        </div>
        <div class="card-body">
            <form role="form" method="POST"
                action="{{ route('project.planning.data-extraction.question.store', ['projectId' => $project->id_project]) }}"
                enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="id" class="form-control-label">ID</label>
                    <input type="text" class="form-control" id="id" name="id" required>
                </div>

                <div class="form-group">
                    <label for="description" class="form-control-label">Description</label>
                    <input type="text" class="form-control" id="description" name="description" required>
                </div>

                <div class="form-group">
                    <label for="type" class="form-control-label">Type</label>
                    <select class="form-control" name="type" id="type" required>
                        @foreach ($questionTypes as $type)
                            <option value="{{ $type->id_type }}">{{ $type->type }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success mt-3">Add Question</button>
            </form>
        </div>
    </div>
</div>
