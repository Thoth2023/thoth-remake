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
            'content' => '??'

        ],
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
        'status' => [
            'duplicated' => 'Duplicado',
            'removed' => 'Removido',
            'unclassified' => 'Não Classificado',
            'approved' => 'Aprovado',
            'included' => 'Incluido'
        ],
        'count' => [
            'toasts' => [
                'no-databases' => 'Nenhuma base de dados encontrada para este projeto.',
                'no-papers' => 'Nenhum paper importado para este projeto.',
                'data-refresh' => 'Dados atualizados com sucesso',
            ],
        ],

    ],
    'snowballing' => 'Snowballing',


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

    'data-extraction' => [
        'title' => 'Extração de Dados',
        'progress-data-extraction' => 'Progresso da Extração de Dados',
        'status' => [
            'done' => 'Concluído',
            'todo' => 'A fazer',
            'removed' => 'Removido',
            'total' => 'Total',

        ],
        'list_studies' => 'Lista de Estudos para Extração de Dados',
        'table' => [
            'id' => 'ID',
            'title' => 'Título',
            'author' => 'Autor',
            'year' => 'Ano',
            'database' => 'Base de Dados',
            'status' => 'Status',
            'actions' => 'Ações'
        ],
        'details' => 'Detalhar',
        'modal_paper_ex' => [
            'title' => 'Título',
            'doi' => 'Doi',
            'url' => 'URL',
            'export' => 'Exportar',
            'author' => 'Autor',
            'year' => 'Ano',
            'database' => 'Banco de Dados',
            'status' => [
                'status-extraction' => 'Status de Extração',
                'done' => 'Concluído',
                'to_do' => 'Pendente',
                'removed' => 'Removido'
            ],
            'abstract' => 'Resumo',
            'keywords' => 'Palavras Chave',
            'extraction_questions' => 'Questões de Extração',
            'notes' => 'Anotações',
            'save'  => 'Salvar'
        ],
    ],

];

