<?php

return [
    'project' => [
        'title' => 'Projetos',
        'new' => 'Novo Projeto',
        'table' => [
            'title' => 'Meus Projetos',
            'empty' => 'Nenhum projeto encontrado.',
            'add' => 'Novo Projeto',
            'headers' => [
                'title' => 'Nome',
                'created_by' => 'Criado por',
                'status' => 'Status',
                'completion' => 'Andamento',
                'options' => 'Opções',
            ],
        ],
        'modal' => [
            'delete' => [
                'title' => 'Deletar Projeto',
                'content' => 'Tem certeza de que deseja excluir este projeto? Esta ação não pode ser desfeita. Você perderá todos os dados associados a este projeto.',
                'close' => 'Fechar',
                'confirm' => 'Confirmar',
            ],
        ],
        'options' => [
            'delete' => 'Deletar',
            'edit' => 'Editar',
            'view' => 'Abrir',
            'add_member' => 'Equipe',
            'open_project' => 'Abrir Projeto',
        ],
    ],

    'errors' => [
        'email_required' => 'O campo e-mail é obrigatório.',
        'email_invalid' => 'Digite um e-mail válido.',
        'level_required' => 'Você deve selecionar um nível de acesso.',
        'level_integer' => 'O formato do nível é inválido.',
        'level_between' => 'O nível deve estar entre 2 e 4.',
    ],

    'email' => [
        'greeting' => 'Olá :name,',
        'invited' => 'Você foi convidado para participar do projeto: :project',
        'accept_button' => 'Aceitar convite',
        'register_button' => 'Criar conta e entrar no projeto',
        'decline_text' => 'Se você não deseja participar, pode <a href=":url">recusar o convite</a>.',
        'regards' => 'Atenciosamente',
        'subcopy' => "Se você tiver problemas ao clicar no botão \":actionText\", copie e cole a URL abaixo\nno seu navegador:",
        'subject_invitation' => 'Thoth SLR :: Convite para participar do projeto: :project',
    ],

    'no_access_project' => 'Você não tem permissão para acessar este projeto.',
    'no_permission_edit' => 'Você não tem permissão para editar este projeto.',
    'no_permission_delete' => 'Você não tem permissão para excluir este projeto.',
    'no_permission_remove_member' => 'Você não tem permissão para remover membros deste projeto.',
    'no_permission_add_member' => 'Você não tem permissão para adicionar membros neste projeto.',
    'no_permission_update_level' => 'Você não tem permissão para atualizar o nível do membro.',
    'no_permission_resend' => 'Você não tem permissão para reenviar o convite.',

    'user_already_in_project' => 'O usuário já está associado ao projeto.',
    'member_not_found' => 'Membro não encontrado.',

    'invite_sent' => 'Convite enviado para :email',
    'invite_resent' => 'Convite reenviado com sucesso!',
    'invite_already_accepted' => 'Este usuário já aceitou o convite.',
    'invite_invalid' => 'Convite inválido ou expirado.',
    'invite_accepted' => 'Você entrou no projeto com sucesso!',

    'level_updated' => 'Nível do membro atualizado com sucesso.',

    'activity_created' => 'Projeto :title criado com sucesso.',
    'activity_updated' => 'Projeto atualizado.',
    'activity_deleted' => 'Projeto :title excluído.',
    'activity_member_removed' => 'O administrador removeu o membro :user do projeto :title.',
    'activity_level_updated' => 'O administrador atualizou o nível do usuário :user para :level.',
    'activity_invite_sent' => 'Convite enviado para :user participar do projeto :title.',
    'activity_invite_accepted' => 'Convite aceito para participar do projeto.',

    // Mensagens ao convidar usuário sem conta
    'guest_user_created' => 'Um usuário convidado foi criado para :email.',
    'guest_invite_success' => 'Convite enviado para o usuário convidado :email.',
    'must_register_first' => 'Para acessar este convite, você precisa concluir seu cadastro.',

    // Sucesso ao aceitar convite
    'invitation_accepted' => 'Convite aceito com sucesso! Bem-vindo ao projeto.',
    'invitation_declined' => 'Você recusou o convite para participar do projeto.',


];
