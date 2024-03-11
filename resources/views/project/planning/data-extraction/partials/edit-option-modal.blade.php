<!-- edit-option-modal.blade.php -->

<form class="m-1" role="form" method="POST"
    action="{{ route('project.planning.data-extraction.option.update', [$project->id_project, $option->id_option]) }}"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
        data-bs-target="#optionModal_{{ $option->id_option }}">Edit</button>
    <div class="modal fade" id="optionModal_{{ $option->id_option }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Option</h5>
                </div>
                <div class="modal-body">
                    <label class="form-control-label" for="option">Option</label>
                    <input class="form-control" type="text" id="option" name="option"
                        value="{{ $option->description }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn bg-gradient-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
