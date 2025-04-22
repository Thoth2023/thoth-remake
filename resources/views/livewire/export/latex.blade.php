<div style="height: 620px;" class="card my-2 p-2">
    <div class="card-header mb-0 pb-0">
        <x-helpers.modal
            target="latex"
            modalTitle="{{ translationExport('header.latex.title') }}"
            modalContent="{!! translationExport('header.latex.help-content') !!}"
        />
    </div>

    <div class="d-flex flex-column mb-2">
        <div class="d-flex flex-column mt-1">
        <div>
            <label>
                <input type="checkbox" wire:model="selectedOptions" wire:change="generateLatex" value="planning">
                Planning
            </label>
            <label>
                <input type="checkbox" wire:model="selectedOptions" wire:change="generateLatex" value="import_studies">
                Import Studies
            </label>
            <label>
                <input type="checkbox" wire:model="selectedOptions" wire:change="generateLatex" value="study_selection">
                Study Selection
            </label>
            <label>
                <input type="checkbox" wire:model="selectedOptions" wire:change="generateLatex" value="quality_assessment">
                Quality Assessment
            </label>
            <label>
                <input type="checkbox" wire:model="selectedOptions" wire:change="generateLatex" value="snowballing">
                Snowballing
            </label>
        </div>

        <div class="d-flex flex-column mt-3">
            <textarea
                class="form-control overflow-auto"
                style="height: 400px;"
                id="description"
                placeholder="{{ translationExport('header.latex.enter_description') }}"
                readonly
            >{{ $description }}</textarea>
        </div>

    </div>
    </div>

    <div class="align-self-center mt-1">
        <!-- Botão de Copiar -->
        <button type="button" class="btn btn-secondary mb-0" id="copyButton">
            <i class="fas fa-copy"></i>
            {{ __("project/export.button.copy-latex") }}
        </button>

        <button type="button" class="btn btn-primary mb-0" wire:click="exportToOverleaf">
            <i class="fas fa-add"></i>
            {{ __("project/export.button.overleaf") }}
        </button>
    </div>

    <div wire:ignore.self class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
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

@section('scripts')
    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const copyButton = document.getElementById('copyButton');
                const descriptionTextarea = document.getElementById('description');

                copyButton.addEventListener('click', function () {
                    if (descriptionTextarea) {
                        // Seleciona o texto do textarea
                        descriptionTextarea.select();
                        // Copia o texto para a área de transferência
                        document.execCommand('copy');

                        // Exibe uma mensagem de sucesso (opcional)
                        alert('Conteúdo copiado para a área de transferência!');
                    } else {
                        alert('Nada para copiar!');
                    }
                });
            });

            document.addEventListener('abrirNovaAba', function (event) {
                const url = event.detail[0]?.url;
                window.open(url, '_blank');
            });

            // Mostrar o modal de sucesso ao evento Livewire
            Livewire.on('show-success-modal', () => {
                $('#successModal').modal('show'); // Abre o modal de sucesso
            });


        </script>
    @endpush
@endsection
