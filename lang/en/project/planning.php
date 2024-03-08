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
    ],
];

