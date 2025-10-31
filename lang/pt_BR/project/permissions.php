<?php

return [

    'modal' => [
        'title' => 'Entendendo as permissões de acesso',
        'content' => '
<p>O sistema possui diferentes níveis de permissão para membros de projetos. Cada nível determina quais ações o usuário pode realizar.</p>

<style>
.permission-table {
    font-size: 0.85rem;
}
.permission-table th,
.permission-table td {
    white-space: nowrap;
    padding: 6px 10px;
}
.permission-wrapper {
    max-width: 100%;
    overflow-x: auto;
}
</style>

<div class="permission-wrapper mt-3">
<table class="table table-bordered permission-table">
<thead>
    <tr>
        <th>Nível</th>
        <th>Status</th>
        <th>Protocolo</th>
        <th>Visualizar</th>
        <th>Gerenciar</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td><strong>Administrador</strong></td>
        <td>Qualquer</td>
        <td>✅</td>
        <td>✅</td>
        <td>✅</td>
    </tr>
    <tr>
        <td><strong>Pesquisador/Revisor </strong></td>
        <td>Aceito</td>
        <td>✅</td>
        <td>✅</td>
        <td>❌</td>
    </tr>
    <tr>
        <td><strong>Pesquisador/Revisor </strong></td>
        <td>Pendente</td>
        <td>✅</td>
        <td>❌</td>
        <td>❌</td>
    </tr>
    <tr>
        <td><strong>Visualizador</strong></td>
        <td>Aceito/Pendente</td>
        <td>✅</td>
        <td>❌</td>
        <td>❌</td>
    </tr>
    <tr>
        <td><strong>Usuário Externo</strong></td>
        <td>Projeto público</td>
        <td>✅</td>
        <td>❌</td>
        <td>❌</td>
    </tr>
    <tr>
        <td><strong>Usuário Externo</strong></td>
        <td>Projeto privado</td>
        <td>❌</td>
        <td>❌</td>
        <td>❌</td>
    </tr>
</tbody>
</table>
</div>
        ',
        'close' => 'Fechar',
    ],

];
