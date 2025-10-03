<?php
// lang/pt/pages/add_member.php

return [
    // Títulos e Cabeçalhos
    'add_member' => 'Adicionar Membro',
    'current_members' => 'Membros Atuais',

    // Labels do Formulário
    'name'=>'Nome',
    'email'=>'E-mail',
    'status'=>'Status',
    'email_label' => 'Email', // NOVO
    'enter_email' => 'Insira o e-mail do usuário',
    'level' => 'Nível',
    'level_select' => 'Selecione um Nível',

    // Níveis
    'viewer' => 'Visualizador',
    'researcher' => 'Pesquisador',
    'reviser' => 'Revisor',
    'admin' => 'Administrador',

    // Níveis (Uso em Select) - NOVO para manter a UI em inglês no select, se for a intenção
    'level_viewer_short' => 'Viewer', // NOVO
    'level_researcher_short' => 'Researcher', // NOVO
    'level_reviser_short' => 'Reviser', // NOVO

    // Status
    'status_owner' => 'Proprietário',
    'status_pending' => 'Pendente',
    'status_declined' => 'Recusado',
    'status_accepted' => 'Aceito',

    // Botões e Ações
    'add' => 'Adicionar',
    'delete' => 'Remover',
    'delete_button' => 'Remover',
    'confirm' => 'Confirmar', // Corrigido para uso consistente
    'confirm_short' => 'Confirmar', // Chave curta (usada antes, mantida por segurança)

    // Tooltip
    'confirm_level_tooltip' => 'Confirmar mudança de nível do membro', // NOVO

    // Modais de Ajuda (Instruções)
    'instruction_email' => 'Instrução para E-mail',
    'instruction_level' => 'Níveis de Permissão',
    'user_registered' => 'O usuário precisa estar cadastrado no sistema para ser adicionado.',
    'got_it' => 'Entendi',

    // Modais de Permissões
    'level_viewer' => 'Visualizador',
    'level_viewer_description' => 'Pode apenas visualizar dados do projeto.',
    'level_researcher' => 'Pesquisador',
    'level_researcher_description' => 'Pode visualizar e adicionar novos dados (registros, etc).',
    'level_reviser' => 'Revisor',
    'level_reviser_description' => 'Pode visualizar, adicionar e editar dados de todos os Pesquisadores.',
    'level_administrator' => 'Administrador',
    'level_administrator_description' => 'Controle total sobre o projeto, incluindo gerenciar membros e configurações.',

    // Modais de Exclusão (NOVO)
    'modal_confirm_deletion_title' => 'Confirmar Exclusão', // NOVO
    'modal_confirm_deletion_body' => 'Tem certeza que deseja remover este membro?', // NOVO
    'cancel_button' => 'Cancelar', // NOVO
];
