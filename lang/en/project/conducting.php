<?php

return [

    'conducting' => [
        'title' => 'Conducting'
    ],
    'header' => [
        'overview' => 'Overview',
        'import_studies' => 'Import Studies',
        'study_selection' => 'Study Selection',
        'quality_assessment' => 'Quality Assessment',
        'data_extraction' => 'Data Extraction',

    ],
    'study-selection' => [
        'title' => '',
        'table' => [
            'id' => 'ID',
            'title' => 'Title',
            'acceptance-criteria' => 'Inclusion Criteria',
            'rejection-criteria' => 'Rejection Criteria',
            'status' => 'Status',
            'database' => 'Database',
            'actions' => 'Actions',
        ],
        'status' => [
            'duplicated' => 'Duplicated',
            'removed' => 'Removed',
            'unclassified' => 'Unclassified',
            'included' => 'Included',
            'approved' => 'Approved'
        ],
        'snowballing' => 'Snowballing'
    ],
    'import-studies' => [
        'title' => 'Import Studies',
        'form' => [
                'database' => 'Database',
                'selected-database' => 'Select Database',
                'upload' => 'Choose File',
                'add' => 'Add File',
                'delete' => 'Delete'
        ],
        'help' =>[
            'content' => 'Insert files in ".bib", ".csv" or ".txt" format and import files according to the database inserted in the planning'
        ],
        'table' => [
            'database' => 'Database',
            'studies-imported' => 'Total imported studies',
            'actions' => 'Actions',
        ],
    ]

];
