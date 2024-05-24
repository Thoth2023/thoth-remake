<div>
    <div class="card card-frame mt-5">
        <div class="card-body">
            <div class="row">
                <div class="col-8" style="position: relative;">
                    <h3 class="card-title">BibTex</h3>
                    <div style="position: relative;">
                        <textarea name="bibTex-generated" class="form-control" id="bibTex-generated" rows="8" data-lt-tmp-id="lt-532503"
                            spellcheck="false" data-gramm="false"> </textarea>
                        <div class="copy-icon-container">
                            <i class="fas fa-copy copy-icon" onclick="copyToClipboard()"></i>
                        </div>
                    </div>
                    <!-- Botão "Baixar" movido para dentro da div .col-8 -->
                    <div class="col-4">
                        <div id="error-message" style="color: red;"></div>
                        <button type="submit" class="btn btn-success mt-3" onclick="downloadAsLatex()">
                           Download
                        </button>
                        <form id="overleafForm" action="https://www.overleaf.com/docs" method="post" target="_blank">
                            <input type="hidden" name="snip_uri" id="snip_uri">
                            <button type="button" class="btn btn-success mt-3" onclick="createProjectOnOverleaf()">
                              Create Project on Overleaf
                            </button>
                       </form>


                    </div>
                </div> <!-- Fechamento da div .col-8 -->
            </div> <!-- Fechamento da div .row -->
        </div> <!-- Fechamento da div .card-body -->
    </div> <!-- Fechamento da div .card -->
</div>
</div>
