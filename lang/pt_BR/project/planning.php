<?php

return [
    'overall' => [
        'title' => 'Planejamento Geral',
        'domain' => [
            'title' => 'Domínios',
            'description' => 'Descrição',
            'add' => 'Adicionar Domínio',
            'list' => [
                'headers' => [
                    'name' => 'Nome',
                    'description' => 'Descrição',
                    'actions' => 'Ações',
                ],
                'actions' => [
                    'edit' => [
                        'button' => 'Editar',
                        'modal' => [
                            'title' => 'Editar Domínio',
                            'description' => 'Descrição',
                            'cancel' => 'Cancelar',
                            'save' => 'Salvar',
                        ],
                    ],
                    'delete' => [
                        'button' => 'Excluir',
                        'modal' => [
                            'title' => 'Excluir Domínio',
                            'description' => 'Tem certeza de que deseja excluir este domínio?',
                            'cancel' => 'Cancelar',
                            'delete' => 'Excluir',
                        ],
                    ],
                ],
                'empty' => 'Nenhum domínio foi adicionado ainda.',
            ],
            'help' => [
                'title' => 'Domínios',
                'content' => 'Domínios são categorias temáticas ou áreas de assunto que você define para estruturar e categorizar ' .
                             'o conjunto diversificado de fontes literárias encontradas durante sua revisão. Cada domínio representa ' .
                             'um aspecto ou tópico específico relacionado à sua pergunta de pesquisa ou área de interesse.',
            ],
        ],
        'language' => [
            'title' => 'Idiomas',
            'add' => 'Adicionar Idioma',
            'list' => [
                'headers' => [
                    'languages' => 'Idiomas',
                    'actions' => 'Ações',
                ],
                'actions' => [
                    'delete' => [
                        'button' => 'Excluir',
                        'tooltip' => 'Excluir Idioma',
                    ],
                ],
                'empty' => 'Nenhum idioma foi adicionado ainda.',
            ],
            'help' => [
                'title' => 'Idiomas',
                'content' => 'Idiomas representam diferentes línguas nas quais fontes literárias são escritas. ' .
                             'Você pode adicionar e gerenciar idiomas para categorizar as fontes com base na língua de origem.',
            ],
        ],
        'study_type' => [
            'title' => 'Tipos de Estudo',
            'types' => 'Tipos',
            'add' => 'Adicionar Tipo de Estudo',
            'list' => [
                'headers' => [
                    'types' => 'Tipos',
                    'actions' => 'Ações',
                ],
                'actions' => [
                    'delete' => [
                        'button' => 'Excluir',
                        'tooltip' => 'Excluir Tipo de Estudo',
                    ],
                ],
                'empty' => 'Nenhum tipo de estudo foi adicionado ainda.',
            ],
            'help' => [
                'title' => 'Tipos de Estudo',
                'content' => 'Tipos de estudo representam diferentes categorias ou classificações para os tipos de estudos ' .
                             'incluídos em sua revisão literária. Você pode adicionar e gerenciar tipos de estudo para categorizar ' .
                             'as fontes com base na natureza dos estudos conduzidos.',
            ],
        ],
        'keyword' => [
            'title' => 'Palavras-chave',
            'description' => 'Descrição',
            'add' => 'Adicionar Palavra-chave',
            'list' => [
                'headers' => [
                    'description' => 'Descrição',
                    'actions' => 'Ações',
                ],
                'actions' => [
                    'edit' => [
                        'button' => 'Editar',
                        'modal' => [
                            'title' => 'Editar Palavra-chave',
                            'description' => 'Descrição',
                            'cancel' => 'Cancelar',
                            'save' => 'Salvar',
                        ],
                    ],
                    'delete' => [
                        'button' => 'Excluir',
                        'modal' => [
                            'title' => 'Excluir Palavra-chave',
                            'description' => 'Tem certeza de que deseja excluir esta palavra-chave?',
                            'cancel' => 'Cancelar',
                            'delete' => 'Excluir',
                        ],
                    ],
                ],
                'empty' => 'Nenhuma palavra-chave foi adicionada ainda.',
            ],
            'help' => [
                'title' => 'Palavras-chave',
                'content' => 'Palavras-chave são termos ou frases que representam conceitos-chave em sua pesquisa. ' .
                              'Você pode usar palavras-chave para categorizar e organizar suas fontes literárias, facilitando ' .
                              'a identificação de informações relevantes para o seu projeto.',
            ],
        ],
        'dates' => [
            'title' => 'Datas do Projeto',
            'start_date' => 'Data de Início',
            'end_date' => 'Data de Término',
            'add_date' => 'Adicionar Data',
            'help' => [
                'title' => 'Datas do Projeto',
                'content' => 'Defina as datas de início e término do seu projeto para definir o período durante o qual você ' .
                             'realizará sua revisão literária. Isso ajudará você a acompanhar seu progresso e a ' .
                             'agendar seu trabalho de maneira eficaz.',
            ],
        ],
    ],
];


