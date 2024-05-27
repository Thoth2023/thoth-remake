<?php

return [
    'planning' => 'Planejamento',
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
                    'enter_description' => 'Digite a descrição do domínio',
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
            'livewire' => [
                'logs' => [
                    'added' => 'Domínio adicionado',
                    'updated' => 'Domínio atualizado',
                    'deleted' => 'Domínio excluído',
                ],
                'description' => [
                    'required' => 'O campo de descrição é obrigatório.',
                ],
                'toasts' => [
                    'added' => 'Domínio adicionado com sucesso.',
                    'updated' => 'Domínio atualizado com sucesso.',
                    'deleted' => 'Domínio deletado com sucesso.',
                ],
            ]
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
            'livewire' => [
                'logs' => [
                    'added' => 'Idioma adicionado',
                    'updated' => 'Idioma atualizado',
                    'deleted' => 'Idioma excluído',
                ],
                'language' => [
                    'required' => 'O campo de idioma é obrigatório.',
                    'already_exists' => 'O idioma selecionado já existe neste projeto.',
                ],
                'toasts' => [
                    'added' => 'Idioma adicionado com sucesso.',
                    'deleted' => 'Idioma deletado com sucesso.',
                ],
            ]
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
            'livewire' => [
                'study_type' => [
                    'required' => 'O campo de tipo de estudo é obrigatório.',
                    'already_exists' => 'O tipo de estudo selecionado já existe neste projeto.',
                ],
                'logs' => [
                    'added' => 'Tipo de estudo adicionado',
                    'deleted' => 'Tipo de estudo excluído',
                ],
                'toasts' => [
                    'added' => 'Tipo de estudo adicionado com sucesso.',
                    'deleted' => 'Tipo de estudo deletado com sucesso.',
                ],
            ]
        ],
        'keyword' => [
            'title' => 'Palavras-chave',
            'description' => 'Descrição',
            'enter_description' => 'Digite a descrição da palavra-chave',
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
            'livewire' => [
                'logs' => [
                    'added' => 'Palavra-chave adicionada',
                    'updated' => 'Palavra-chave atualizada',
                    'deleted' => 'Palavra-chave excluída',
                ],
                'description' => [
                    'required' => 'O campo de descrição é obrigatório.',
                ],
                'toasts' => [
                    'added' => 'Palavra-chave adicionada com sucesso.',
                    'updated' => 'Palavra-chave atualizada com sucesso.',
                    'deleted' => 'Palavra-chave deletada com sucesso.',
                ],
            ]
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
            'livewire' => [
                'logs' => [
                    'added' => 'Datas do projeto adicionadas',
                    'updated' => 'Datas do projeto atualizadas',
                ],
                'date' => [
                    'invalid' => 'A data inválida. Por favor, insira uma data válida.',
                ],
                'start_date' => [
                    'required' => 'O campo de data de início é obrigatório.',
                ],
                'end_date' => [
                    'required' => 'O campo de data de término é obrigatório.',
                    'after' => 'A data de término deve ser posterior à data de início.',
                ],
                'toasts' => [
                    'added' => 'Datas do projeto adicionadas com sucesso.',
                    'updated' => 'Datas do projeto atualizadas com sucesso.',
                ],
            ]
        ],
    ],
    'research-questions' => [
        'title' => 'Questões de Pesquisa',
        'help' => [
            'title' => 'Ajuda para Questões de Pesquisa',
            'content' => 'Questões de pesquisa são investigações-chave que orientam sua revisão de literatura. Cada pergunta deve ser clara, focada e diretamente relacionada aos seus objetivos de pesquisa. Adicione, edite ou exclua perguntas de pesquisa para refinar o escopo de sua revisão de literatura.',
        ],
        'form' => [
            'id' => 'ID',
            'description' => 'Descrição',
            'enter_description' => 'Digite a descrição da questão de pesquisa',
            'add' => 'Adicionar',
            'update' => 'Atualizar'
        ],
        'table' => [
            'id' => 'ID',
            'description' => 'Descrição',
            'actions' => 'Ações',
            'edit' => 'Editar',
            'delete' => 'Excluir',
            'no-questions' => 'Nenhuma questão de pesquisa encontrada.',
            'empty' => 'Este projeto ainda não possui questões de pesquisa'
        ],
        'edit-modal' => [
            'title' => 'Atualização de Questão de Pesquisa',
            'id' => 'ID',
            'description' => 'Descrição',
            'update' => 'Atualizar',
        ],
        'livewire' => [
            'logs' => [
                'added' => 'Questão de Pesquisa adicionada',
                'updated' => 'Questão de Pesquisa atualizada',
                'deleted' => 'Questão de Pesquisa excluída',
            ],
            'description' => [
                'required' => 'O campo de descrição é obrigatório.',
            ],
            'toasts' => [
                'added' => 'Questão de Pesquisa adicionada com sucesso.',
                'updated' => 'Questão de Pesquisa atualizada com sucesso.',
                'deleted' => 'Questão de Pesquisa deletada com sucesso.',
            ],
        ]
    ],
    'databases' => [
        'title' => 'Bases de Dados',
        'help' => [
            'title' => 'Bases de Dados',
            'content' => 'Bases de dados são repositórios de artigos e publicações acadêmicas. Selecione as bases que você planeja pesquisar para reunir literatura relevante para sua revisão. Adicione ou remova bases de acordo com a relevância para o tópico de sua pesquisa.',
        ],
        'form' => [
            'select-placeholder' => 'Selecione uma Base de Dados',
            'add-button' => 'Adicionar Base de Dados',
        ],
        'table' => [
            'name' => 'Nome',
            'actions' => 'Ações',
            'header' => 'Bases de Dados',
            'remove-button' => 'Remover',
            'no-databases' => 'Nenhuma base de dados encontrado.',
            'empty' => 'Este projeto ainda não possui bases de dados registradas'
        ],
        'suggest-new' => [
            'title' => 'Sugira uma nova Base de Dados',
            'name-label' => 'Nome da Base de Dados',
            'enter-name' => 'Digite o nome da Base de Dados',
            'link-label' => 'Link da Base de Dados',
            'enter-link' => 'Digite o link da Base de Dados',
            'submit-button' => 'Enviar sugestão',
        ],
        'errors' => [
            'name' => 'Mensagem de erro para o campo de nome, se necessário.',
        ],
        'livewire' => [
            'logs' => [
                'added' => 'Base de Dados adicionada',
                'suggestion' => 'Base de Dados sugerida.',
                'deleted' => 'Base de Dados excluída',
            ],
            'database' => [
                'required' => 'O campo de base de dados é obrigatório.',
                'required_link' => 'O campo de link é obrigatório.',
                'already_exists' => 'A base de dados selecionada já existe neste projeto.',
                'invalid_link' => 'O link da base de dados é inválido.',
            ],
            'toasts' => [
                'added' => 'Base de Dados adicionada com sucesso.',
                'deleted' => 'Base de Dados deletada com sucesso.',
                'suggested' => 'Sua sugestão foi enviada com sucesso.',
            ],
        ]
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
            'dont-use' => 'Não utilize caracteres especiais',
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
            'dont-use' => 'Não utilize caracteres especiais',
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

