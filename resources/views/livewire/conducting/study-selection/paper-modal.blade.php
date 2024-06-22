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
                    <p>{{ $paper['title'] }}</p>
                    <p>{{ $paper['data_base'] }}</p>
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