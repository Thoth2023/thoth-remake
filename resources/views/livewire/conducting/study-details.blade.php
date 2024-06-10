<div>
   <!-- resources/views/livewire/study-details.blade.php -->
<div wire:ignore.self class="modal fade" id="studyDetailsModal" tabindex="-1" aria-labelledby="studyDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studyDetailsModalLabel">Study Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="saveStudyDetails">
                    <div class="mb-3">
                        <label for="studyId" class="form-label">ID</label>
                        <input type="text" class="form-control" id="studyId" wire:model="study.id" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="studyDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="studyDescription" wire:model="study.description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="studyScore" class="form-label">Score</label>
                        <input type="number" class="form-control" id="studyScore" wire:model="study.score">
                    </div>
                    <div class="mb-3">
                        <label for="studyNotes" class="form-label">Notes</label>
                        <textarea class="form-control" id="studyNotes" wire:model="study.notes"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" wire:click="saveStudyDetails">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    Livewire.on('openModal', () => {
        $('#studyDetailsModal').modal('show');
    });

    Livewire.on('closeModal', () => {
        $('#studyDetailsModal').modal('hide');
    });
</script>

</div>
