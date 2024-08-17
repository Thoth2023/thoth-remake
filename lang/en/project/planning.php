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
                    'a specific aspect or topic related to your research question or area of interest.
                    <br><strong>Example:</strong> Software Engineering, Medicine, Health Sciences, etc.',
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
                    'duplicate' => 'Domain duplicated is not allowed.',
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
                    'duplicate' => 'Keyword duplicated is not allowed.'
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
            'content' => 'Research questions are key inquiries that guide your literature review. Each question should be clear, focused, and directly related to your research objectives. Add, edit, or delete research questions to refine the scope of your literature review.
            <br><strong>Example:</strong> RQ01 - Are the studies systematic literature reviews?',
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
            'help'=>[
                'title' => 'Suggest a New Database',
                'content' => "Suggest a new database if it is necessary for your research and it is not included in Thoth's current list. It is important to note that this database will only be available for use after approval by the system administrators.",
            ] ,
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
        ],
        'database-manager' => [
            'title' => 'Database Manager',
            'description' => 'Here you can manage the suggested databases. You can approve or reject them.',
            'table' => [
                'title' => 'Suggested Databases',
                'headers' => [
                    'name' => 'Name',
                    'link' => 'Link',
                    'status' => 'Status',
                    'actions' => 'Actions',
                    'delete' => 'Delete',
                ],
                'states' => [
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                    'pending' => 'Pending',
                    'proposed' => 'Proposed',
                ],
                'actions' => [
                    'approve' => 'Approve',
                    'reject' => 'Reject',
                ],
                'empty' => 'No suggested databases found.',
            ],
            'modal' => [
                'approve' => [
                    'title' => 'Approve Database',
                    'description' => 'Are you sure you want to approve this database? The suggestion will be added to the list od databases.',
                    'cancel' => 'Cancel',
                    'approve' => 'Approve',
                ],
                'reject' => [
                    'title' => 'Reject Database',
                    'description' => 'Are you sure you want to reject this database?',
                    'cancel' => 'Cancel',
                    'reject' => 'Reject',
                ],
                'delete' => [
                    'title' => 'Delete Suggestion',
                    'description' => 'This action cannot be undone. This will remove the suggestion permanently.',
                    'cancel' => 'Cancel',
                    'delete' => 'Delete',
                ],
            ],
        ],
    ],
    'search-string' => [
        'generate-all' => 'Generate All Search Strings',
        'title' => 'Search String',
        'help' => 'Search string is a combination of search terms that you use to search for relevant literature in databases. Add search strings to each database to refine your search and improve the accuracy of your search results.',
        'form' => [
            'description' => 'Generic search string',
            'enter-description' => 'Enter search string description',
            'add' => 'Add Search String',
            'update' => 'Update Search String',
            'placeholder' => 'Enter the search string',
        ],
        'livewire' => [
            'toasts' => [
                'generated' => 'Search Strings generated successfully.',
                'updated-string' => 'Search String updated successfully.',
            ],
        ],
        'term' => [
            'title' => 'Search Term',
            'help' => 'Search terms are keywords that you use to search for relevant literature in databases. Add, edit, or delete search terms to refine your search string and improve the accuracy of your search results.',
            'form' => [
                'title' => 'Term',
                'placeholder' => 'Enter the search term',
                'synonyms' => 'Synonyms',
                'update' => 'Update Search Term',
                'add' => 'Add Search Term',
                'select' => 'Search Terms',
                'select-placeholder' => 'Select a term',
                'no-suggestions' => 'No suggestions found.',
                'language' => 'Language Suggestions',
            ],
            'table' => [
                'description' => 'Search Term',
                'actions' => 'Actions',
                'empty' => 'No search terms registered in the project.',
                'not-found' => 'No search terms found.',
            ],
            'livewire' => [
                'description' => [
                    'required' => 'The search term field is required.',
                ],
                'toasts' => [
                    'generated' => 'Search Strings generated successfully.',
                    'updated-string' => 'Search String updated successfully.',
                    'saved' => 'Search String saved successfully.',
                    'added' => 'Search Term added successfully.',
                    'updated' => 'Search Term updated successfully.',
                    'deleted' => 'Search Term deleted successfully.',
                ],
            ]
        ],
        'synonym' => [
            'form' => [
                'title' => 'Synonyms',
                'placeholder' => 'Enter the synonym',
            ]
        ]
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
                <p>Describe here to describe a strategy used for the research.</p>
            ",
        ],
        'placeholder' => 'Enter the search strategy',
        'save-button' => 'Save',
        'success'=> 'Search strategy updated successfully.',
    ],
    'criteria' => [
        'title' => 'Inclusion/Exclusion Criteria',
        'help' => [
            'title' => 'Inclusion/Exclusion Criteria',
            'content' => '
                <p>In the criteria section, you define the criteria for selecting or excluding studies in your research project.</p>
                <p><strong>Inclusion Criteria:</strong> Specify the criteria that studies must meet to be included in your research. Ex.: IC1 - The publication should propose a tool to support the performance test.</p>
                <p><strong>Exclusion Criteria:</strong> Specify the criteria that studies must meet to be excluded from your research. Ex.: EC1 Duplicate articles.</p>
                <p>Make sure to carefully consider and document your criteria to ensure a systematic and transparent selection process.</p>
                <ul><li><strong>All:</strong> The study must contain all the inclusion or exclusion criteria.</li>
                <li><strong>At Least:</strong> The study should contain at least the criteria selected.</li>
                <li><strong>Any:</strong> The study may contain any of the criteria.</li></ul>
            ',
        ],
        'form' => [
            'id' => 'ID',
            'dont-use' => 'Do not use special characters',
            'description' => 'Description',
            'enter_description' => 'Type the criteria description',
            'type' => 'Type',
            'inclusion' => 'Inclusion',
            'exclusion' => 'Exclusion',
            'add' => 'Add criteria',
            'update' => 'Update criteria',
            'select-placeholder' => 'Select the type of criteria',
            'select-inclusion' => 'Inclusion',
            'select-exclusion' => 'Exclusion',
        ],
        'inclusion-table' => [
            'title' => 'Inclusion Criteria',
            'select' => 'Select',
            'id' => 'ID',
            'description' => 'Description',
            'rule' => 'Inclusion Rule',
        ],
        'exclusion-table' => [
            'title' => 'Exclusion Criteria',
            'select' => 'Select',
            'id' => 'ID',
            'description' => 'Description',
            'rule' => 'Exclusion Rule',
        ],
        'table' => [
            'all' => 'All',
            'any' => 'Any',
            'at-least' => 'At Least',
            'empty' => 'No criteria found',
            'actions' => 'Actions',
        ],
        'livewire' => [
            'description' => [
                'required' => 'The description field is required.'
            ],
            'criteriaId' => [
                'required' => 'The ID field is required.',
                'regex' => 'The ID field must contain only letters and numbers.',
            ],
            'type' => [
                'required' => 'The type field is required.',
            ],
            'logs' => [
                'added' => 'Criteria added',
                'updated' => 'Criteria updated',
                'deleted' => 'Criteria deleted',
            ],
            'toasts' => [
                'added' => 'Criteria added successfully',
                'deleted' => 'Criteria deleted successfully',
                'updated' => 'Criteria updated successfully',
                'updated-inclusion' => 'Inclusion criteria rule updated',
                'updated-exclusion' => 'Exclusion criteria rule updated',
                'unique-id' => 'This ID is already in use. Please choose another an unique ID.',
                'type' => [
                    'required' => 'The type field is required.',
                ],
            ],
        ],
    ],
    'quality-assessment' => [
        'title' => 'Quality Assessment',
        'generate-intervals' => 'Generate Intervals',
        'ranges' => [
            'label-updated' => 'Label updated successfully.',
            'interval-updated' => 'Interval updated successfully.',
        ],
        'general-score' => [
            'title' => 'General Score',
            'help' => [
                'title' => 'General Score',
                'content' => '
                <p>You can define the intervals you deem necessary for your systematic review. However, remember to save the settings and
                specify the "minimum for approval." This planning will be crucial in the review\'s execution phase.</p>

                <strong>Example:</strong>
                <table class="table table-bordered table-striped small">
                            <thead>
                                <tr>
                                    <th>Min Score</th>
                                    <th>Max Score</th>
                                    <th>Label</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>0</td>
                                    <td>1</td>
                                    <td>Very Poor</td>
                                </tr>
                                <tr>
                                    <td>1.1</td>
                                    <td>2</td>
                                    <td>Poor</td>
                                </tr>
                                <tr>
                                    <td>2.1</td>
                                    <td>3</td>
                                    <td>Fair</td>
                                </tr>
                                <tr>
                                    <td>3.1</td>
                                    <td>4</td>
                                    <td>Good</td>
                                </tr>
                                <tr>
                                    <td>4.1</td>
                                    <td>5</td>
                                    <td>Very Good</td>
                                </tr>
                            </tbody>
                        </table>

                ',
            ],
            'start' => 'Enter the Minimum Score',
            'end' => 'Enter the Max Score',
            'description' => 'Description',
            'placeholder-start' => 'Min Score (0.0)',
            'placeholder-end' => 'Max Score (0.0)',
            'add' => 'Add General Score',
            'update' => 'Update General Score',
            'table' => [
                'min' => 'Min Score',
                'max' => 'Max Score',
                'description' => 'Description',
                'action' => 'Actions',
                'no-results' => 'No general score found.',
                'empty' => 'No general score registered in the project.',
            ],
            'livewire' => [
                'logs' => [
                    'added' => 'General Score added',
                    'updated' => 'General Score updated',
                ],
                'start' => [
                    'invalid' => 'The general score field is invalid. Please enter a valid general score.',
                    'required' => 'The general score field is invalid. Please enter a valid general score.',
                ],
                'end' => [
                    'required' => 'The end general score field is required.',
                    'after' => 'The end general score must be greater than the start general score.',
                ],
                'description' => [
                    'required' => 'The description general score field is required.',
                ],
                'toasts' => [
                    'added' => 'General Score added successfully.',
                    'updated' => 'General Score updated successfully.',
                    'deleted' => 'General Score deleted successfully.',
                ],
            ],

        ],
        'question-quality' => [
            'title' => 'Question Quality',
            'help' => [
                'title' => 'Question Quality',
                'content' => '
                <p>In addition to general inclusion/exclusion criteria, it is considered critical to assess the “quality” of primary studies:</p>
                    <ul>
                        <li>To provide still more detailed inclusion/exclusion criteria.</li>
                        <li>To investigate whether quality differences provide an explanation for differences in study results.</li>
                        <li>As a means of weighting the importance of individual studies when results are being synthesised.</li>
                        <li>To guide the interpretation of findings and determine the strength of inferences.</li>
                        <li>To guide recommendations for further research.</li>
                    </ul><br>

                    <strpong>Example:</strpong> QA01 - Does the study present the implementation of a tool for systematic literature review?',
            ],
            'id' => 'ID',
            'description' => 'Description',
            'weight' => 'Weight',
            'add' => 'Add Question Quality',
            'update' => 'Update Question Quality',
            'livewire' => [
                'logs' => [
                    'added' => 'Question Quality added',
                    'updated' => 'Question Quality updated',
                ],
                'id' => [
                    'required' => 'The question quality field is invalid. Please enter a valid question quality.',
                ],
                'weight' => [
                    'required' => 'The end question quality field is required.',
                ],
                'description' => [
                    'required' => 'The description question quality field is required.',
                ],
                'toasts' => [
                    'added' => 'Question Quality added successfully.',
                    'updated' => 'Question Quality updated successfully.',
                    'deleted' => 'Question Quality deleted successfully.',
                ],
            ],

        ],
        'question-score' => [
            'title' => 'Question Score',
            'select' => [
                'rule' => 'Select a rule'
            ],
            'question' => [
                'title' => 'Question',
                'placeholder' => 'Select a question',
            ],
            'help' => [
                'title' => 'Question Score',
                'content' => '
                    <p> The score and score rules are recorded as responses, and each response is associated with the previously registered quality questions.
                    For each question, after registering the scoring rules, a minimum criterion must be established for the approval of each quality question.</p>
                    <br>
                    <strong>Example</strong> (minimum to approval "*"):<br>
                <table class="table table-bordered table-striped small">
                    <thead>
                        <tr class="w-5">
                            <th>Score Rule</th>
                            <th>Score</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="w-5">
                            <td>Yes</td>
                            <td>100%</td>
                            <td>This study presents the implementation of a <br>tool for systematic literature review.</td>
                        </tr>
                        <tr class="50">
                            <td><strong>Partially*</strong></td>
                            <td>50%</td>
                            <td>This study presents partially the implementation of<br> a tool for systematic literature review.</td>
                        </tr>
                        <tr>
                            <td>No</td>
                            <td>0%</td>
                            <td>This study doesn\'t present the implementation of <br>a tool for systematic literature review.</td>
                        </tr>
                    </tbody>
                </table>
                ',
            ],
            'description' => [
                'title' => 'Description',
                'placeholder' => 'Enter description',
            ],
            'id_qa' => [
                'title' => 'Question Quality',
                'placeholder' => 'Select Question Quality',
                'no-question-available' => 'No questions available',
            ],
            'score_rule' => [
                'title' => 'Score Rule',
                'placeholder' => 'Enter Score Rule',
            ],
            'form' => [
                'select-qa-placeholder' => 'Select a Question Quality',
                'add' => 'Add Quality Score',
                'update' => 'Update Quality Score',
            ],
            'range' => [
                'score' => 'Score',
            ],
            'livewire' => [
                'logs' => [
                    'added' => 'Quality Score added',
                    'updated' => 'Quality Score updated',
                ],
                'id' => [
                    'required' => 'The quality score field is invalid. Please enter a valid quality score.',
                ],
                'weight' => [
                    'required' => 'The end quality score field is required.',
                ],
                'description' => [
                    'required' => 'The description quality score field is required.',
                ],
                'rule' => [
                    'required' => 'The score rule field is required.',
                ],
            ],
            'toasts' => [
                'added' => 'Quality Score added successfully.',
                'updated' => 'Quality Score updated successfully.',
                'deleted' => 'Quality Score deleted successfully.',
            ],
        ],

        'min-general-score' => [
            'title' => 'Minimal Score to Approve',
            'help-content' => '
                <p>After registering the quality questions, the sum of the weights for all previously recorded questions is automatically calculated by Thoth.</p>
                <strong>Minimum to Approval:</strong>
                <p>This criterion defines the range of minimum overall scores that should be considered the minimum threshold for accepting studies in the review.</p>
                <p><strong>Note:</strong> To register, you must first enter the quality questions, generate the overall score ranges, and save them in the ongoing review project.</p>
                ',
            'cutoff' => 'Cutoff (Min Score general)',
            'sum' => 'Total Weight',
            'form' => [
                'select-placeholder' => 'Select Minimal General Score to Approve',
                'add' => 'Add Minimal General Score',
                'update' => 'Update Minimal General Score',
                'empty' => 'No general scores available. Please register general scores.',
                'minimal-score' => 'Minimal score updated successfully',
            ],

            'livewire' => [
                'logs' => [
                    'added' => 'Minimal General Score to Approve added',
                    'updated' => 'Minimal General Score to Approve updated',
                ],
                'toasts' => [
                    'added' => 'Minimal General Score to Approve added successfully.',
                    'updated' => 'Minimal General Score to Approve updated successfully.',
                    'required' => 'Minimal General Score to Approve field is required.',
                ],
            ],

        ],


    ],
    'data-extraction' => [
        'title' => 'Data Extraction',
        'question-form' => [
            'title' => 'Create Data Extraction Question',
            'help' => [
                'title' => 'Data Extraction Question Form Help',
                'content' => '
                <p>The data extraction forms must be designed to collect all the information needed to address the review questions and the study quality criteria. If the quality criteria are to be used to identify inclusion/exclusion criteria, they require separate forms (since the information must be collected prior to the main data extraction exercise). If the quality criteria are to be used as part of the data analysis, the quality criteria and the review data can be included in the same form.
                </p>
                <p>In most cases, data extraction will define a set of numerical values that should be extracted for each study (e.g. number of subjects, treatment effect, confidence intervals, etc.). Numerical data are important for any attempt to summarise the results of a set of primary studies and are a prerequisite for meta-analysis (i.e. statistical techniques aimed at integrating the results of the primary studies).
                </p>
                <p>The extraction quest should be defined from a description and the type of data. The data types are:
                </p>
                <ul>
                    <li><strong>Text:</strong> The extracted data is defined through simple text, giving the researcher the freedom to define the extracted data.</li>
                    <li><strong>Pick One List:</strong> Through a predefined list of data, the researcher should choose only one data extraction option.</li>
                    <li><strong>Multiple Choice List:</strong> Through a predefined list of data, the researcher can choose more than one data extraction option.</li>
                </ul>

                ',
            ],
            'id' => 'ID',
            'dont-use' => 'Do not use special characters',
            'description' => 'Description',
            'type' => 'Type',
            'add-question' => 'Add Question',
            'edit-question' => 'Edit Question'
        ],
        'option-form' => [
            'title' => 'Create Data Extraction Question Option',
            'help' => [
                'title' => 'Data Extraction Option Form Help',
                'content' => '
                 <p>Use the data extraction option form to add specific options for questions,
                 facilitating the detailed capture of information during the data extraction process. Define the question to which
                 the option belongs, provide a description, and ensure that the options cover all relevant aspects of the question.</p>
                 <p><strong>Note:</strong> You can only add extraction options to "Multiple Choice" and "Pick One List" types.</p>
                <p><strong>Example:</strong></p>
                <ul>
                    <li>Description: Abstract - Type of data: Text.</li>
                    <li>Description: Database - Type of data: Pick One List. (List: ACM, IEEE, Scopus)</li>
                </ul>
                ',
            ],
            'question' => 'Question',
            'option' => 'Option',
            'add-option' => 'Add Option',
            'edit-option' => 'Edit Option'
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
