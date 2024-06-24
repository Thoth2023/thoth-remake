<?php
return [   
    'faq-management' => [
        'title' => 'Gerenciador de FAQ',
        'description' => 'Aqui você pode gerenciar as perguntas do FAQ vistas pelos usuários da Thoth. Você pode ajustar, adicionar ou excluir informações.',
        'table' => [
            'title' => 'FAQ Perguntas e Respostas',
            'headers' => [
                'request' => 'Pergunta',
                'response' => 'Resposta',
                'actions' => 'Ações',
            ],
            'actions' => [
                'edit' => 'Editar',
                'delete' => 'Deletar',
            ],
            'empty' => 'Nenhuma pergunta foi encontrada.',
        ],
        'modal' => [
            'create' => [
                'title' => 'Adicionar Pergunta',
                'description' => 'Tem certeza de que deseja aprovar esta sugestão? A sugestão será adicionada a lista de bases de dados',
                'cancel' => 'Cancelar',
                'approve' => 'Adicionar',
            ],
            'edit' => [
                'title' => 'Editar Pergunta',
                'description' => 'Tem certeza de que deseja rejeitar esta sugestão?',
                'cancel' => 'Cancelar',
                'approve' => 'Editar',
            ],
            'delete' => [
                'title' => 'Excluir Pergunta',
                'description' => 'Tem certeza de que deseja excluir esta pergunta? Esta ação não pode ser desfeita.',
                'cancel' => 'Cancelar',
                'approve' => 'Excluir',
            ],
        ],
    ]
]
?>