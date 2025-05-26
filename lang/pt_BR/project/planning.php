<?php

return [
    'planning' => 'Planejamento',
    'button' => [
        'close' => 'Fechar',
    ],
    'placeholder' => [
        'search' => 'Pesquisar...',
    ],
    'overall' => [
        'title' => 'Informações Gerais',
        'no-results' => 'Nenhum resultado encontrado.',
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
                    'um aspecto específico ou tópico relacionado à sua pergunta de pesquisa ou área de interesse.
                    <br><strong>Ex.:</strong> Engenharia de Software, Medicina, Ciências da Saúde, etc...',
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
                    'duplicate' => 'Domínio duplicado não é permitido.',
                    'denied' => 'Um visualizador não pode adicionar, editar ou excluir domínios.'
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
                    'denied' => 'Um visualizador não pode adicionar, editar ou excluir idiomas.',
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
                    'denied' => 'Um visualizador não pode adicionar, editar ou excluir tipos de estudo.'
                ],
            ]
        ],
        'keyword' => [
            'title' => 'Palavras-chave',
            'description' => 'Descrição',
            'enter_description' => 'Digite a descrição da palavra-chave',
            'add' => 'Adicionar Palavra-chave',
            'update' => 'Atualizar Palavra-chave',
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
                    'duplicate' => 'Palavra-chave duplicada não é permitida.',
                    'denied' => 'Um visualizador não pode adicionar, editar ou excluir palavras-chave.',
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
                    'denied' => 'Um visualizador não pode adicionar, editar ou excluir datas do projeto.'
                ],
            ]
        ],
    ],
    'research-questions' => [
        'title' => 'Questões de Pesquisa',
        'help' => [
            'title' => 'Ajuda para Questões de Pesquisa',
            'content' => 'Questões de pesquisa são investigações-chave que orientam sua revisão de literatura. Cada pergunta deve ser clara, focada e diretamente relacionada aos seus objetivos de pesquisa. Adicione, edite ou exclua perguntas de pesquisa para refinar o escopo de sua revisão de literatura.
            <br><strong>Ex.:</strong> RQ01 - Os estudos são revisões sistemáticas da literatura?',
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
                'denied' => 'Um visualizador não pode adicionar, editar ou excluir questões de pesquisa.'
            ],
        ]
    ],
    'databases' => [
        'title' => 'Base de Dados',
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
            'help' => [
                'title' => 'Sugira uma nova Base de Dados',
                'content' => 'Caso seja necessário para sua pesquisa e ela não esteja na lista atual da Thoth. Vale ressaltar que essa base de dados só ficará disponível para uso após aprovação dos administradores responsáveis pelo sistema.',
            ],
            'content' => 'Sugira uma nova Base de Dados',
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
                'denied' => 'Um visualizador não pode adicionar, editar ou excluir bases de dados.',
            ],
        ],
        'database-manager' => [
            'title' => 'Gerenciador de Bases de Dados',
            'description' => 'Aqui você pode gerenciar as sugestões de bases de dados enviadas pelos usuários. Você pode aceitar ou rejeitar sugestões.',
            'table' => [
                'title' => 'Sugestões de Base de Dados',
                'headers' => [
                    'name' => 'Nome',
                    'link' => 'Link',
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
                'empty' => 'Nenhuma sugestão de base de dados encontrada.',
            ],
            'modal' => [
                'approve' => [
                    'title' => 'Aceitar Sugestão',
                    'description' => 'Tem certeza de que deseja aprovar esta sugestão? A sugestão será adicionada a lista de bases de dados',
                    'cancel' => 'Cancelar',
                    'approve' => 'Aprovar',
                ],
                'reject' => [
                    'title' => 'Rejeitar Sugestão de Base de Dados',
                    'description' => 'Tem certeza de que deseja rejeitar esta sugestão?',
                    'cancel' => 'Cancelar',
                    'reject' => 'Rejeitar',
                ],
                'delete' => [
                    'title' => 'Excluir Sugestão de Base de Dados',
                    'description' => 'Tem certeza de que deseja excluir esta sugestão? Esta ação não pode ser desfeita.',
                    'cancel' => 'Cancelar',
                    'delete' => 'Excluir',
                ],
            ],
        ],
    ],
    'search-string' => [
        'generate-all' => 'Gerar todas as strings de busca',
        'title' => 'String de Busca',
        'help' => 'String de busca é uma sequência de termos de pesquisa que você usa para pesquisar fontes de literatura relevantes para sua revisão. Adicione strings de busca para cada base de dados do projeto para refinar sua estratégia de busca e encontrar informações relevantes para sua pesquisa.',
        'form' => [
            'description' => 'String de Busca Genérica',
            'enter-description' => 'Digite a string de busca genérica',
            'add' => 'Adicionar String de Busca',
            'update' => 'Atualizar String de Busca',
            'placeholder' => 'Digite a string de busca',
        ],
        'livewire' => [
            'toasts' => [
                'generated' => 'Strings de Busca geradas com sucesso.',
                'updated-string' => 'String de Busca atualizada com sucesso.',
            ],
        ],
        'term' => [
            'title' => 'Termos',
            'help' => 'Termos de busca são palavras-chave que você usa para pesquisar fontes de literatura relevantes para sua revisão. Adicione, edite ou exclua termos de busca para refinar sua estratégia de busca e encontrar informações relevantes para sua pesquisa.',
            'form' => [
                'title' => 'Termos de Busca',
                'placeholder' => 'Digite o termo de busca',
                'synonyms' => 'Sinônimos',
                'update' => 'Atualizar Termo de Busca',
                'add' => 'Adicionar Termo',
                'select' => 'Termos de Busca',
                'select-placeholder' => 'Selecione um termo',
                'no-suggestions' => 'Nenhuma sugestão encontrada.',
                'language' => 'Idioma das Sugestões',
            ],
            'table' => [
                'description' => 'Termo de Busca',
                'actions' => 'Ações',
                'empty' => 'Nenhum termo de busca cadastrado',
                'not-found' => 'Nenhum termo de busca encontrado.',
            ],
            'livewire' => [
                'description' => [
                    'required' => 'O campo do termo de busca é obrigatório.',
                ],
                'toasts' => [
                    'added' => 'Termo de Busca adicionado com sucesso.',
                    'updated' => 'Termo de Busca atualizado com sucesso.',
                    'deleted' => 'Termo de Busca deletado com sucesso.',
                    'validation' => 'O termo de busca é inválido. Por favor, insira um termo de busca válido.',
                    'denied' => 'Um visualizador não pode adicionar, editar ou excluir termos de busca.',
                    'synonym' => 'O sinônimo é inválido. Por favor, insira um sinônimo válido.',

                ],
            ]
        ],
        'synonym' => [
            'form' => [
                'title' => 'Sinônimos',
                'placeholder' => 'Digite o sinônimo',
            ]
        ]
    ],
    'search-strategy' => [
        'title' => 'Estratégia de Busca',
        'help' => [
            'title' => 'Ajuda para Estratégia de Busca',
            'content' => "
                        <p>Na fase de planejamento, é necessário determinar e seguir uma estratégia de busca. Esta deve ser desenvolvida em consulta com bibliotecários ou outras pessoas com experiência relevante. As estratégias de busca são geralmente iterativas e se beneficiam de:</p>
                        <ul>
                            <li>Realizar buscas preliminares com o objetivo de identificar revisões sistemáticas existentes e avaliar o volume de estudos potencialmente relevantes.</li>
                            <li>Executar buscas experimentais usando várias combinações de termos de busca derivados da questão de pesquisa.</li>
                            <li>Verificar a cadeia de pesquisa experimental em comparação com listas de estudos primários já conhecidos.</li>
                            <li>Buscar consultas com especialistas na área.</li>
                        </ul>
                        <p>Descreva aqui uma estratégia utilizada para a pesquisa.</p>
                    ",
        ],
        'placeholder' => 'Digite a estratégia de busca',
        'save-button' => 'Salvar',
        'success' => 'Estratégia de busca atualizada com sucesso.',
        'denied' => 'Um visualizador não pode adicionar, editar ou excluir a estratégia de busca.',
    ],
    'criteria' => [
        'title' => 'Critérios de Inclusão/Exclusão',
        'help' => [
            'title' => 'Critérios de Inclusão/Exclusão',
            'content' => '
            <p>Na seção de critérios, você define os critérios para a seleção ou exclusão de estudos em seu projeto de pesquisa.</p>
            <p><strong>Critérios de Inclusão:</strong> Especifique os critérios que os estudos devem atender para serem incluídos em sua pesquisa.
            <br>Ex.: IC1 - A publicação deve propor uma ferramenta para apoiar o teste de desempenho.</p>
            <p><strong>Critérios de Exclusão:</strong> Especifique os critérios que os estudos devem atender para serem excluídos de sua pesquisa.
            <br>Ex.: EC1 - Artigos duplicados.</p>
            <p>Certifique-se de considerar e documentar cuidadosamente seus critérios para garantir um processo de seleção sistemático e transparente.</p>
            <ul><li><strong>Todos:</strong> O estudo deve conter todos os critérios de inclusão ou exclusão.</li>
            <li><strong>Pelo menos:</strong> O estudo deve conter pelo menos os critérios selecionados.</li>
            <li><strong>Qualquer:</strong> O estudo pode conter qualquer um dos critérios.</li></ul>
            ',
        ],
        'form' => [
            'id' => 'ID',
            'dont-use' => 'Não utilize caracteres especiais',
            'description' => 'Descrição',
            'enter_description' => 'Digite a descrição do critério',
            'type' => 'Tipo',
            'inclusion' => 'Inclusão',
            'exclusion' => 'Exclusão',
            'add' => 'Adicionar Critério',
            'update' => 'Atualizar Critério',
            'select-placeholder' => 'Selecione o Tipo de Critério',
            'select-inclusion' => 'Inclusão',
            'select-exclusion' => 'Exclusão',
        ],
        'inclusion-table' => [
            'title' => 'Critérios de Inclusão',
            'select' => '',
            'id' => 'ID',
            'description' => 'Descrição',
            'rule' => 'Regra de Inclusão',
        ],
        'exclusion-table' => [
            'title' => 'Critérios de Exclusão',
            'select' => '',
            'id' => 'ID',
            'description' => 'Descrição',
            'rule' => 'Regra de Exclusão',
        ],
        'table' => [
            'all' => 'Todos',
            'any' => 'Qualquer',
            'at-least' => 'Pelo menos',
            'empty' => 'No criteria found',
            'actions' => 'Ações',
        ],
        'livewire' => [
            'description' => [
                'required' => 'O campo de descrição é obrigatório.',
            ],
            'criteriaId' => [
                'required' => 'O campo de ID é obrigatório.',
                'regex' => 'O campo de ID deve conter apenas letras e números.',
            ],
            'type' => [
                'required' => 'Selecionar um tipo é obrigatório.',
                'in' => 'Selecione um tipo válido.',
            ],
            'logs' => [
                'added' => 'Critério adicionado',
                'updated' => 'Critério atualizado.',
                'deleted' => 'Critério excluído',
            ],
            'toasts' => [
                'added' => 'Critério adicionado com sucesso.',
                'deleted' => 'Critério deletado com sucesso.',
                'updated' => 'Critério atualizado com sucesso.',
                'updated-inclusion' => 'Regra do critério de inclusão atualizada',
                'updated-exclusion' => 'Regra do critério de exclusão atualizada',
                'unique-id' => 'Este ID de critério já está em uso. Por favor, insira um ID de critério único.',
                'denied' => 'Um visualizador não pode adicionar, editar ou excluir critérios de inclusão/exclusão.',
            ],
        ],
    ],
    'quality-assessment' => [
        'title' => 'Avaliação de Qualidade',
        'generate-intervals' => 'Gerar intervalos',
        'ranges' => [
            'label-updated' => 'Label atualizada com sucesso.',
            'interval-updated' => 'Intervalo atualizado com sucesso.',
            'deletion-restricted' => 'Não é possível excluir o intervalo ":description". Existem registros/papers associados.',
            'generated' => 'Intervalos gerados com sucesso.',
        ],
        'general-score' => [
            'title' => 'Pontuação Geral',
            'help' => [
                'title' => 'Pontuação Geral',
                'content' => '
                <p>Você pode definir os intervalos que considerar necessários para a sua revisão sistemática. No entanto,
                lembre-se de salvar as configurações e definir o "mínimo para aprovação". Esse planejamento será crucial na fase de condução da revisão.</p>
                <strong>Exemplo:</strong>
                <table class="table table-bordered table-striped small">
                        <thead>
                            <tr>
                                <th>Mínimo</th>
                                <th>Máximo</th>
                                <th>Descrição</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>0</td>
                                <td>1</td>
                                <td>Muito Ruim</td>
                            </tr>
                            <tr>
                                <td>1.1</td>
                                <td>2</td>
                                <td>Ruim</td>
                                </tr>
                                <tr>
                                    <td>2.1</td>
                                    <td>3</td>
                                    <td>Regular</td>
                                </tr>
                                <tr>
                                    <td>3.1</td>
                                    <td>4</td>
                                    <td>Bom</td>
                                </tr>
                                <tr>
                                    <td>4.1</td>
                                    <td>5</td>
                                    <td>Muito Bom</td>
                                </tr>
                            </tbody>
                        </table>

                ',
            ],
            'start' => 'Digite a Pontuação Mínima',
            'end' => 'Digite a Pontuação Máxima',
            'description' => 'Descrição',
            'placeholder-start' => 'Pontuação Mínima (0.0)',
            'placeholder-end' => 'Pontuação Máxima (0.0)',
            'add' => 'Adicionar Pontuação Geral',
            'update' => 'Atualizar Pontuação Geral',
            'table' => [
                'min' => 'Pontuação Mínima',
                'max' => 'Pontuação Máxima',
                'description' => 'Descrição',
                'action' => 'Ações',
                'no-results' => 'Nenhuma pontuação geral encontrada.',
                'empty' => 'Nenhuma pontuação geral registrada neste projeto.',
            ],
            'livewire' => [
                'logs' => [
                    'added' => 'Pontuação Geral adicionada',
                    'updated' => 'Pontuação Geral atualizada',
                ],
                'start' => [
                    'invalid' => 'O campo de pontuação geral é inválido. Por favor, insira uma pontuação geral válida.',
                    'required' => 'O campo de pontuação geral é inválido. Por favor, insira uma pontuação geral válida.',
                ],
                'end' => [
                    'required' => 'O campo de pontuação geral é obrigatório.',
                    'after' => 'A pontuação máxima deve ser maior que a pontuação mínima.',
                ],
                'description' => [
                    'required' => 'O campo de descrição da pontuação geral é obrigatório.',
                ],
                'toasts' => [
                    'added' => 'Pontuação Geral adicionada com sucesso.',
                    'updated' => 'Pontuação Geral atualizada com sucesso.',
                    'deleted' => 'Pontuação Geral deletada com sucesso.',
                    'denied' => 'Um visualizador não pode adicionar, editar ou excluir pontuações gerais.',
                ],
            ],

        ],
        'question-quality' => [
            'title' => 'Questão de Qualidade',
            'help' => [
                'title' => 'Questão de Qualidade',
                'content' => '
                    <p>Além dos critérios gerais de inclusão/exclusão, considera-se fundamental avaliar a "qualidade" dos estudos primários:</p>
                    <ul>
                        <li>Para fornecer critérios de inclusão/exclusão ainda mais detalhados.</li>
                        <li>Para investigar se as diferenças de qualidade explicam as diferenças nos resultados dos estudos.</li>
                        <li>Como um meio de ponderar a importância de estudos individuais quando os resultados estão sendo sintetizados.</li>
                        <li>Para orientar a interpretação dos achados e determinar a força das inferências.</li>
                        <li>Para orientar recomendações para futuras pesquisas.</li>
                    </ul><br>

                    <strong>Exemplo:</strong> QA01 - O estudo apresenta a implementação de uma ferramenta para revisão sistemática da literatura?',
            ],
            'id' => 'ID',
            'description' => 'Descrição',
            'weight' => 'Peso',
            'add' => 'Adicionar Questão de Qualidade',
            'update' => 'Atualizar Questão de Qualidade',
            'livewire' => [
                'logs' => [
                    'added' => 'Questão de Qualidade adicionada',
                    'updated' => 'Questão de Qualidade atualizada',
                ],
                'id' => [
                    'required' => 'O campo de questão de qualidade é inválido. Por favor, insira uma questão de qualidade válida.',
                ],
                'weight' => [
                    'required' => 'O campo de questão de qualidade é obrigatório.',
                ],
                'description' => [
                    'required' => 'O campo de descrição da questão de qualidade é obrigatório.',
                ],
                'toasts' => [
                    'duplicate_id' => 'Uma questão com este ID já existe.',
                    'added' => 'Questão de Qualidade adicionada com sucesso.',
                    'updated' => 'Questão de Qualidade atualizada com sucesso.',
                    'deleted' => 'Questão de Qualidade deletada com sucesso.',
                    'min_weight' => 'O peso mínimo deve ser maior que 0.',
                ],
            ],

        ],
        'question-score' => [
            'title' => 'Pontuação de Qualidade',
            'select' => [
                'rule' => 'Selecione uma regra'
            ],
            'question' => [
                'title' => 'Questão',
                'placeholder' => 'Selecione uma questão',
            ],
            'help' => [
                'title' => 'Pontuação de Qualidade',
                'content' => '
                   <p> A pontuação e as regras de pontuação são registradas como respostas, e cada resposta é associada às questões de qualidade previamente cadastradas.
                    Para cada questão, após o cadastro das regras de pontuação, deve-se estabelecer um critério mínimo para a aprovação de cada questão de qualidade.</p>
                   <br>
                    <strong>Exemplo</strong> (mínimo para aprovação "*"):<br>
                <table class="table table-bordered table-striped small">
                    <thead>
                        <tr class="w-5">
                            <th>Regra</th>
                            <th>Pontuação</th>
                            <th>Descrição</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="w-5">
                            <td>Sim</td>
                            <td>100%</td>
                            <td>Este estudo apresenta a implementação de uma ferramenta<br>  para revisão sistemática da literatura.</td>
                        </tr>
                        <tr  class="50 ">
                            <td><b>Parcial*</b></td>
                            <td>50%</td>
                            <td>Este estudo apresenta parcialmentea implementação de uma <br>ferramenta para revisão sistemática da literatura.</td>
                        </tr>
                        <tr>
                            <td>Não</td>
                            <td>0%</td>
                            <td>Este estudo não apresenta a implementação de uma <br>ferramenta  para revisão sistemática da literatura.</td>
                        </tr>
                    </tbody>
                </table>

                ',
            ],
            'description' => [
                'title' => 'Descrição',
                'placeholder' => 'Insira a descrição',
            ],
            'id_qa' => [
                'title' => 'Questão de Qualidade',
                'placeholder' => 'Selecione a Questão de Qualidade',
                'no-question-available' => 'Nenhuma questão disponível',
            ],
            'score_rule' => [
                'title' => 'Regra de Pontuação',
                'placeholder' => 'Insira a Regra de Pontuação',
            ],
            'form' => [
                'select-qa-placeholder' => 'Selecione a Questão de Qualidade',
                'add' => 'Adicionar Pontuação de Qualidade',
                'update' => 'Atualizar Pontuação de Qualidade',
            ],
            'range' => [
                'score' => 'Pontuação',
            ],
            'livewire' => [
                'logs' => [
                    'added' => 'Pontuação de Qualidade adicionada',
                    'updated' => 'Pontuação de Qualidade atualizada',
                ],
                'id' => [
                    'required' => 'Pontuação de Qualidade inválida. Por favor, insira uma pontuação de qualidade válida.',
                ],
                'weight' => [
                    'required' => 'O campo de pontuação de qualidade é obrigatório.',
                ],
                'description' => [
                    'required' => 'O campo de descrição da pontuação de qualidade é obrigatório.',
                ],
                'rule' => [
                    'required' => 'O campo de regra de pontuação é obrigatório.',
                ]
            ],
            'toasts' => [
                'added' => 'Pontuação de Qualidade adicionada com sucesso.',
                'updated' => 'Pontuação de Qualidade atualizada com sucesso.',
                'deleted' => 'Pontuação de Qualidade deletada com sucesso.',
            ],
        ],

        'min-general-score' => [
            'title' => 'Pontuação Mínima para Aprovação',
            'help-content' => '
                <p>Após o cadastro das questões de qualidade, a soma dos pesos de todas as questões registradas anteriormente é calculada automaticamente pela Thoth.</p>
                <strong>Mínimo para Aprovação:</strong>
                <p>Este item define o intervalo de pontuação mínima geral que deve ser considerado como o critério mínimo para aceitar estudos na revisão.</p>
                <p><strong>Observação:</strong> Para registrar, é necessário primeiro cadastrar as questões de qualidade, gerar os intervalos de pontuação geral
                e salvar no projeto da revisão em andamento.</p>
                ',
            'cutoff' => 'Pontuação Mínima Geral',
            'sum' => 'Soma dos Pesos',
            'form' => [
                'select-placeholder' => 'Selecione a Pontuação Geral Mínima para Aprovação',
                'add' => 'Adicionar Pontuação Geral Mínima para Aprovação',
                'update' => 'Atualizar Pontuação Geral Mínima para Aprovação',
                'empty' => 'Nenhuma pontuação geral disponível. Por favor, registre pontuações gerais.',
                'minimal-score' => 'Pontuação mínima atualizada com sucesso',
            ],

            'livewire' => [
                'logs' => [
                    'added' => 'Pontuação Geral Mínima para Aprovação adicionada',
                    'updated' => 'Pontuação Geral Mínima para Aprovação atualizada',
                ],
                'toasts' => [
                    'added' => 'Pontuação Geral Mínima para Aprovação adicionada com sucesso.',
                    'updated' => 'Pontuação Geral Mínima para Aprovação atualizada com sucesso.',
                ],
                'min-general-score' => [
                    'required' => 'O campo de pontuação geral mínima é obrigatório.',
                ],
            ],

        ],
    ],
    'data-extraction' => [
        'title' => 'Extração de Dados',
        'question-form' => [
            'title' => 'Criar Pergunta de Extração de Dados',
            'help' => [
                'title' => 'Ajuda para Formulário de Pergunta de Extração de Dados',
                'content' => '
                <p>Os formulários de extração de dados devem ser projetados para coletar todas as informações necessárias para responder às questões da revisão e aos critérios de qualidade do estudo. Se os critérios de qualidade forem utilizados para identificar critérios de inclusão/exclusão, eles exigem formulários separados (uma vez que as informações devem ser coletadas antes do exercício principal de extração de dados). Se os critérios de qualidade forem usados como parte da análise de dados, os critérios de qualidade e os dados da revisão podem ser incluídos no mesmo formulário.
                </p>
                <p>Na maioria dos casos, a extração de dados definirá um conjunto de valores numéricos que devem ser extraídos de cada estudo (por exemplo, número de sujeitos, efeito do tratamento, intervalos de confiança, etc.). Os dados numéricos são importantes para qualquer tentativa de resumir os resultados de um conjunto de estudos primários e são um pré-requisito para a meta-análise (ou seja, técnicas estatísticas destinadas a integrar os resultados dos estudos primários).
                </p>
                <p>A questão de extração deve ser definida a partir de uma descrição e do tipo de dado. Os tipos de dados são:
                </p>
                <ul>
                    <li><strong>Texto:</strong> Os dados extraídos são definidos por meio de texto simples, dando ao pesquisador a liberdade de definir os dados extraídos.</li>
                    <li><strong>Lista de Escolha Única:</strong> Através de uma lista predefinida de dados, o pesquisador deve escolher apenas uma opção de extração de dados.</li>
                    <li><strong>Lista de Múltipla Escolha:</strong> Através de uma lista predefinida de dados, o pesquisador pode escolher mais de uma opção de extração de dados.</li>
                </ul>

                ',
            ],
            'id' => 'ID',
            'dont-use' => 'Não utilize caracteres especiais',
            'description' => 'Descrição',
            'type' => 'Tipo',
            'add-question' => 'Adicionar Pergunta',
            'edit-question' => 'Editar Pergunta'
        ],
        'option-form' => [
            'title' => 'Criar Opção de Pergunta de Extração de Dados',
            'help' => [
                'title' => 'Ajuda para Formulário de Opção de Extração de Dados',
                'content' => '<p>Use o formulário de opção de extração de dados para adicionar opções específicas para perguntas,
                 facilitando a captura detalhada de informações durante o processo de extração de dados. Defina a pergunta à qual
                  a opção pertence, forneça uma descrição e certifique-se de que as opções cubram todos os aspectos relevantes da pergunta.</p>
                  <p><strong>Observação:</strong> Somente poderá adicionar opções de extração aos tipos, "Múltipla Escoljha" e "Única Escolha"</p>
                  <p><strong>Exemplo:</strong></p>
                <ul>
                    <li>Descrição: Resumo - Tipo de dado: Texto.</li>
                    <li>Descrição: Base de Dados - Tipo de dado: Lista de Escolha Única. (Lista: ACM, IEEE, Scopus)</li>
                </ul>',
            ],
            'question' => 'Pergunta',
            'option' => 'Opção',
            'add-option' => 'Adicionar Opção',
            'edit-option' => 'Editar Opção'
        ],
        'table' => [
            'header' => [
                'id' => 'ID',
                'description' => 'Descrição',
                'question-type' => 'Tipo de Pergunta',
                'options' => 'Opções',
                'actions' => 'Ações',
            ]
        ],
        'toasts' => [
            'denied' => 'A viewer cannot add, edit or delete data extraction questions.',
        ]
    ]
];