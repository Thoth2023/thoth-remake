<?php
return [   
    'home' => [
        'title' => 'Gerenciador da Home',
        'description' => 'Aqui você pode gerenciar os textos vistos pelos usuários da Thoth. Você pode ajustar, adicionar ou excluir informações.',
        'table' => [
            'title' => 'Home ',
            'headers' => [
                'request' => 'Titulo',
                'response' => 'Descrição',
                'icon' => 'Icone',
                'actions' => 'Ações',
            ],
            'actions' => [
                'edit' => 'Editar',
                'delete' => 'Deletar',
            ],
            'empty' => 'Nenhuma descrição foi encontrada.'
        ],
        'modal' => [
            'create' => [
                'title' => 'Adicionar Descrição na Home',
                'description' => 'Tem certeza de que deseja aprovar esta sugestão? A sugestão será adicionada a lista de bases de dados',
                'cancel' => 'Cancelar',
                'approve' => 'Adicionar',
            ],
            'edit' => [
                'title' => 'Editar Descrição na Home',
                'cancel' => 'Cancelar',
                'approve' => 'Editar',
            ],
            'delete' => [
                'title' => 'Excluir Descrição ',
                'description' => 'Tem certeza de que deseja excluir esta descrição? Esta ação não pode ser desfeita.',
                'cancel' => 'Cancelar',
                'approve' => 'Excluir',
            ],
        ],
    ]
]
?>