<div>
    @if(empty($abstract) || empty($keywords))
        <a class="btn py-1 px-3 btn-outline-primary" data-toggle="tooltip" data-original-title="Atualizar Dados Via CrossRef" wire:click="atualizarDadosFaltantes">
            <i class="fa-solid fa-refresh"></i>
            Via CrossRef
        </a>
        <a class="btn py-1 px-3 btn-outline-primary" data-toggle="tooltip" data-original-title="Atualizar Dados Via Springer" wire:click="atualizarDadosSpringer">
            <i class="fa-solid fa-refresh"></i>
            Via SpringerLink
        </a>
    @endif
        <div wire:ignore.self class="modal fade" id="successModalUpdate" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Success</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ session('successMessage') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
</div>
@script
<script>
    $wire.on('buttons-update-paper', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
