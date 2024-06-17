<?php
return [   
    'faq-management' => [
        'title' => 'Gerenciador de Páginas Estáticas ',
        'description' => 'Aqui você pode gerenciar as páginas estáticas vistas pelos usuários da Thoth. Você pode ajustar, adicionar ou excluir informações.',
        'table' => [
            'title' => 'FAQ Perguntas e Respostas',
            'headers' => [
                'request' => 'Pergunta',
                'response' => 'Resposta',
                'actions' => 'Ações',
            ],
            'states' => [
                'approved' => 'Aprovada',
                'rejected' => 'Recusada',
                'pending' => 'Pendente',
                'proposed' => 'Proposta',
            ],
            'actions' => [
                'accept' => 'Aceitar',
                'reject' => 'Rejeitar',
            ],
            'empty' => 'Nenhuma pergunta foi encontrada.',
        ],
        // 'modal' => [
        //     'approve' => [
        //         'title' => 'Aceitar Sugestão',
        //         'description' => 'Tem certeza de que deseja aprovar esta sugestão? A sugestão será adicionada a lista de bases de dados',
        //         'cancel' => 'Cancelar',
        //         'approve' => 'Aprovar',
        //     ],
        //     'reject' => [
        //         'title' => 'Rejeitar Sugestão de Base de Dados',
        //         'description' => 'Tem certeza de que deseja rejeitar esta sugestão?',
        //         'cancel' => 'Cancelar',
        //         'reject' => 'Rejeitar',
        //     ],
        //     'delete' => [
        //         'title' => 'Excluir Sugestão de Base de Dados',
        //         'description' => 'Tem certeza de que deseja excluir esta sugestão? Esta ação não pode ser desfeita.',
        //         'cancel' => 'Cancelar',
        //         'delete' => 'Excluir',
        //     ],
        // ],
    ]
]
?>