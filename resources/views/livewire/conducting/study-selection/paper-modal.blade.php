<div class="modal fade" id="paperModal" tabindex="-1" role="dialog" aria-labelledby="paperModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paperModalLabel">Paper Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($paper)
                <p><strong>Critérios de Inclusão:</strong> {{ $paper->criteria_acceptance }}</p>
                <p><strong>Critérios de Exclusão:</strong> {{ $paper->criteria_rejection }}</p>
                <div class="form-group">
                    <label for="inclusion">Atende os Critérios de Inclusão?</label>
                    <input type="checkbox" wire:model.defer="paper.criteria_inclusion">
                </div>
                <div class="form-group">
                    <label for="exclusion">Atende os Critérios de Exclusão?</label>
                    <input type="checkbox" wire:model.defer="paper.criteria_exclusion">
                </div>
                <div class="form-group">
                    <label for="notes">Notas:</label>
                    <textarea wire:model.defer="paper.notes" class="form-control"></textarea>
                </div>
                @else
                    <p>Hello World</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@script
    <script>
        $wire.on('showPaperModal', () => {
            $('#paperModal').modal('show');
        });
    </script>
@endscript