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
    'check' => [
        'domain' => 'Register the data for "Domain" for this review project.',
        'language' => 'Register the data for "Language" for this review project.',
        'study-types' => 'Register the data for "Study Types" for this review project.',
        'research-questions' => 'Register the data for "Research Questions" for this review project.',
        'databases' => 'Register the data for "Database" for this review project.',
        'term' => 'Register the data for "Search Terms" in the Search String for this review project.',
        'search-strategy' => 'Register the data for "Search Strategy" for this review project.',
        'criteria' => 'Register the data for "Inclusion or Exclusion Criteria" for this review project.',
        'general-score' => 'Register the data for "General Score/Intervals" in the Quality Assessment for this review project.',
        'cutoff' => 'Register the data for "Minimum Score for Approval" or complete the "General Score" for this review project.',
        'score-min' => 'Define the "Minimum Quality Score for Approval" for the questions in this review project.',
        'question-qa' => 'Register the "Quality Questions" or define the "Minimum Score for Approval" for this review project.',
        'score-qa' => 'Register the data for "Quality Score" for this review project.',
        'data-extraction' => 'Register the "Data Extraction Questions" for this review project.',
        'option-extraction' => 'Register the "Options" for the data extraction questions of this review project.'
    ],
    'study-selection' => [
        'title' => 'Study Selection',
        'help' => [
            'content' => 'Study selection is a crucial phase of the systematic review, where the author analyzes the title, abstract, and keywords of each study, evaluating them according to the inclusion and exclusion criteria established in the review plan. Based on these criteria, the status of each study will be automatically updated. However, the researcher has the option to manually set the status, but in doing so, the system will not record which criteria were considered during the evaluation.
            <br/><br/>
            <h6>Find Duplicates</h6>
            <p>We have two options to mark papers as duplicates: </p>
            <ul><li>1- Studies with the same "Title, Year, and Authors" information can all be marked as duplicates at once; </li>
            <li>2- Studies with only some similar information can be analyzed individually. </li></ul>
            <h6>Peer Review (Group Decision)</h6>
            <p>If the review is conducted with 2 or more researchers and <b>there is any disagreement</b> in the results, the following information will appear on the screen:</p>
            <ul><li><div class="badge bg-warning text-white" role="button" title="Resolve Conflicts">
                <i class="fa-solid fa-file-circle-exclamation"></i> Resolve
            </div> | A final group decision will be required.</li>
            <li><div class="badge bg-light text-dark" role="button"  title="Conflicts Resolved">
                <i class="fa-solid fa-check-circle"></i> OK
            </div>| Group decision already confirmed.</li></ul>
            <p>Note: If the review does not involve Peer Review, these options will not appear.</p>
            '
        ],
        'tasks' => 'Complete these tasks to advance',
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
            'paper-conflict'=>'Resolve Paper Conflicts: Group Decision - I/E Criteria ',
            'paper-conflict-note'=>'Note',
            'paper-conflict-writer'=>'Write note...',
            'success-decision'=>'Group Decision successfully',
            'error-status' => 'Select your Final Decision',
            'last-confirmation' => 'Last Confirmation',
            'confirmation-date' => 'in',
            'save-criterias' => 'Save/Apply Criterias',
            'table' => [
                'select' => 'Select',
                'description' => 'Description',
                'type' => 'Type',
                'inclusion' => 'Inclusion',
                'exclusion' => 'Exclusion',
                'conflicts-members' => 'Member Evaluation',
                'conflicts-criteria' => 'Selected I/E Criteria',
                'conflicts-status' => 'Evaluation Status',
            ],
            'option' => [
                'select' => 'Select an option',
                'remove' => 'Remove',
                'accepted' => 'Accepted',
                'rejected' => 'Rejected',
                'duplicated' => 'Duplicate',
                'unclassified' => 'Unclassified',
                'final-decision' => 'Final Decision Group about paper?',
            ],
            'save' => 'Save',
            'update' => 'Update',
            'confirm' => 'Confirm',
            'close' => 'Close',
            'error' => 'Error',
            'success' => 'Success',
        ],
        'messages' => [
            'criteria_updated' => 'Criteria updated successfully. New status: :status',
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
        'count' => [
            'toasts' => [
                'no-databases' => 'No databases found for this project.',
                'no-papers' => 'No papers imported for this project.',
                'data-refresh' => 'Data refreshed successfully',
            ],
        ],
        'duplicates' => [
            'title' => 'Duplicate Papers Review',
            'no-duplicates' => 'No duplicate papers were found.',
            'confirm-duplicate' => 'Paper marked as duplicate.',
            'erro-find-paper' => 'Error: Paper not found.',
            'marked-unclassified' => 'Paper marked as unclassified.',
            'analyse-all' => 'All duplicate papers have been analyzed.',
            'duplicates-all' => 'All papers with identical Author/Year/Title marked as Duplicates',
            'unique-papers' => 'papers possibly duplicated for individual analysis listed below.',
            'exact-duplicate-count' => 'papers with <b>Title/Year/Authors</b> exactly identical marked as duplicates.',
            'button-mark-all' => 'Mark the :count as Duplicates',
            'table-title' => 'Title',
            'table-year' => 'Year',
            'table-database' => 'Database',
            'table-duplicate' => 'Duplicate',
            'table-duplicate-yes' => 'YES',
            'table-duplicate-no' => 'NO',
        ],
        'toasts' => [
            'denied' => 'A viewer cannot edit the study selection.',
        ]

    ],

    'quality-assessment' => [
        'title' => 'Quality Assessment',
        'help' => [
            'content' => 'The Quality Assessment is an important phase where researchers must read the full study and answer the quality questions that were planned for this review. Based on the answers provided, the "Score, General Score, and Status" of this assessment are updated.
            <br/><br/>
            <h6>Peer Review (Group Decision)</h6>
            <p>If the assessment is conducted with 2 or more researchers and <b>there is any disagreement</b> in the result, the following information will appear on the screen:</p>
            <ul><li><div class="badge bg-warning text-white" role="button" title="Resolve Conflicts">
                <i class="fa-solid fa-file-circle-exclamation"></i> Resolve
            </div> | A final group decision will be required.</li>
            <li><div class="badge bg-light text-dark" role="button"  title="Conflicts Resolved">
                <i class="fa-solid fa-check-circle"></i> OK
            </div> | Group decision already confirmed.</li>
            <li><i class="fa-solid fa-users"></i> | Paper accepted in Peer Review (Group Decision) in the previous stage.</li></ul>
            <p>Note: If the review does not involve Peer Review, these options will not appear.</p>
            '
        ],
        'tasks' => 'Complete these tasks to advance',
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
            'no-papers' => 'No studies available for export.',
        ],
        'modal' => [
            'author' => 'Author',
            'year' => 'Year',
            'database' => 'Database',
            'status-quality' => 'Status Quality',
            'quality-questions' => 'Quality Questions',
            'abstract' => 'Abstract',
            'keywords' => 'Keywords',
            'rejected' => 'Rejected',
            'select-score' => 'Select...',
            'quality-score' => 'Score',
            'quality-description' => 'Quality',
            'table' => [
                'select' => 'Select',
                'description' => 'Description',
                'score' => 'Score',
                'min-to-app' => 'Minimal to<br/>Approve',
            ],
            'option' => [
                'select' => 'Select an option',
                'remove' => 'Remove',
                'accepted' => 'Accepted',
                'rejected' => 'Rejected',
                'duplicated' => 'Duplicate',
                'unclassified' => 'Unclassified',
            ],
            'save' => 'Save',
            'close' => 'Close',

        ],
        'resolve' => [
            'author' => 'Author',
            'year' => 'Year',
            'database' => 'Database',
            'status-selection' => 'Status Selection',
            'abstract' => 'Abstract',
            'keywords' => 'Keywords',
            'rejected' => 'Rejected',
            'paper-conflict' => 'Resolve Paper Conflicts: Group Decision - QA',
            'paper-conflict-note' => 'Note',
            'paper-conflict-writer' => 'Write note...',
            'success-decision' => 'Group Decision successfully',
            'resolved-decision' => 'Accepted for Peer Review (Group Decision) in the previous stage.',
            'error-status' => 'Select your Final Decision',
            'last-confirmation' => 'Last Confirmation',
            'confirmation-date' => 'in',
            'table' => [
                'select' => 'Select',
                'description' => 'Description',
                'type' => 'Type',
                'inclusion' => 'Inclusion',
                'exclusion' => 'Exclusion',
                'conflicts-members' => 'Member Evaluation',
                'conflicts-qa' => 'Score/General Score',
                'conflicts-status' => 'Evaluation Status',

            ],
            'option' => [
                'select' => 'Select an option',
                'remove' => 'Remove',
                'accepted' => 'Accepted',
                'rejected' => 'Rejected',
                'duplicated' => 'Duplicate',
                'unclassified' => 'Unclassified',
                'final-decision' => 'Final Decision Group about paper?',
            ],
            'save' => 'Save',
            'update' => 'Update',
            'confirm' => 'Confirm',
            'close' => 'Close',
            'error' => 'Error',
            'success' => 'Success',
        ],
        'messages' => [
            'evaluation_quality_score_updated' => 'Evaluation Quality Score updated successfully.',
            'status_quality_updated' => 'Status Quality updated successfully. New status: :status',
            'status_updated_for_selection' => 'Status updated for your selection. New status: :status',
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
        'count' => [
            'toasts' => [
                'no-databases' => 'No databases found for this project.',
                'no-papers' => 'No papers imported for this project.',
                'data-refresh' => 'Data refreshed successfully',
            ]
        ]
    ],

    'snowballing' => [
        'title' => 'Snowballing',
        'help' => [
            'content' => 'Snowballing involves recursively searching for relevant references cited in the retrieved literature and adding them to the research results. Snowballing is an alternative approach to discover additional evidence that was not retrieved through conventional search methods. The effectiveness of snowballing makes it a recommended practice in systematic reviews.
            <br/><br/>
            <h6>Finding References (Snowballing)</h6>
            <p>References are retrieved via the <b>CrossRef API</b>.</p>
            <ul><li><b>Backward</b> | The first step is to examine the reference list and exclude articles that do not meet basic criteria, such as language, publication year, and type of publication (if only peer-reviewed articles are considered). <b>Verify/investigate where and how this study is referenced;</b></li>
            <li><b>Forward</b> | refers to identifying new articles based on those that cite the article being examined.</li></ul>

            <i class="fa-solid fa-users"></i> | Paper accepted in Peer Review (Group Decision) in the previous stage.
            <p>Note: If the review does not involve Peer Review, this icon will not appear.</p>
            '
        ],
        'tasks' => 'Complete these tasks to advance',
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
                'select' => 'Select an option',
                'remove' => 'Remove',
                'accepted' => 'Accepted',
                'rejected' => 'Rejected',
                'duplicated' => 'Duplicate',
                'unclassified' => 'Unclassified',
            ],
            'save' => 'Save',
            'close' => 'Close',

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
        'count' => [
            'toasts' => [
                'no-databases' => 'No databases found for this project.',
                'no-papers' => 'No papers imported for this project.',
                'data-refresh' => 'Data refreshed successfully',
            ]
        ]
    ],

    'data-extraction' => [
        'title' => 'Data Extraction',
        'help' => [
            'content' => 'Data Extraction is the final phase of the review. In this stage, after reading the full study, researchers must extract the information
            that answers the extraction questions planned. Once completed, it is necessary to mark the extraction as finalized for each study, so that this information is included in the existing reports.
            <br/><br/>
            <h6>Peer Review (Group Decision)</h6>
            <p>If the assessment is conducted with 2 or more researchers and <b>there is any disagreement</b> in the result, the following information will appear on the screen:</p>
            <ul><li><i class="fa-solid fa-users"></i> | Paper accepted in Peer Review (Group Decision) in the previous stage.</li></ul>
            <p>Note: If the review does not involve Peer Review, these options will not appear.</p>
            '
        ],
        'tasks' => 'Complete these tasks to advance',
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
            'no-papers' => 'No studies available for export.',
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
                'select' => 'Select an option',
                'removed' => 'Removed',
                'done' => 'Done',
                'to_do' => 'To Do',
                'to do' => 'To Do',
                'unclassified' => 'Unclassified',
            ],
            'save' => 'Save',
            'close' => 'Close',

        ],
        'status' => [
            'done' => 'Done',
            'removed' => 'Removed',
            'to_do' => 'To Do',
            'to do' => 'To Do',

        ],
        'count' => [
            'toasts' => [
                'no-databases' => 'No databases found for this project.',
                'no-papers' => 'No papers imported for this project.',
                'data-refresh' => 'Data refreshed successfully',
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
            'content' => 'Upload files in ".bib", ".txt" (format BibTex) or ".csv" format and import the files according to the database defined in the plan.<br>
             <ul>
             <li><b>Note:</b> If you want to conduct <b>"Peer Review"</b>, it is necessary to invite the researchers and add them to the project before importing the studies (papers).</li>
             <li>To add researchers, navigate to <b>"My Projects->Team"</b></li>
             </ul>
             <br>
             <b>CSV Format Guidelines:</b><br>
             Your CSV file must include the following column headers:<br>
             <ul>
                 <li>"<b>Item Title</b>" – used as the paper title</li>
                 <li>"<b>Authors</b>" – list of authors</li>
                 <li>"<b>Item DOI</b>" – Digital Object Identifier</li>
                 <li>"URL" – link to the paper</li>
                 <li>"Publication Year" –  publication year</li>
                 <li>"Book Series Title" – optional book series name</li>
                 <li>"Journal Volume" – optional journal volume</li>
                 <li>"Publication Title" – optional journal or publication name</li>
             </ul>
             <b>Important:</b> If any of the fields in <b>bold</b> are missing or empty, the import will <b>not</b> occur.'
        ],
        'table' => [
            'database' => 'Database',
            'studies-imported' => 'Total imported studies',
            'actions' => 'Actions',
            'file' => 'File',
            'files-uploaded' => 'Files uploaded',
            'no-files' => 'No files uploaded for this database.',
            'delete' => 'Delete',
        ],

        'livewire' => [
            'logs' => [
                'database_associated_papers_imported' => 'Database associated papers imported',
                'deleted_file_and_papers' => 'Deleted file and :count associated papers',
            ],
            'selectedDatabase' => [
                'value' => [
                    'required' => 'The database field is required.',
                    'exists' => 'The selected database does not exist.',
                ]
            ],
            'file' => [
                'required' => 'The description field is required.',
                'mimes' => 'The file must be a type of: bib, csv, txt.',
                'max' => 'The file size must not exceed 10MB.',
            ],
            'toasts' => [
                'file_uploaded_success' => 'File uploaded successfully. Papers have been inserted, and the total will be updated on screen shortly.',
                'file_upload_error' => 'An error occurred while importing papers. ERRO: :message',
                'project_database_not_found' => 'Project database not found.',
                'file_deleted_success' => 'File deleted successfully. :count papers associated were also deleted.',
                'file_delete_error' => 'An error occurred while deleting the file: :message',
                'file_already_exists' => 'A file with this name already exists in this database. Please avoid duplicates!',
                'denied' => 'A viewer cannot import or delete studies.',
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
