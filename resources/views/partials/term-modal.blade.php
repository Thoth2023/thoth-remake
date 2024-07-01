<div class="modal fade" id="exampleModalMessage{{ $term->id_term }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalMessageTitle{{ $term->id_term }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Term Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {{-- <form action="{{ route('planning_search_string.update_term', $term->id_term) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="term-description{{ $term->id_term }}" class="col-form-label">Term:</label>
                        <input type="text" class="form-control" value="{{ $term->description }}"
                            id="term-description{{ $term->id_term }}" name="term-description">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn bg-gradient-info">Save</button>
                </div>
            </form> --}}
        </div>
    </div>
</div>
