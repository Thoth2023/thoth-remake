<?php

return [
    'planning' => 'Planning',
    'button' => [
        'close' => 'Close',
    ],
    'placeholder' => [
        'search' => 'Search...',
    ],
    'overall' => [
        'title' => 'Overall Information',
        'no-results' => 'No results found.',
        'domain' => [
            'title' => 'Domains',
            'description' => 'Description',
            'add' => 'Add Domain',
            'update' => 'Update Domain',
            'list' => [
                'headers' => [
                    'name' => 'Name',
                    'description' => 'Description',
                    'enter_description' => 'Enter domain description',
                    'actions' => 'Actions',
                ],
                'actions' => [
                    'edit' => [
                        'button' => 'Edit',
                        'modal' => [
                            'title' => 'Edit Domain',
                            'description' => 'Description',
                            'cancel' => 'Cancel',
                            'save' => 'Save',
                        ],
                    ],
                    'delete' => [
                        'button' => 'Delete',
                        'modal' => [
                            'title' => 'Delete Domain',
                            'description' => 'Are you sure you want to delete this domain?',
                            'cancel' => 'Cancel',
                            'delete' => 'Delete',
                        ],
                    ],
                ],
                'empty' => 'No domains have been added yet.',
                'no-results' => 'No results found.',
            ],
            'help' => [
                'title' => 'Domains',
                'content' => 'Domains are thematic categories or subject areas that you define to structure and categorize ' .
                    'the diverse set of literature sources you encounter during your review. Each domain represents ' .
                    'a specific aspect or topic related to your research question or area of interest.',
            ],
            'livewire' => [
                'logs' => [
                    'added' => 'Domain added',
                    'updated' => 'Domain updated',
                    'deleted' => 'Domain deleted',
                ],
                'description' => [
                    'required' => 'The description field is required.'
                ],
                'toasts' => [
                    'added' => 'Domain added successfully.',
                    'updated' => 'Domain updated successfully.',
                    'deleted' => 'Domain deleted successfully.',
                ],
            ]
        ],
        'language' => [
            'title' => 'Languages',
            'add' => 'Add Language',
            'list' => [
                'select' => [
                    'placeholder' => 'Select a Language',
                    'validation' => 'The language field is required.',
                ],
                'headers' => [
                    'languages' => 'Languages',
                    'actions' => 'Actions',
                ],
                'actions' => [
                    'delete' => [
                        'button' => 'Delete',
                        'tooltip' => 'Delete Language',
                    ],
                ],
                'empty' => 'No languages have been added yet.',
            ],
            'help' => [
                'title' => 'Languages',
                'content' => 'Languages represent different languages in which literature sources are written. ' .
                    'You can add and manage languages to categorize the sources based on their language of origin.',
            ],
            'livewire' => [
                'logs' => [
                    'added' => 'Language added',
                    'updated' => 'Language updated',
                    'deleted' => 'Language deleted',
                ],
                'language' => [
                    'required' => 'The language field is required.',
                    'already_exists' => 'The selected language already exists in this project.'
                ],
                'toasts' => [
                    'added' => 'Language added successfully.',
                    'deleted' => 'Language deleted successfully.',
                ],
            ]
        ],
        'study_type' => [
            'title' => 'Study Types',
            'types' => 'Types',
            'add' => 'Add Study Type',
            'list' => [
                'select' => [
                    'placeholder' => 'Select a Study Type',
                    'validation' => 'The study type field is required.',
                ],
                'headers' => [
                    'types' => 'Types',
                    'actions' => 'Actions',
                ],
                'actions' => [
                    'delete' => [
                        'button' => 'Delete',
                        'tooltip' => 'Delete Study Type',
                    ],
                ],
                'empty' => 'No study types have been added yet.',
            ],
            'help' => [
                'title' => 'Study Types',
                'content' => 'Study types represent different categories or classifications for the types of studies ' .
                    'included in your literature review. You can add and manage study types to categorize ' .
                    'the sources based on the nature of the studies conducted.',
            ],
            'livewire' => [
                'logs' => [
                    'added' => 'Study type added',
                    'updated' => 'Study type updated',
                    'deleted' => 'Study type deleted',
                ],
                'studyType' => [
                    'required' => 'The study type field is required.',
                    'already_exists' => 'The selected study type already exists in this project.'
                ],
                'toasts' => [
                    'added' => 'Study type added successfully.',
                    'deleted' => 'Study type deleted successfully.',
                ],
            ]
        ],
        'keyword' => [
            'title' => 'Keywords',
            'description' => 'Description',
            'enter_description' => 'Enter keyword description',
            'add' => 'Add Keyword',
            'list' => [
                'headers' => [
                    'description' => 'Description',
                    'actions' => 'Actions',
                ],
                'actions' => [
                    'edit' => [
                        'button' => 'Edit',
                        'modal' => [
                            'title' => 'Edit Keyword',
                            'description' => 'Description',
                            'cancel' => 'Cancel',
                            'save' => 'Save',
                        ],
                    ],
                    'delete' => [
                        'button' => 'Delete',
                        'modal' => [
                            'title' => 'Delete Keyword',
                            'description' => 'Are you sure you want to delete this keyword?',
                            'cancel' => 'Cancel',
                            'delete' => 'Delete',
                        ],
                    ],
                ],
                'empty' => 'No keywords have been added yet.',
            ],
            'help' => [
                'title' => 'Keywords',
                'content' => 'Keywords are terms or phrases that represent key concepts in your research. ' .
                    'You can use keywords to categorize and organize your literature sources, making ' .
                    'it easier to identify relevant information for your project.',
            ],
            'livewire' => [
                'logs' => [
                    'added' => 'Keyword added',
                    'updated' => 'Keyword updated',
                    'deleted' => 'Keyword deleted',
                ],
                'description' => [
                    'required' => 'The description field is required.'
                ],
                'toasts' => [
                    'added' => 'Keyword added successfully.',
                    'updated' => 'Keyword updated successfully.',
                    'deleted' => 'Keyword deleted successfully.',
                ],
            ]
        ],
        'dates' => [
            'title' => 'Project Dates',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'add_date' => 'Add Date',
            'help' => [
                'title' => 'Project Dates',
                'content' => 'Set the start and end dates for your project to define the period during which you will ' .
                    'conduct your literature review. This will help you to keep track of your progress and to ' .
                    'schedule your work effectively.',
            ],
            'livewire' => [
                'logs' => [
                    'added' => 'Date added',
                    'updated' => 'Date updated',
                ],
                'date' => [
                    'invalid' => 'The date field is invalid. Please enter a valid date.',
                ],
                'start_date' => [
                    'required' => 'The start date field is required.',
                ],
                'end_date' => [
                    'required' => 'The end date field is required.',
                    'after' => 'The end date must be greater than the start date.',
                ],
                'toasts' => [
                    'updated' => 'Dates updated successfully.',
                ],
            ]
        ],
    ],
    'research-questions' => [
        'title' => 'Research Questions',
        'help' => [
            'title' => 'Research Questions Help',
            'content' => 'Research questions are key inquiries that guide your literature review. Each question should be clear, focused, and directly related to your research objectives. Add, edit, or delete research questions to refine the scope of your literature review.',
        ],
        'form' => [
            'id' => 'ID',
            'description' => 'Description',
            'enter_description' => 'Enter research question description',
            'add' => 'Add',
        ],
        'table' => [
            'id' => 'ID',
            'description' => 'Description',
            'actions' => 'Actions',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'no-questions' => 'No research questions found.',
            'empty' => 'No research questions registered in the project.'
        ],
        'edit-modal' => [
            'title' => 'Research Question Update',
            'id' => 'ID',
            'description' => 'Description',
            'update' => 'Update',
        ],
        'livewire' => [
            'logs' => [
                'added' => 'Research Question added',
                'updated' => 'Research Question updated',
                'deleted' => 'Research Question deleted',
            ],
            'description' => [
                'required' => 'The description field is required.'
            ],
            'toasts' => [
                'added' => 'Research Question added successfully.',
                'updated' => 'Research Question updated successfully.',
                'deleted' => 'Research Question deleted successfully.',
            ],
        ]
    ],
    'databases' => [
        'title' => 'Databases',
        'help' => [
            'title' => 'Databases Help',
            'content' => 'Databases are repositories of scholarly articles and publications. Select the databases you plan to search to gather relevant literature for your review. Add or remove databases based on the relevance to your research topic.',
        ],
        'form' => [
            'select-placeholder' => 'Select a Database',
            'add-button' => 'Add Database',
        ],
        'table' => [
            'name' => 'Name',
            'actions' => 'Actions',
            'header' => 'Databases',
            'remove-button' => 'Remove',
            'no-databases' => 'No databases found.',
            'empty' => 'No database registered in the project.',
        ],
        'suggest-new' => [
            'title' => 'Suggest a New Database',
            'name-label' => 'Database Name',
            'enter-name' => 'Enter database name',
            'link-label' => 'Database Link',
            'enter-link' => 'Enter database link',
            'submit-button' => 'Send suggestion',
        ],
        'errors' => [
            'name' => 'Error message for name field, if needed.',
        ],
        'livewire' => [
            'logs' => [
                'added' => 'Database added',
                'deleted' => 'Database deleted',
            ],
            'database' => [
                'required' => 'The database field is required.',
                'required_link' => 'The link field is required.',
                'already_exists' => 'The selected database already exists in this project.',
                'invalid_link' => 'The link field must be a valid URL.',
            ],
            'toasts' => [
                'added' => 'Database added successfully.',
                'deleted' => 'Database deleted successfully.',
                'suggested' => 'Database suggestion sent successfully.',
            ],
        ]
    ],
    'search-string' => [
        'title' => 'Search String',
    ],
    'search-strategy' => [
        'title' => 'Search Strategy',
        'help' => [
            'title' => 'Search Strategy Help',
            'content' => "
                <p>In the planning phase, it is necessary to determine and follow a search strategy. This should be developed in consultation with librarians or others with relevant experience. Search strategies are usually iterative and benefit from:</p>
                <ul>
                    <li>Conducting preliminary searches aimed at both identifying existing systematic reviews and assessing the volume of potentially relevant studies.</li>
                    <li>Performing trial searches using various combinations of search terms derived from the research question.</li>
                    <li>Cross-checking the trial research string against lists of already known primary studies.</li>
                    <li>Seeking consultations with experts in the field.</li>
                </ul>
            ",
        ],
        'placeholder' => 'Enter the search strategy',
        'save-button' => 'Save',
    ],
    'criteria' => [
        'title' => 'Inclusion/Exclusion Criteria',
        'help' => [
            'title' => 'Inclusion/Exclusion Criteria Help',
            'content' => '
                <p>In the criteria section, you define the criteria for selecting or excluding studies in your research project.</p>
                <p><strong>Inclusion Criteria:</strong> Specify the criteria that studies must meet to be included in your research.</p>
                <p><strong>Exclusion Criteria:</strong> Specify the criteria that studies must meet to be excluded from your research.</p>
                <p>Make sure to carefully consider and document your criteria to ensure a systematic and transparent selection process.</p>
            ',
        ],
        'form' => [
            'id' => 'ID',
            'dont-use' => 'Do not use special characters',
            'description' => 'Description',
            'type' => 'Type',
            'inclusion' => 'Inclusion',
            'exclusion' => 'Exclusion',
            'add' => 'Add Criteria',
        ],
        'inclusion-table' => [
            'title' => 'Inclusion Criterias',
            'select' => 'Select',
            'id' => 'ID',
            'description' => 'Description',
            'edit' => 'Edit',
            'delete' => 'Delete Criteria',
            'no-criteria' => 'No criteria found.',
            'rule' => 'Inclusion Rule',
            'all' => 'All',
            'any' => 'Any',
            'at-least' => 'At Least',
        ],
        'exclusion-table' => [
            'title' => 'Exclusion Criterias',
            'select' => 'Select',
            'id' => 'ID',
            'description' => 'Description',
            'edit' => 'Edit',
            'delete' => 'Delete Criteria',
            'no-criteria' => 'No criteria found.',
            'rule' => 'Exclusion Rule',
            'all' => 'All',
            'any' => 'Any',
            'at-least' => 'At Least',
        ],
    ],
    'quality-assessment' => [
        'title' => 'Quality Assessment',
    ],
    'data-extraction' => [
        'title' => 'Data Extraction',
        'question-form' => [
            'title' => 'Create Data Extraction Question',
            'help' => [
                'title' => 'Data Extraction Question Form Help',
                'content' => 'Use the data extraction question form to create questions that guide the extraction of specific information from selected studies. Define the question ID, description, type, and add options if needed. This step ensures structured and comprehensive data extraction.',
            ],
            'id' => 'ID',
            'dont-use' => 'Do not use special characters',
            'description' => 'Description',
            'type' => 'Type',
            'add-question' => 'Add Question',
        ],
        'option-form' => [
            'title' => 'Create Data Extraction Question Option',
            'help' => [
                'title' => 'Data Extraction Option Form Help',
                'content' => 'Use the data extraction option form to add specific options for questions, facilitating detailed information capture during the data extraction process. Define the question to which the option belongs, provide a description, and ensure that options cover all relevant aspects of the question.',
            ],
            'question' => 'Question',
            'option' => 'Option',
            'add-option' => 'Add Option',
        ],
        'table' => [
            'header' => [
                'id' => 'ID',
                'description' => 'Description',
                'question-type' => 'Question Type',
                'options' => 'Options',
                'actions' => 'Actions',
            ]
        ]
    ]
];
