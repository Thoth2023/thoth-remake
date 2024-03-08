<div class="modal fade" id="modal-delete-{{ $term->id_term }}_{{ $synonym->id_synonym }}" tabindex="-1" role="dialog"
     aria-labelledby="modal-delete-{{ $term->id_term }}_{{ $synonym->id_synonym }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-delete-{{ $term->id_term }}_{{ $synonym->id_synonym }}">Confirm
                    Deletion</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this synonym?</p>
            </div>
            <div class="modal-footer">
                <form class="form-unstyled"
                      action="{{ route('planning_search_string.destroy_synonym', $synonym->id_synonym) }}" method="post">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
