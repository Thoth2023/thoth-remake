<?php

return [
    'overview' => 'Visão Geral',

    'project' => 'Projeto',
    'description' => 'Descrição',
    'objectives' => 'Objetivos',
    'members' => 'Membros',

    'progress' => 'Progresso da Revisão Sistemática',
    'planning' => 'Planejamento',
    'conducting' => 'Condução',
    'study-selection' => 'Seleção de Estudos',
    'quality_assessment' => 'Avaliação de Qualidade',
    'snowballing' => 'Snowballing',
    'data_extraction' => 'Extração de Dados',

    'project_status' => 'Status do Projeto',
    'finished_project' => 'Projeto finalizado',
    'ongoing_project' => 'Projeto em andamento',
    'mark_as_finished' => 'Marcar como finalizado',
    'mark_as_ongoing' => 'Marcar como em andamento',

    'project_status_help' => [
        'title' => 'Como funcionam o progresso e o status do projeto?',
        'content' => '
        <p>As barras de progresso exibidas nesta tela representam o progresso individual do usuário atualmente logado no sistema.</p>

        <p>Cada pesquisador visualiza apenas o seu próprio progresso nas atividades da revisão sistemática, como:</p>

        <ul>
            <li>Seleção de Estudos</li>
            <li>Avaliação de Qualidade</li>
            <li>Extração de Dados</li>
            <li>Snowballing (quando habilitado)</li>
        </ul>

        <p>Por esse motivo, diferentes membros do mesmo projeto podem visualizar percentuais distintos de progresso.</p>

        <hr>

        <p>O status do projeto indica se a revisão sistemática ainda está em andamento ou se foi oficialmente concluída.</p>

        <ul>
            <li><strong>Projeto em andamento:</strong> o projeto permanece ativo e pode receber alterações normalmente.</li>
            <li><strong>Projeto finalizado:</strong> o administrador do projeto declarou que o trabalho foi concluído.</li>
        </ul>

        <p>Apenas usuários com perfil de <strong>Administrador</strong> podem alterar esse status.</p>

        <p>Mesmo que todas as barras de progresso estejam em 100%, o projeto somente será considerado finalizado após a confirmação do administrador através da opção <strong>Marcar como Finalizado</strong>.</p>

        <p>Se necessário, um projeto finalizado pode ser reaberto utilizando a opção <strong>Marcar como em Andamento</strong>.</p>
    ',
    ],

    'activity_record' => 'Registro de Atividades',
    'view_full_history' => 'Ver histórico completo',
    'full_activity_history' => 'Histórico completo de atividades',
    'no_activities' => 'Nenhuma atividade registrada.',
    'export' => 'Exportar dados',

    // Activity Log messages
    'project_created' => 'Criou o projeto :title',
    'project_edited' => 'Editou o projeto :title',
    'admin_removed_member' => 'O administrador removeu o membro :member do projeto :project.',
    'sent_invitation' => 'Enviou convite para :member participar do projeto :project.',
    'admin_updated_member_level' => 'O administrador atualizou o nível de :member para :level.',
    'accepted_invitation' => 'Aceitou o convite para participar do projeto.',
    'close' => 'Fechar',
];
