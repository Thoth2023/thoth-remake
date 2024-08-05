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
        'snowballing' => 'Snowballing Studies',
        'data_extraction' => 'Data Extraction',

    ],
    'study-selection' => [
        'title' => 'Study Selection',
        'help' => [
            'content' => '??'

        ],
        'papers' => [
            'empty' => 'No papers have been added yet.',
            'no-results' => 'No results found.'
        ],
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
            'duplicated' => 'Duplicate',
            'removed' => 'Removed',
            'unclassified' => 'Unclassified',
            'included' => 'Included',
            'approved' => 'Approved'
        ],
        'count'=>[
            'toasts' =>[
                'no-databases'=>'No databases found for this project.',
                'no-papers'=>'No papers imported for this project.',
                'data-refresh'=>'Data refreshed successfully',
            ]
        ]
    ],
    'snowballing' => 'Snowballing',
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
            'delete' => 'Delete',
        ],

       'help' => [
            'content' => 'Insert files in ".bib", ".csv" or ".txt" format and import files according to the database inserted in the planning'

        ],
        'table' => [
            'database' => 'Database',
            'studies-imported' => 'Total imported studies',
            'actions' => 'Actions',
            'file' => 'File',
            'files-uploaded' => 'Files uploaded',
            'no-files'=>'No files uploaded for this database.',
            'delete' => 'Delete',
        ],

        'livewire' => [
            'logs' => [
                'database_associated_papers_imported' => 'Database associated papers imported',
                'deleted_file_and_papers' => 'Deleted file and :count associated papers',
            ],
            'selectedDatabase'=>[
                'value'=>[
                    'required'=>'The database field is required.',
                    'exists' =>'The selected database does not exist.',
                ]
            ],
            'file' => [
                'required' => 'The description field is required.',
                'mimes'=>'The file must be a type of: bib, csv, txt.',
                'max' => 'The file size must not exceed 10MB.',
            ],
            'toasts' => [
                'file_uploaded_success' => 'File uploaded successfully. :count papers were inserted.',
                'file_upload_error' => 'An error occurred while importing papers. ERRO: :message',
                'project_database_not_found' => 'Project database not found.',
                'file_deleted_success' => 'File deleted successfully. :count papers associated were also deleted.',
                'file_delete_error' => 'An error occurred while deleting the file: :message',
            ],
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
