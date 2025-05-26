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

    'overview'=> [
        'systematic-mapping-study' => [
            'title' => 'Systematic Mapping Study on Domain-Specific Language Development Tools Funnel',
            'database' => [
                'title' => 'Database',
                'content'=>'Search in Digital Libraries',
            ],
            'imported-studies' => 'Imported Studies',
            'duplicates' => [
                'title'=> 'Duplicates',
                'content'=>'Duplicates Removal',
            ],
            'studies' => 'Studies',
            'study-selection' => [
                'title'=> 'Study Selection',
                'content'=>'I/E Removed',
            ],
            'studies-I/E-included'=> 'Studies I/E Included',
            'quality-assessment' => [
                'title' => 'Quality Assessment',
                'content'=> 'QA rejected',
            ],
            'studies-accepted' => [
                'title' => '#Avaiable Data Extraction',
                'content'=>'Studies accepted',
            ],
            'not-duplicate' => 'Not Duplicates',
            'status-selection' => 'Status Selection',
            'status-quality'=> 'Status Quality',
            'status-extration' => 'Status Extraction',
        ],
        'stages-systematic-review'=>'Stages of Systematic Literature Review or Systematic Mapping Study',
        'project-activities-overtime'=> 'Project Activities Over Time',
        'total-activities'=> 'Atividades Totais',
        'project'=> 'Project',
    ],
  
    'imported-studies'=> [
        'papers-database'=> [
            'title'=> 'Papers by Database',
            'content'=> 'Papers',
        ],
        'number-papers-year' => [
            'title'=> 'Number of Papers by Year',
            'year'=> 'Year',
            'number-of-papers'=> 'Number of Papers',
        ],
    ],
  
    'study-selection'=> [
        'papers-per-selection' => [
            'title'=> 'Papers per Status Selection',
            'content'=> 'Papers',
        ],
        'criteria-marked-user'=> [
            'title'=> 'Criteria Marked by User',
            'criteria-identified-study-selection' => 'Criteria Identified in Study Selection',
            'number-times' => 'Number of Times',
            'criteria' => 'Criteria',
            'user' => 'User',
            'value' => 'Value',
        ],
        'number-papers-user-status-selection' => [
            'title'=> 'Number of Papers by User and Status Selection',
            'users' => 'Users',
            'number-papers' => 'Number of Papers',
        ],
    ],
  
    'quality-assessment'=> [
        'papers-status-quality'=> [
            'title'=> 'Papers per Status Quality',
            'content'=> 'Papers',
        ],
        'papers-general-score'=> [
            'title'=> 'Papers per General Score',
            'content'=> 'Papers',
        ],
        'number-papers-user-status-quality'=> [
            'title' => 'Number of Papers per User and Status Quality',
            'users'=> 'User',
            'number-papers' => 'Number of Papers',
        ]
    ],

    'data-extraction'=> [
        'data-extraction-wordcloud'=> 'Data Extraction Wordcloud',
        'data-extraction-answer-packed-bubble'=> 'Data Extraction Answers - Packed Bubble',
        'comparasion-answers-question'=> [
            'title'=> 'Comparison of Answers per Question',
            'content'=> 'Answers',
        ]
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
            'title-modal' => 'Simple Agreement Analysis',
            'agreement-percentual'=> 'Agreement Percentual (%)',
        ],
        'kappa'=>[
            'title' => 'Method Kappa (Peer Review)',
            'content'=>'',
            'title-modal' => 'Kappa Analysis',
            'kappa-value' => 'Kappa Value',
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
        'study-selection'=> 'Study Selection',
        'quality-assessment'=> 'Quality Assessment',
    ]
];
