<!--<style>
    .bt-custom {
        background-color: #34476727 !important
    }

    .bt-custom:hover {
        color: #fb6340;
    }
</style>

<div class="d-grid gap-2 d-md-flex justify-content-md-end me-3">
    <button class="btn btn-primary btn-sm active bt-custom" role="button" aria-pressed="true" type="button">Prev</button>
    <button class="btn btn-primary btn-sm active bt-custom" role="button" aria-pressed="true" type="button">Next</button>
</div>
-- CODIGO MOD 11/4/25
<-- Importando os ícones do Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<!-- Estilo personalizado criado por Luiza Velasque -->
<style>
    /* Estilo base para os botões customizados */
    .bt-custom {
        background-color: #f8f9fa;         /* Cor de fundo clara (cinzinha) */
        color: #344767;                    /* Cor do texto azul acinzentado */
        border: 1px solid #ced4da;         /* Borda discreta */
        transition: all 0.3s ease;         /* Animação suave ao passar o mouse */
        border-radius: 0.5rem;             /* Cantos arredondados */
        padding: 0.5rem 1rem;              /* Espaçamento interno do botão */
        font-weight: 500;                  /* Peso da fonte um pouco mais forte */
    }

    /* Efeito hover: ao passar o mouse por cima */
    .bt-custom:hover {
        background-color: #e9ecef;         /* Cor de fundo mais clara */
        color: #fb6340;                    /* Muda a cor do texto para laranja */
        border-color: #fb6340;             /* Borda também fica laranja */
    }
</style>

<!-- Bloco dos botões centralizado -->
<div class="d-flex justify-content-center gap-2 my-3">
    <!-- Botão "Prev" com ícone de seta para a esquerda -->
    <button class="btn btn-sm bt-custom" type="button">
        <i class="bi bi-arrow-left"></i> Prev
    </button>

    <!-- Botão "Next" com ícone de seta para a direita -->
    <button class="btn btn-sm bt-custom" type="button">
        Next <i class="bi bi-arrow-right"></i>
    </button>
</div>
