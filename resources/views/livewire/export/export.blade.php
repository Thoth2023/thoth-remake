<div>
<div>
    <div class="card card-frame mt-5">
        <div class="card-group justify-content-center">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <h3 class="card-title">Export</h3>
                            <p>What stage of the Review you</p>
                            <div class="checkbox-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="flexCheckDefault1" wire:model="checkbox1">
                                    <label class="form-check-label" for="flexCheckDefault1">
                                        Planning
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="flexCheckDefault2" wire:model="checkbox2">
                                    <label class="form-check-label" for="flexCheckDefault2">
                                        Import Study
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="flexCheckDefault3" wire:model="checkbox3">
                                    <label class="form-check-label" for="flexCheckDefault3">
                                        Study Selection
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="flexCheckDefault4" wire:model="checkbox4">
                                    <label class="form-check-label" for="flexCheckDefault4">
                                        Quality Assessment
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success mt-3" wire:click="generateBibTex">
                               Generate BibTex
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <div class="card card-frame mt-5">
        <div class="card-body">
            <div class="row">
                <div class="col-8" style="position: relative;">
                    <h3 class="card-title">BibTex</h3>
                    <div style="position: relative;">
                        <textarea name="bibTex-generated" class="form-control" id="bibTex-generated" rows="8" data-lt-tmp-id="lt-532503"
                            spellcheck="false" data-gramm="false" wire:model="template"> 
                        </textarea>
                        <div class="copy-icon-container">
                            <i class="fas fa-copy copy-icon" wire:click="copyToClipboard"></i>
                        </div>
                    </div>
                    <!-- Botão "Baixar" movido para dentro da div .col-8 -->
                    <div class="col-4">
                        <div id="error-message" style="color: red;">{{ session('error-message') }}</div>
                        <button type="submit" class="btn btn-success mt-3" wire:click="downloadAsLatex">
                           Download
                        </button>
                        <form id="overleafForm" action="https://www.overleaf.com/docs" method="post" target="_blank">
                            <input type="hidden" name="snip_uri" id="snip_uri">
                            <button type="button" class="btn btn-success mt-3" wire:click="createProjectOnOverleaf">
                              Create Project on Overleaf
                            </button>
                       </form>
                    </div>
                </div> <!-- Fechamento da div .col-8 -->
            </div> <!-- Fechamento da div .row -->
        </div> <!-- Fechamento da div .card-body -->
    </div> <!-- Fechamento da div .card -->
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            window.livewire.on('updateBibTex', function (bibTex) {
                document.getElementById('bibTex-generated').value = bibTex;
            });

            window.livewire.on('copyToClipboard', function () {
                var textarea = document.getElementById('bibTex-generated');
                textarea.select();
                document.execCommand('copy');
                alert('Texto copiado para a área de transferência!');
            });
        });
    </script>
@endpush
</div>