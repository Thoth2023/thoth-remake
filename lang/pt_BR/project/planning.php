<?php

return [
    'overall' => [
        'title' => 'Planejamento Geral',
        'no-results' => 'No results found.',
        'domain' => [
            'title' => 'Domínios',
            'description' => 'Descrição',
            'add' => 'Adicionar Domínio',
            'update' => 'Atualizar Domínio',
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
                'no-results' => 'Nenhum resultado encontrado.',
            ],
            'help' => [
                'title' => 'Domínios',
                'content' => 'Domínios são categorias temáticas ou áreas de assunto que você define para estruturar e categorizar ' .
                    'o conjunto diversificado de fontes de literatura que você encontra durante sua revisão. Cada domínio representa ' .
                    'um aspecto específico ou tópico relacionado à sua pergunta de pesquisa ou área de interesse.',
            ],
        ],
        'language' => [
            'title' => 'Idiomas',
            'add' => 'Adicionar Idioma',
            'list' => [
                'select' => [
                    'placeholder' => 'Selecione um Idioma',
                    'validation' => 'O campo de idioma é obrigatório.'
                ],
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
                'content' => 'Idiomas representam diferentes idiomas nos quais as fontes de literatura são escritas. ' .
                    'Você pode adicionar e gerenciar idiomas para categorizar as fontes com base em sua língua de origem.',
            ],
        ],
        'study_type' => [
            'title' => 'Tipos de Estudo',
            'types' => 'Tipos',
            'add' => 'Adicionar Tipo de Estudo',
            'list' => [
                'select' => [
                    'placeholder' => 'Selecione um Tipo de Estudo',
                    'validation' => 'O campo de tipo de estudo é obrigatório.',
                ],
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
                    'incluídos em sua revisão de literatura. Você pode adicionar e gerenciar tipos de estudo para categorizar ' .
                    'as fontes com base na natureza dos estudos realizados.',
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
                    'Você pode usar palavras-chave para categorizar e organizar suas fontes de literatura, facilitando ' .
                    'a identificação de informações relevantes para o seu projeto.',
            ],
        ],
        'dates' => [
            'title' => 'Datas do Projeto',
            'start_date' => 'Data de Início',
            'end_date' => 'Data de Término',
            'add_date' => 'Salvar Data',
            'help' => [
                'title' => 'Datas do Projeto',
                'content' => 'Defina as datas de início e término do seu projeto para definir o período durante o qual você ' .
                    'realizará sua revisão de literatura. Isso ajudará a acompanhar seu progresso e a ' .
                    'agendar seu trabalho de maneira eficaz.',
            ],
        ],
    ],
    'research-questions' => [
        'title' => 'Perguntas de Pesquisa',
        'help' => [
            'title' => 'Ajuda para Perguntas de Pesquisa',
            'content' => 'Perguntas de pesquisa são investigações-chave que orientam sua revisão de literatura. Cada pergunta deve ser clara, focada e diretamente relacionada aos seus objetivos de pesquisa. Adicione, edite ou exclua perguntas de pesquisa para refinar o escopo de sua revisão de literatura.',
        ],
        'form' => [
            'id' => 'ID',
            'description' => 'Descrição',
            'add' => 'Adicionar',
        ],
        'table' => [
            'id' => 'ID',
            'description' => 'Descrição',
            'edit' => 'Editar',
            'delete' => 'Excluir',
            'no-questions' => 'Nenhuma pergunta de pesquisa encontrada.',
        ],
        'edit-modal' => [
            'title' => 'Atualização de Pergunta de Pesquisa',
            'id' => 'ID',
            'description' => 'Descrição',
            'update' => 'Atualizar',
        ],
    ],
    'databases' => [
        'title' => 'Bancos de Dados',
        'help' => [
            'title' => 'Ajuda para Bancos de Dados',
            'content' => 'Bancos de dados são repositórios de artigos e publicações acadêmicas. Selecione os bancos de dados que você planeja pesquisar para reunir literatura relevante para sua revisão. Adicione ou remova bancos de dados com base na relevância para o tópico de sua pesquisa.',
        ],
        'form' => [
            'select-placeholder' => 'Selecione um Banco de Dados',
            'add-button' => 'Adicionar Banco de Dados',
        ],
        'table' => [
            'header' => 'Bancos de Dados',
            'remove-button' => 'Remover',
            'no-databases' => 'Nenhum banco de dados encontrado.',
        ],
        'suggest-new' => [
            'title' => 'Sugerir um Novo Banco de Dados',
            'name-label' => 'Nome do Banco de Dados:',
            'link-label' => 'Link do Banco de Dados:',
            'submit-button' => 'Enviar sugestão',
        ],
        'errors' => [
            'name' => 'Mensagem de erro para o campo de nome, se necessário.',
        ],
    ],
    'search-string' => [],
    'search-strategy' => [
        'title' => 'Estratégia de Busca',
        'help' => [
            'title' => 'Ajuda para Estratégia de Busca',
            'content' => "
                <p>Na fase de planejamento, é necessário determinar e seguir uma estratégia de busca. Isso deve ser desenvolvido em consulta com bibliotecários ou outras pessoas com experiência relevante. As estratégias de busca geralmente são iterativas e se beneficiam de:</p>
                <ul>
                    <li>Realizar pesquisas preliminares com o objetivo de identificar revisões sistemáticas existentes e avaliar o volume de estudos potencialmente relevantes.</li>
                    <li>Realizar buscas preliminares usando várias combinações de termos de busca derivados da pergunta de pesquisa.</li>
                    <li>Verificar a sequência de pesquisa preliminar em listas de estudos primários já conhecidos.</li>
                    <li>Buscar consultas com especialistas no campo.</li>
                </ul>
            ",
        ],
        'placeholder' => 'Digite a estratégia de busca',
        'save-button' => 'Salvar',
    ],
    'criteria' => [
        'title' => 'Critérios de Inclusão/Exclusão',
        'help' => [
            'title' => 'Ajuda para Critérios de Inclusão/Exclusão',
            'content' => '
                <p>Na seção de critérios, você define os critérios para selecionar ou excluir estudos em seu projeto de pesquisa.</p>
                <p><strong>Critérios de Inclusão:</strong> Especifique os critérios que os estudos devem atender para serem incluídos em sua pesquisa.</p>
                <p><strong>Critérios de Exclusão:</strong> Especifique os critérios que os estudos devem atender para serem excluídos de sua pesquisa.</p>
                <p>Certifique-se de considerar cuidadosamente e documentar seus critérios para garantir um processo de seleção sistemático e transparente.</p>
            ',
        ],
        'form' => [
            'id' => 'ID',
            'description' => 'Descrição',
            'type' => 'Tipo',
            'inclusion' => 'Inclusão',
            'exclusion' => 'Exclusão',
            'add' => 'Adicionar Critério',
        ],
        'inclusion-table' => [
            'title' => 'Critérios de Inclusão',
            'select' => '',
            'id' => 'ID',
            'description' => 'Descrição',
            'edit' => 'Editar',
            'delete' => 'Excluir',
            'no-criteria' => 'Nenhum critério encontrado.',
            'rule' => 'Regra de Inclusão',
            'all' => 'Todos',
            'any' => 'Qualquer',
            'at-least' => 'Pelo Menos',
        ],
        'exclusion-table' => [
            'title' => 'Critérios de Exclusão',
            'select' => '',
            'id' => 'ID',
            'description' => 'Descrição',
            'edit' => 'Editar',
            'delete' => 'Excluir',
            'no-criteria' => 'Nenhum critério encontrado.',
            'rule' => 'Regra de Exclusão',
            'all' => 'Todos',
            'any' => 'Qualquer',
            'at-least' => 'Pelo Menos',
        ],
    ],
    'quality-assessment' => [],
    'data-extraction' => [
        'question-form' => [
            'title' => 'Criar Pergunta de Extração de Dados',
            'help' => [
                'title' => 'Ajuda para Formulário de Pergunta de Extração de Dados',
                'content' => 'Use o formulário de pergunta de extração de dados para criar perguntas que orientem a extração de informações específicas de estudos selecionados. Defina o ID da pergunta, descrição, tipo e adicione opções, se necessário. Esta etapa garante uma extração de dados estruturada e abrangente.',
            ],
            'id' => 'ID',
            'description' => 'Descrição',
            'type' => 'Tipo',
            'add-question' => 'Adicionar Pergunta',
        ],
        'option-form' => [
            'title' => 'Criar Opção de Pergunta de Extração de Dados',
            'help' => [
                'title' => 'Ajuda para Formulário de Opção de Extração de Dados',
                'content' => 'Use o formulário de opção de extração de dados para adicionar opções específicas para perguntas, facilitando a captura detalhada de informações durante o processo de extração de dados. Defina a pergunta à qual a opção pertence, forneça uma descrição e certifique-se de que as opções cubram todos os aspectos relevantes da pergunta.',
            ],
            'question' => 'Pergunta',
            'option' => 'Opção',
            'add-option' => 'Adicionar Opção',
        ],
        'table' => [
            'header' => [
                'id' => 'ID',
                'description' => 'Descrição',
                'question-type' => 'Tipo de Pergunta',
                'options' => 'Opções',
                'actions' => 'Ações',
            ]
        ]
    ]
];

