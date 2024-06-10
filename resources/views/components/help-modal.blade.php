<!-- help-modal.blade.php -->
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="{{ $modalLabel }}"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalLabel }}">{{ $modalTitle }}</h5>
                <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal" 
                        aria-label="Close"
                    >
                        <span class="text-secondary text-lg" aria-hidden="true">
                            <i class="fa fa-close"></i>
                        </span>
                    </button>
            </div>
            <div class="modal-body">
                {!! $modalContent !!}
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn bg-gradient-primary"
                    data-bs-dismiss="modal"
                >
                    {{ __("project/planning.button.close") }}
                </button>
            </div>
        </div>
    </div>
</div>
