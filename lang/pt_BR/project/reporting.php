<?php

return [

    'reporting' => 'Relatórios',
    'header' => [
        'overview' => 'Visão Geral',
        'reliability' => 'Concordância',
        'import_studies' => 'Importar Estudos',
        'study_selection' => 'Seleção de Estudos',
        'quality_assessment' => 'Avaliação de Qualidade',
        'data_extraction' => 'Extração de Dados',
        'snowballing' => 'Snowballing',
    ],

    'overview'=> [
        'systematic-mapping-study' => [
            'title' => 'Estudo de Mapeamento Sistemático sobre Ferramentas de Desenvolvimento de Linguagem específicas de domínio funil',
            'database' => [
                'title' => 'Banco de Dados',
                'content'=>'Busca em bibliotecas digitais',
            ],
            'imported-studies' => 'Estudos Importados',
            'duplicates' => [
                'title'=> 'Duplicados',
                'content'=>'Duplicados Removidos',
            ],
            'studies' => 'Estudos',
            'study-selection' => [
                'title'=> 'Seleção de Estudos',
                'content'=>'I/E Removidos',
            ],
            'studies-I/E-included'=> 'Estudos I/E Incluídos',
            'quality-assessment' => [
                'title' => 'Avaliação de Qualidade',
                'content'=> 'QA Rejeitados',
            ],
            'studies-accepted' => [
                'title' => '#Extração de Dados Disponível',
                'content'=>'Estudos Aceitos',
            ],
            'not-duplicate' => 'Não Duplicados',
            'status-selection' => 'Seleção de Status',
            'status-quality'=> 'Status de Qualidade',
            'status-extration' => 'Status de Extração',
        ],
        'stages-systematic-review'=>'Etapas da Revisão Sistemática da literatura ou estudo de mapeamento sistemático',
        'project-activities-overtime'=> 'Atividades do projeto ao longo do tempo',
        'total-activities'=> 'Atividades Totais',
        'project'=> 'Projeto',
    ],
    'imported-studies'=> [
        'papers-database'=> [
            'title'=> 'Estudos por Banco de Dados',
            'content'=> 'Estudos',
        ],
        'number-papers-year' => [
            'title'=> 'Número de Estudos por Ano',
            'year'=> 'Ano',
            'number-of-papers'=> 'Número de Estudos',
        ],
    ],
    'study-selection'=> [
        'papers-per-selection' => [
            'title'=> 'Estudos por Status de Seleção',
            'content'=> 'Estudos',
        ],
        'criteria-marked-user'=> [
            'title'=> 'Critérios Assinalados por Usuário',
            'criteria-identified-study-selection' => 'Critérios Assinalados na Seleção de Estudos',
            'number-times' => 'Número de Vezes',
            'criteria' => 'Critério',
            'user' => 'Usuário',
            'value' => 'Valor',
        ],
        'number-papers-user-status-selection' => [
            'title'=> 'Número de Estudos por Usuário e Status de Seleção',
            'users' => 'Usuários',
            'number-papers' => 'Número de Estudos',
            'accepted'=> 'Aceitos',
        ],
    ],
    'quality-assessment'=> [
        'papers-status-quality'=> [
            'title'=> 'Estudos por Status de Qualidade',
            'content'=> 'Estudos',
        ],
        'papers-general-score'=> [
            'title'=> 'Estudos por Pontuação Geral',
            'content'=> 'Estudos',
        ],
        'number-papers-user-status-quality'=> [
            'title' => 'Número de Estudos por Usuário e Status de Qualidade',
            'users'=> 'Usuários',
            'number-papers' => 'Número de Estudos',
        ]
    ],

    'data-extraction'=> [
        'data-extraction-wordcloud'=> 'Nuvem de Palavras da Extração de Dados',
        'data-extraction-answer-packed-bubble'=> 'Respostas de Extração de Dados - Packed Bubble',
        'comparasion-answers-question'=> [
            'title'=> 'Comparação de Respostas por Questão',
            'content'=> 'Respostas',
        ]
    ],

    'reliability' =>[
        'selection' =>[
            'title' => 'Concordância Seleção de Estudos (Avaliação por pares)',
            'content'=>'',
        ],
        'quality'=>[
            'title' => 'Concordância Avaliação de Qualidade (Avaliação por pares)',
            'content'=>'',
        ],
        'agreement'=>[
            'title' => 'Concordância Simples',
            'content'=>'',
            'title-modal' => 'Análise Concordância Simples',
            'agreement-percentual'=> 'Percentual de Concordância (%)',
        ],
        'kappa'=>[
            'title' => 'Método Kappa',
            'content'=>'',
            'title-modal' => 'Análise Kappa nas Etapas',
            'kappa-value' => 'Valor de Kappa',
        ],
        'pesquisador'=>'Pesquisador',
        'peer-review'=>'Avaliação por Pares (Revisor)',
    ],
    'check' => [
        'no_imported_studies' => 'Nenhum estudo foi importado nesse projeto.',
        'no_selected_studies' => 'Você não selecionou nenhum estudo nesse projeto.',
        'no_criteria_signed_by_anyone' => 'Nenhum critério foi assinado por ninguém.',
        'no_papers_and_status_selection' => 'Ninguém selecionou nenhum estudo nesse projeto.',
        'no_evaluated_studies' => 'Você não avaliou nenhum estudo nesse projeto.',
        'no_papers_evaluated_by_anyone' => 'Ninguém avaliou nenhum estudo nesse projeto.',
        'no_extracted_data_by_anyone' => 'Ninguém extraiu dados nesse projeto.',
        'study-selection'=> 'Seleção de Estudos',
        'quality-assessment'=> 'Avaliação de Qualidade',
    ]
];
