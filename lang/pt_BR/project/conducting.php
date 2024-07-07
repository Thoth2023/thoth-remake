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
        'data_extraction' => 'Extração de Dados',
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

    'snowballing' => 'Snowballing',

    'import-studies' => [
        'title' => 'Importação de estudos',
        'form' => [
            'database' => 'Base de dados',
            'selected-database' => 'Selecionar a base de dados',
            'upload' => 'Escolher arquivo',
            'add' => 'Adicionar arquivo',
            'delete' => 'Deletar'
        ],
        'help' =>[
            'content' => 'Insira Arquivos no Formato ".bib", ".csv" ou ".txt" e faça a importação de arquivos de acordo com a base inserida no planejamento'
        ],
        'table' => [
            'database' => 'Base de dados',
            'studies-imported' => 'Total de Estudos Importados',
            'actions' => 'Ações',

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
