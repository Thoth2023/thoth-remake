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
            'content' => 'Study selection is a crucial phase of the systematic review, where the author examines the title, abstract, and keywords of each study, assessing them according to the inclusion and exclusion criteria established in the review planning. Based on these criteria, the status of each study will be automatically updated. However, the researcher has the option to manually set the status, but in doing so, the system will not record which criteria were considered in the evaluation.'
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
        'buttons' => [
            'csv' => 'Export CSV',
            'xml' => 'Export XML',
            'pdf' => 'Export PDF',
            'print' => 'Print',
            'duplicates' => 'Find Duplicates',
            'filter' => 'Filter',
            'filter-by' => 'Filter by',
            'select-database' => 'Show all Databases',
            'select-status' => 'Show all Statuses...',
            'search-papers' => 'Search papers...',
        ],
        'modal' => [
            'author' => 'Author',
            'year' => 'Year',
            'database' => 'Database',
            'status-selection' => 'Status Selection',
            'abstract' => 'Abstract',
            'keywords' => 'Keywords',
            'rejected' => 'Rejected',
            'table' => [
                'select' => 'Select',
                'description' => 'Description',
                'type' => 'Type',
                'inclusion' => 'Inclusion',
                'exclusion' => 'Exclusion',
            ],
            'option' => [
                'select'=>'Select an option',
                'remove' => 'Remove',
                'accepted' => 'Accepted',
                'rejected' => 'Rejected',
                'duplicated' => 'Duplicate',
                'unclassified' => 'Unclassified'
            ],
            'save'=>'Save',
            'close'=>'Close',

        ],
        'status' => [
            'duplicate' => 'Duplicate',
            'removed' => 'Removed',
            'unclassified' => 'Unclassified',
            'included' => 'Included',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'accepted' => 'Accepted'
        ],
        'count'=>[
            'toasts' =>[
                'no-databases'=>'No databases found for this project.',
                'no-papers'=>'No papers imported for this project.',
                'data-refresh'=>'Data refreshed successfully',
            ]
        ]
    ],

    'quality-assessment' => [
        'title' => 'Quality Assessment',
        'help' => [
            'content' => '???'
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
            'general-score' => 'General Score',
            'score' => 'Score',
        ],
        'buttons' => [
            'csv' => 'Export CSV',
            'xml' => 'Export XML',
            'pdf' => 'Export PDF',
            'print' => 'Print',
            'duplicates' => 'Find Duplicates',
            'filter' => 'Filter',
            'filter-by' => 'Filter by',
            'select-database' => 'Show all Databases',
            'select-status' => 'Show all Statuses...',
            'search-papers' => 'Search papers...',
        ],
        'modal' => [
            'author' => 'Author',
            'year' => 'Year',
            'database' => 'Database',
            'status-quality' => 'Status Quality',
            'abstract' => 'Abstract',
            'keywords' => 'Keywords',
            'rejected' => 'Rejected',
            'table' => [
                'select' => 'Select',
                'description' => 'Description',
                'score' => 'Score',
                'min-to-app' => 'Minimal to<br/> Approve',
            ],
            'option' => [
                'select'=>'Select an option',
                'remove' => 'Remove',
                'accepted' => 'Accepted',
                'rejected' => 'Rejected',
                'duplicated' => 'Duplicate',
                'unclassified' => 'Unclassified',
            ],
            'save'=>'Save',
            'close'=>'Close',

        ],
        'status' => [
            'duplicate' => 'Duplicate',
            'removed' => 'Removed',
            'unclassified' => 'Unclassified',
            'included' => 'Included',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'accepted' => 'Accepted'
        ],
        'count'=>[
            'toasts' =>[
                'no-databases'=>'No databases found for this project.',
                'no-papers'=>'No papers imported for this project.',
                'data-refresh'=>'Data refreshed successfully',
            ]
        ]
    ],

    'snowballing' => [
        'title' => 'Snowballing',
        'help' => [
            'content' => '???'
        ],
        'papers' => [
            'empty' => 'No papers have been added yet.',
            'no-results' => 'No results found.'
        ],
        'table' => [
            'id' => 'ID',
            'title' => 'Title',
            'status' => 'Status',
            'database' => 'Database',
            'actions' => 'Actions',
            'year' => 'Year',
        ],
        'buttons' => [
            'csv' => 'Export CSV',
            'xml' => 'Export XML',
            'pdf' => 'Export PDF',
            'print' => 'Print',
            'duplicates' => 'Find Duplicates',
            'filter' => 'Filter',
            'filter-by' => 'Filter by',
            'select-database' => 'Show all Databases',
            'select-status' => 'Show all Statuses...',
            'select-type' => 'Show all Types...',
            'search-papers' => 'Search papers...',
        ],
        'modal' => [
            'author' => 'Author',
            'year' => 'Year',
            'database' => 'Database',
            'status-snowballing' => 'Status Snowballing',
            'abstract' => 'Abstract',
            'keywords' => 'Keywords',
            'rejected' => 'Rejected',
            'table' => [
                'select' => 'Select',
                'description' => 'Description',
                'type' => 'Type',
            ],
            'option' => [
                'select'=>'Select an option',
                'remove' => 'Remove',
                'accepted' => 'Accepted',
                'rejected' => 'Rejected',
                'duplicated' => 'Duplicate',
                'unclassified' => 'Unclassified',
            ],
            'save'=>'Save',
            'close'=>'Close',

        ],
        'status' => [
            'duplicate' => 'Duplicate',
            'removed' => 'Removed',
            'unclassified' => 'Unclassified',
            'included' => 'Included',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'accepted' => 'Accepted'
        ],
        'count'=>[
            'toasts' =>[
                'no-databases'=>'No databases found for this project.',
                'no-papers'=>'No papers imported for this project.',
                'data-refresh'=>'Data refreshed successfully',
            ]
        ]
    ],

    'data-extraction' => [
        'title' => 'Data Extraction',
        'help' => [
            'content' => '???'
        ],
        'papers' => [
            'empty' => 'No papers have been added yet.',
            'no-results' => 'No results found.'
        ],
        'table' => [
            'id' => 'ID',
            'title' => 'Title',
            'status' => 'Status',
            'database' => 'Database',
            'actions' => 'Actions',
            'year' => 'Year',
        ],
        'buttons' => [
            'csv' => 'Export CSV',
            'xml' => 'Export XML',
            'pdf' => 'Export PDF',
            'print' => 'Print',
            'duplicates' => 'Find Duplicates',
            'filter' => 'Filter',
            'filter-by' => 'Filter by',
            'select-database' => 'Show all Databases',
            'select-status' => 'Show all Statuses...',
            'search-papers' => 'Search papers...',
        ],
        'modal' => [
            'author' => 'Author',
            'year' => 'Year',
            'database' => 'Database',
            'status-extraction' => 'Status Extraction',
            'abstract' => 'Abstract',
            'keywords' => 'Keywords',
            'table' => [
                'select' => 'Select',
                'description' => 'Description',
                'type' => 'Type',
            ],
            'option' => [
                'select'=>'Select an option',
                'removed' => 'Removed',
                'done' => 'Done',
                'to_do' => 'To Do',
                'to do' => 'To Do',
                'unclassified' => 'Unclassified',
            ],
            'save'=>'Save',
            'close'=>'Close',

        ],
        'status' => [
            'done' => 'Done',
            'removed' => 'Removed',
            'to_do' => 'To Do',
            'to do' => 'To Do',

        ],
        'count'=>[
            'toasts' =>[
                'no-databases'=>'No databases found for this project.',
                'no-papers'=>'No papers imported for this project.',
                'data-refresh'=>'Data refreshed successfully',
            ]
        ]
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
