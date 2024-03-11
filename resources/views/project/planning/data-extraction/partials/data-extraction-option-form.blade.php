<!-- data-extraction-option-form.blade.php -->

<div class="card-body col-md-6">
    <div class="card">
        <div class="card-header">
            <h5>Create Data Extraction Question Option</h5>
        </div>
        <div class="card-body">
            <form role="form" method="POST"
                action="{{ route('project.planning.data-extraction.option.store', ['projectId' => $project->id_project]) }}"
                enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="question-id" class="form-control-label">Question</label>
                    <select class="form-control" name="questionId" id="question-id">
                        @foreach ($project->questions as $question)
                            @if ($question->question_type->type === 'Multiple Choice List' || $question->question_type->type === 'Pick One List')
                                <option value="{{ $question->id_de }}">{{ $question->id }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="option" class="form-control-label">Option</label>
                    <input class="form-control" id="option" type="text" name="option">
                </div>

                <button type="submit" class="btn btn-success mt-3">Add Option</button>
            </form>
        </div>
    </div>
</div>
