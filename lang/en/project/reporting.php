<?php

return [

    'reporting' => 'Reporting',
    'header' => [
        'overview' => 'Overview',
        'reliability' => 'Reliability',
        'import_studies' => 'Import Studies',
        'study_selection' => 'Study Selection',
        'quality_assessment' => 'Quality Assessment',
        'data_extraction' => 'Data Extraction',
        'snowballing' => 'Snowballing',
    ],
    'reliability' =>[
        'selection' =>[
            'title' => 'Reliability Study Selection (Peer Review)',
            'content'=>'',
        ],
        'quality'=>[
            'title' => 'Reliability Quality Assessment (Peer Review)',
            'content'=>'',
        ],
        'agreement'=>[
            'title' => 'Simple Agreement',
            'content'=>'',
        ],
        'kappa'=>[
            'title' => 'Method Kappa (Peer Review)',
            'content'=>'',
        ],
        'pesquisador'=>'Researcher',
        'peer-review'=>'Peer Review',
    ],
    'check' => [
        'no_imported_studies' => 'No imported studies were found for this project.',
        'no_selected_studies' => 'No selected studies were found for this project.',
        'no_criteria_signed_by_anyone' => 'No criteria were signed by anyone.',
        'no_papers_and_status_selection' => 'No papers were selected by anyone for this project.',
        'no_evaluated_studies' => 'No evaluated studies were found for this project.',
        'no_papers_evaluated_by_anyone' => 'No papers were evaluated by anyone.',
        'no_extracted_data_by_anyone' => 'No data was extracted by anyone.',
    ]
];
