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

    'data-extraction' => [
        'title' => 'Data Extraction',
        'progress-data-extraction' => 'Data Extraction Progress',
        'status' => [
            'done' => 'Done',
            'todo' => 'To Do',
            'removed' => 'Removed',
            'total' => 'Total'
        ],
        'list_studies' => 'List of Studies for Data Extraction',
        'table' => [
            'id' => 'ID',
            'title' => 'Title',
            'author' => 'Author',
            'year' => 'Year',
            'database' => 'Database',
            'status' => 'Status',
            'actions' => 'Actions'
        ],
        'details' => 'View Details',
        'modal_paper_ex' => [
            'title' => 'Title',
            'doi' => 'Doi',
            'url' => 'URL',
            'export' => 'Export',
            'author' => 'Author',
            'year' => 'Year',
            'database' => 'Data Base',
            'status' => [
                'status-extraction' => 'Status Extraction',
                'done' => 'Done',
                'to_do' => 'To do',
                'removed' => 'Removed'
            ],
            'abstract' => 'Abstract',
            'keywords' => 'Keywords',
            'extraction_questions' => 'Extraction Questions',
            'notes' => 'Notes',
            'save'  => 'Save'
        ],
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

       'help' => [
            'content' => 'Insert files in ".bib", ".csv" or ".txt" format and import files according to the database inserted in the planning'

        ],
        'table' => [
            'database' => 'Database',
            'studies-imported' => 'Total imported studies',
            'actions' => 'Actions',
            'file' => 'File',
            'file-imported' => 'Files imported',
            'delete' => 'Delete',
        ],
    ],

    'progress_bar' => [
        'title' => 'Progress Data Extraction',
        'progress_title' => 'Progress'
    ],

    'search' => [
        'title' => 'Search',
        'placeholder' => 'Select a Study',
        'add' => 'Add a Study',
        'help' => [
            'title' => 'Search',
            'content' => '',
        ],
    ],

    'table' => [
        'id' => 'ID',
        'title' => 'Title',
        'author' => 'Author',
        'year' => 'Year',
        'data_base' => 'Data Base',
        'status' => 'Status',
    ],

    'status_extraction' => [
        'title' => 'Extraction Status',
        'no_extraction' => 'Not Extracted',
        'extracted' => 'Extracted',
        'removed' => 'Removed',
    ],

    'feedback' => [
        'done' => 'Status updated to Completed',
        'removed' => 'Study successfully removed.',
    ],

    'questions_table' => [
        'title' => 'Study Details',
    ],

];
