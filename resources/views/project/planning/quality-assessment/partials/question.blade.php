<!-- Question -->
<div class="card">
    <div class="card-header">
        Question
    </div>
    <div class="card-body">
        <form role="form" method="POST"
            action="{{ route('project.planning.quality-assessment.question.store', ['projectId' => $project->id_project]) }}"
            enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="id">ID</label>
                <input type="text" class="form-control" id="id" name="id" placeholder="ID">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description"
                    placeholder="Description">
            </div>

            <div class="form-group">
                <label for="weight" class="form-control-label">Weight</label>
                <input class="form-control" type="number" value="" step="0.5" id="weight" name="weight">
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>

    </div>
</div>
