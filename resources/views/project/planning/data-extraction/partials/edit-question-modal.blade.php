<!-- edit-question-modal.blade.php -->

<form class="m-1" role="form" method="POST"
    action="{{ route('project.planning.data-extraction.question.update', ['projectId' => $project->id_project, 'question' => $question]) }}"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <button type="button" style="padding: 7px;" class="btn btn-outline-secondary btn-group-sm btn-sm"
        data-bs-toggle="modal" data-bs-target="#questionModal_{{ $question->id_de }}">Edit</button>
    <div class="modal fade" id="questionModal_{{ $question->id_de }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Question</h5>
                </div>
                <div class="modal-body">
                    <label class="form-control-label" for="id">ID</label>
                    <input class="form-control" id="id" value="{{ $question->id }}" name="id" readonly>
                    <label class="form-control-label" for="description">Description</label>
                    <input class="form-control" id="description" value="{{ $question->description }}"
                        name="description">
                    <label class="form-control-lavel" for="type">Type</label>
                    <select class="form-control" name="type" id="type" placeholder="Departure">
                        <option value="{{ $question->question_type->id_type }}" selected>
                            {{ $question->question_type->type }}</option>
                        @foreach ($types as $type)
                            @if ($type->id_type !== $question->question_type->id_type)
                                <option value="{{ $type->id_type }}">{{ $type->type }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-gradient-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
