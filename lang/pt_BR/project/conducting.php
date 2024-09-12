<?php

return [
    'conducting' => [
        'title' => 'Condução'
    ],
    'header' => [
        'overview' => 'Visão Geral',
        'import_studies' => 'Importar Estudos',
        'study_selection' => 'Seleção de Estudos',
        'quality_assessment' => 'Avaliação de Qualidade',
        'snowballing' => 'Estudos Snowballing',
        'data_extraction' => 'Extração de Dados',
    ],

    'study-selection' => [
        'title' => 'Seleção de Estudos',
        'help' => [
            'content' => 'A seleção de estudos é uma fase crucial da revisão sistemática, na qual o autor analisa o título, resumo e palavras-chave de cada estudo, avaliando-os conforme as regras dos critérios de inclusão e exclusão estabelecidos no planejamento da revisão. Com base nesses critérios, o status de cada estudo será automaticamente alterado. No entanto, o pesquisador tem a opção de definir o status manualmente, mas, ao fazer isso, o sistema não registrará quais critérios foram considerados na avaliação.'
        ],
        'tasks' => 'Complete essas tarefas para avançar',
        'papers' => [
            'empty' => 'Nenhum Paper foi adicionado ainda.',
            'no-results' => 'Nenhum resultado encontrado.'
        ],
        'table' => [
            'id' => 'ID',
            'title' => 'Título',
            'acceptance-criteria' => 'Critério de Aceitação',
            'rejection-criteria' => 'Critério de Rejeição',
            'status' => 'Status',
            'database' => 'Base de Dados',
            'actions' => 'Ações',
        ],
        'buttons' => [
            'csv' => 'Exportar CSV',
            'xml' => 'Exportar XML',
            'pdf' => 'Exportar PDF',
            'print' => 'Imprimir',
            'duplicates' => 'Encontrar Duplicados',
            'filter' => 'Filtrar',
            'filter-by' => 'Filtrar por',
            'select-database' => 'Mostrar todos as Bases',
            'select-status' => 'Mostrar todos Status...',
            'search-papers' => 'Buscar estudos...',
        ],
        'modal' => [
            'author' => 'Autor',
            'year' => 'Ano',
            'database' => 'Base de Dados',
            'status-selection' => 'Status da Seleção',
            'abstract' => 'Resumo',
            'keywords' => 'Palavras-chave',
            'rejected' => 'Rejeitado',
            'paper-conflict'=>'Resolver Conflitos: Decisão em Grupo',
            'paper-conflict-note'=>'Nota/Justificativa',
            'paper-conflict-writer'=>'Escreva sua nota/justificativa...',
            'sucess-decision'=>'Decisão em Grupo salva com sucesso.',
            'error-status'=>'Selecione sua Decisão Final',
            'last-confirmation' => 'Confirmado por',
            'confirmation-date' => 'em',
            'table' => [
                'select' => 'Selecionar',
                'description' => 'Descrição',
                'type' => 'Tipo',
                'inclusion' => 'Inclusão',
                'exclusion' => 'Exclusão',
                'conflicts-members' => 'Avaliação do Membro',
                'conflicts-criteria' => 'Critério I/E Selecionado',
                'conflicts-status' => 'Status da avaliação',
            ],
            'option' => [
                'select' => 'Selecione uma opção',
                'remove' => 'Remover',
                'accepted' => 'Aceito',
                'rejected' => 'Rejeitado',
                'duplicated' => 'Duplicado',
                'unclassified' => 'Unclassified',
                'final-decision' =>'Decisão final do grupo sobre o paper?',
            ],
            'save'=>'Salvar',
            'update'=>'Atualizar',
            'confirm'=>'Confirmar',
            'close'=>'Fechar',
            'error'=>'Erro',
            'success'=>'Sucesso',
        ],
        'status' => [
            'duplicate' => 'Duplicado',
            'removed' => 'Removido',
            'unclassified' => 'Não Classificado',
            'included' => 'Incluído',
            'approved' => 'Aprovado',
            'rejected' => 'Rejeitado',
            'accepted' => 'Aceito'
        ],
        'count' => [
            'toasts' => [
                'no-databases' => 'Nenhuma base de dados encontrada para este projeto.',
                'no-papers' => 'Nenhum paper importado para este projeto.',
                'data-refresh' => 'Dados atualizados com sucesso',
            ],
        ],

    ],
    'snowballing' => [
        'title' => 'Snowballing',
        'help' => [
            'content' => '???'
        ],
        'tasks' => 'Complete essas tarefas para avançar',
        'papers' => [
            'empty' => 'Nenhum artigo foi adicionado ainda.',
            'no-results' => 'Nenhum resultado encontrado.'
        ],
        'table' => [
            'id' => 'ID',
            'title' => 'Título',
            'status' => 'Status',
            'database' => 'Base de Dados',
            'actions' => 'Ações',
            'year' => 'Ano',
        ],
        'buttons' => [
            'csv' => 'Exportar CSV',
            'xml' => 'Exportar XML',
            'pdf' => 'Exportar PDF',
            'print' => 'Imprimir',
            'duplicates' => 'Encontrar Duplicados',
            'filter' => 'Filtrar',
            'filter-by' => 'Filtrar por',
            'select-database' => 'Mostrar todas as Bases de Dados',
            'select-status' => 'Mostrar todos os Status...',
            'select-type' => 'Mostrar todos os Tipos...',
            'search-papers' => 'Pesquisar artigos...',
        ],
        'modal' => [
            'author' => 'Autor',
            'year' => 'Ano',
            'database' => 'Base de Dados',
            'status-snowballing' => 'Status Snowballing',
            'abstract' => 'Resumo',
            'keywords' => 'Palavras-chave',
            'rejected' => 'Rejeitado',
            'table' => [
                'select' => 'Selecionar',
                'description' => 'Descrição',
                'type' => 'Tipo',
            ],
            'option' => [
                'select' => 'Selecione uma opção',
                'remove' => 'Remover',
                'accepted' => 'Aceito',
                'rejected' => 'Rejeitado',
                'duplicated' => 'Duplicado',
                'unclassified' => 'Não Classificado',
            ],
            'save' => 'Salvar',
            'close' => 'Fechar',
        ],
        'status' => [
            'duplicate' => 'Duplicado',
            'removed' => 'Removido',
            'unclassified' => 'Não Classificado',
            'included' => 'Incluído',
            'approved' => 'Aprovado',
            'rejected' => 'Rejeitado',
            'accepted' => 'Aceito'
        ],
        'count' => [
            'toasts' => [
                'no-databases' => 'Nenhuma base de dados encontrada para este projeto.',
                'no-papers' => 'Nenhum artigo importado para este projeto.',
                'data-refresh' => 'Dados atualizados com sucesso',
            ]
        ]
    ],


    'progress_bar' => [
        'title' => 'Progresso de Extração de Dados',
        'progress_title' => 'Progresso'
    ],

    'search' => [
        'title' => 'Pesquisa',
        'placeholder' => 'Selecione um Estudo',
        'add' => 'Add Novo Estudo',
        'help' => [
            'title' => 'Pesquisa',
            'content' => '',
        ],
    ],

    'table' => [
        'id' => 'ID',
        'title' => 'Titulo',
        'author' => 'Autor',
        'year' => 'Ano',
        'data_base' => 'Banco de Dados',
        'status' => 'Status',
    ],

    'status_extraction' => [
        'title' => 'Status da Extração',
        'no_extraction' => 'Não Extraido',
        'extracted' => 'Extraido',
        'removed' => 'Removido',
    ],

    'feedback' => [
        'done' => 'Status atualizado para Done.',
        'removed' => 'Estudo removido com sucesso.',
    ],

    'questions_table' => [
        'title' => 'Detalhes do Estudo',
    ],

    'import-studies' => [
        'title' => 'Importar estudos',
        'form' => [
                'database' => 'Base de dados',
                'selected-database' => 'Selecionar a base de dados',
                'upload' => 'Escolher arquivo',
                'add' =>  'Adicionar arquivo',
                'delete' => 'Deletar'
        ],
        'help' =>[
            'content' => 'Insira Arquivos no Formato ".bib" ou ".csv" e faça a importação de arquivos de acordo com a base inserida no planejamento'
        ],
         'table' => [
            'database' => 'Base de dados',

            'studies-imported' => 'Estudos importados',
            'actions' => 'Ações',
            'file' => 'Arquivo',
            'files-uploaded' => 'Arquivos carregados',
            'no-files' => 'Nenhum arquivo carregado para esta base de dados.',
            'delete' => 'Deletar',
        ],
        'livewire' => [
            'logs' => [
                'database_associated_papers_imported' => 'Papers associados à base de dados importados',
                'deleted_file_and_papers' => 'Arquivo e :count papers associados excluídos',
            ],
            'selectedDatabase' => [
                'value' => [
                    'required' => 'O campo da base de dados é obrigatório.',
                    'exists' => 'A base de dados selecionada não existe.',
                ],
            ],
            'file' => [
                'required' => 'O campo de descrição é obrigatório.',
                'mimes' => 'O arquivo deve ser do tipo: bib, csv, txt.',
                'max' => 'O tamanho do arquivo não deve exceder 10MB.',
            ],
            'toasts' => [
                'file_uploaded_success' => 'Arquivo carregado com sucesso. :count papers foram inseridos.',
                'file_upload_error' => 'Ocorreu um erro ao importar papers. ERRO: :message',
                'project_database_not_found' => 'Base de dados do projeto não encontrada.',
                'file_deleted_success' => 'Arquivo excluído com sucesso. :count papers associados também foram excluídos.',
                'file_delete_error' => 'Ocorreu um erro ao excluir o arquivo: :message',
            ],
        ],

    ],

    'quality-assessment' => [
        'title' => 'Avaliação de Qualidade',
        'help' => [
            'content' => '???'
        ],
        'tasks' => 'Complete essas tarefas para avançar',
        'papers' => [
            'empty' => 'Nenhum Paper foi adicionado ainda.',
            'no-results' => 'Nenhum resultado encontrado.'
        ],
        'table' => [
            'id' => 'ID',
            'title' => 'Título',
            'acceptance-criteria' => 'Critério de Aceitação',
            'rejection-criteria' => 'Critério de Rejeição',
            'status' => 'Status',
            'database' => 'Base de Dados',
            'actions' => 'Ações',
            'general-score' => 'Pontuação Geral',
            'score' => 'Pontuação',
        ],
        'buttons' => [
            'csv' => 'Exportar CSV',
            'xml' => 'Exportar XML',
            'pdf' => 'Exportar PDF',
            'print' => 'Imprimir',
            'duplicates' => 'Encontrar Duplicados',
            'filter' => 'Filtrar',
            'filter-by' => 'Filtrar por',
            'select-database' => 'Mostrar todos as Bases',
            'select-status' => 'Mostrar todos Status...',
            'search-papers' => 'Buscar estudos...',
        ],
        'modal' => [
            'author' => 'Autor',
            'year' => 'Ano',
            'database' => 'Base de Dados',
            'status-quality' => 'Status de Qualidade',
            'quality-questions' => 'Questões de Qualidade',
            'abstract' => 'Resumo',
            'keywords' => 'Palavras-chave',
            'rejected' => 'Rejeitado',
            'select-score'=> 'Selecione...',
            'quality-score'=> 'Pontuação',
            'quality-description'=> 'Qualidade',
            'table' => [
                'select' => 'Selecionar',
                'description' => 'Descrição',
                'score' => 'Pontuação',
                'min-to-app' => 'Mínimo para<br/> Aprovar',
            ],
            'option' => [
                'select' => 'Selecione uma opção',
                'remove' => 'Remover',
                'accepted' => 'Aceito',
                'rejected' => 'Rejeitado',
                'duplicated' => 'Duplicado',
                'unclassified' => 'Não Classificado',
            ],
            'save'=>'Salvar',
            'close'=>'Fechar',
        ],
        'status' => [
            'duplicate' => 'Duplicado',
            'removed' => 'Removido',
            'unclassified' => 'Não Classificado',
            'included' => 'Incluído',
            'approved' => 'Aprovado',
            'rejected' => 'Rejeitado',
            'accepted' => 'Aceito'
        ],
        'count' => [
            'toasts' => [
                'no-databases' => 'Nenhuma base de dados encontrada para este projeto.',
                'no-papers' => 'Nenhum paper importado para este projeto.',
                'data-refresh' => 'Dados atualizados com sucesso',
            ],
        ],

    ],

    'data-extraction' => [
        'title' => 'Extração de Dados',
        'help' => [
            'content' => '???'
        ],
        'tasks' => 'Complete essas tarefas para avançar',
        'papers' => [
            'empty' => 'Nenhum artigo foi adicionado ainda.',
            'no-results' => 'Nenhum resultado encontrado.'
        ],
        'table' => [
            'id' => 'ID',
            'title' => 'Título',
            'status' => 'Status',
            'database' => 'Base de Dados',
            'actions' => 'Ações',
            'year' => 'Ano',
        ],
        'buttons' => [
            'csv' => 'Exportar CSV',
            'xml' => 'Exportar XML',
            'pdf' => 'Exportar PDF',
            'print' => 'Imprimir',
            'duplicates' => 'Encontrar Duplicados',
            'filter' => 'Filtrar',
            'filter-by' => 'Filtrar por',
            'select-database' => 'Mostrar todas as Bases de Dados',
            'select-status' => 'Mostrar todos os Status...',
            'search-papers' => 'Pesquisar artigos...',
        ],
        'modal' => [
            'author' => 'Autor',
            'year' => 'Ano',
            'database' => 'Base de Dados',
            'status-extraction' => 'Status da Extração',
            'abstract' => 'Resumo',
            'keywords' => 'Palavras-chave',
            'table' => [
                'select' => 'Selecionar',
                'description' => 'Descrição',
                'type' => 'Tipo',
            ],
            'option' => [
                'select' => 'Selecione uma opção',
                'removed' => 'Remover',
                'done' => 'Concluído',
                'to_do' => 'A fazer',
                'to do' => 'A fazer',
                'unclassified' => 'Não Classificado',
            ],
            'save' => 'Salvar',
            'close' => 'Fechar',
        ],
        'status' => [
            'done' => 'Concluído',
            'removed' => 'Removido',
            'to do' => 'A Fazer',
            'to_do' => 'A Fazer',
        ],
        'count' => [
            'toasts' => [
                'no-databases' => 'Nenhuma base de dados encontrada para este projeto.',
                'no-papers' => 'Nenhum artigo importado para este projeto.',
                'data-refresh' => 'Dados atualizados com sucesso',
            ]
        ]
    ],


];

