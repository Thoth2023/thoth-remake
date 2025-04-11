<!-- Componente: help-button.blade.php -->
<!-- Botão de ajuda com design arredondado e acionamento de modal Bootstrap -->

<!-- help-button.blade.php 
<button type="button" class="btn btn-primary rounded-circle p-0 m-0" data-bs-toggle="modal"
    data-bs-target="#{{ $dataTarget }}" style="width: 2em; height: 2em; font-size: 1rem;">?</button>
-->
<!--Modificação por Luiza velasque em 11/4 -->

<button
    type="button"
    class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center shadow-sm"
    data-bs-toggle="modal"
    data-bs-target="#{{ $dataTarget }}"
    style="width: 2.2em; height: 2.2em; font-size: 1rem;"
    aria-label="Ajuda"
    title="Ajuda"
>
    <strong>?</strong>
</button>
