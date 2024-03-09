<?php

return [
    'overall' => [
        'title' => 'Overall Planning',
        'domain' => [
            'title' => 'Domains',
            'description' => 'Description',
            'add' => 'Add Domain',
            'list' => [
                'headers' => [
                    'name' => 'Name',
                    'description' => 'Description',
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
            ],
            'help' => [
                'title' => 'Domains',
                'content' => 'Domains are thematic categories or subject areas that you define to structure and categorize ' .
                             'the diverse set of literature sources you encounter during your review. Each domain represents ' .
                             'a specific aspect or topic related to your research question or area of interest.',
            ],
        ],
        'language' => [
            'title' => 'Languages',
            'add' => 'Add Language',
            'list' => [
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
        ],
        'study_type' => [
            'title' => 'Study Types',
            'types' => 'Types',
            'add' => 'Add Study Type',
            'list' => [
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
        ],
        'keyword' => [
            'title' => 'Keywords',
            'description' => 'Description',
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
        ],
    ],
];

