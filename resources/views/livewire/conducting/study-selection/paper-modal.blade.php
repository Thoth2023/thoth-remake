<div class="modal fade" id="paperModal" tabindex="-1" role="dialog" aria-labelledby="paperModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paperModalLabel">Paper Details</h5>
                <button type="button" data-bs-dismiss="modal" class="btn">
                    <span aria-hidden="true">X</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($paper)
                    <div class="d-flex gap-1 mb-3">
                        <p>Title: {{ $paper['title'] }}</p>
                        <p>Database: {{ $paper['data_base'] }}</p>
                    </div>
                    <table class="table table-striped table-bordered mb-3">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>ID</th>
                                <th>Description</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($criterias as $criteria)
                            <tr>
                                <td class="d-flex align-items-center justify-content-center">
                                    <input type="checkbox" wire:model="selected_criterias" value="{{ $criteria['id_criteria'] }}">
                                </td>
                                <td>{{ $criteria['id'] }}</td>
                                <td>{{ $criteria['description'] }}</td>
                                <td>{{ $criteria['type'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <hr />

                    <p>Select an option</p>

                    <div class="btn-group mt-2" role="group">
                        <input type="radio" class="btn-check" wire:model="selected_status" value="Removed" name="btnradio" id="btnradio1" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio1">Remove</label>

                        <input type="radio" class="btn-check" wire:model="selected_status" value="Accepted" name="btnradio" id="btnradio2" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio2">Accept</label>

                        <input type="radio" class="btn-check" wire:model="selected_status" value="Rejected" name="btnradio" id="btnradio3" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio3">Reject</label>

                        <input type="radio" class="btn-check" wire:model="selected_status" value="Duplicated" name="btnradio" id="btnradio4" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio4">Duplicated</label>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" wire:click="save">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@script
<script>
     $(document).ready(function(){
            $wire.on('show-paper', () => {
                console.log("show-paper")
                $('#paperModal').modal('show');
            });
        });
</script>
@endscript

@script
<script>
    $wire.on('paper-modal', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
