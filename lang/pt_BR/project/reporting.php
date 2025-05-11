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
        ],
        'kappa'=>[
            'title' => 'Método Kappa',
            'content'=>'',
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
    ]
];
