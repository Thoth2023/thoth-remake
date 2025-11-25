<?php

return [
    'planning' => 'Planning',
    'content-helper'=>'<p>
The planning phase of the protocol SLR is the moment when you transform your review idea into a structured and reproducible plan.
A carefully completed protocol reduces bias, improves transparency, and makes collaboration easier.
We recommend filling in each section in the order below, because many decisions depend on previous ones.
</p>
<p>
Use this list as a planning checklist before you start conducting the review.
</p>

<ol>
  <li><strong>Domains:</strong> Clearly define the domains or application areas of your study
(for example, Software Engineering, Health, Education). This keeps the review thematically focused.</li>

  <li><strong>Languages:</strong> Specify the languages that will be considered in the review.
Make sure these choices are aligned with your team and the scope of the study.</li>

  <li><strong>Study Types:</strong> Describe which types of studies will be included
(for example, empirical studies, case studies, surveys, previous reviews).</li>

  <li><strong>Keywords:</strong> Register terms or phrases that represent the key concepts in your research.
They are the basis for building search terms and search strings.</li>

  <li><strong>Project Dates:</strong> Define the time period during which the review will be carried out.
This supports schedule planning and documents the temporal window of your study.</li>

  <li><strong>Research Questions:</strong> Formulate the questions that the review aims to answer.
They guide every later decision about search, selection, data extraction, and synthesis.</li>

  <li><strong>Databases:</strong> Choose the article repositories and academic digital libraries that will be used
(for example, Scopus, Web of Science, IEEE Xplore).</li>

  <li><strong>Suggest a New Database:</strong> If an important database for your area is not available,
      use this option to suggest its inclusion in Thoth.</li>

  <li><strong>Search Terms:</strong> Based on domains, keywords, and research questions,
      define the terms that will be combined to retrieve relevant studies.</li>

  <li><strong>Search String:</strong> Build search strings by combining terms, Boolean operators,
      and filters suitable for each database.</li>

  <li><strong>Search Strategy:</strong> Describe how the searches will be conducted
(pilot searches, iterative refinements, combination of databases, per-database adjustments).</li>

  <li><strong>Inclusion and Exclusion Criteria:</strong> Define objective criteria that determine
      whether a study is selected or discarded, considering title, abstract, full text, and quality.</li>

  <li><strong>Quality Questions:</strong> Register the questions that will be used to assess the quality of each study.
Questions may have different weights according to their importance.</li>

  <li><strong>Quality Scoring:</strong> For each quality question, define the scoring rules
(for example, Yes, Partially, No) and the corresponding numerical values.</li>

  <li><strong>Quality Questions Table:</strong> Review the consolidated view of all quality questions and their scores.
At this point, adjust weights and ensure that all questions are clear and consistent.</li>

  <li><strong>Global Score Ranges:</strong> Define score ranges (for example, High, Medium, Low quality)
    that will be used to classify each study after the quality assessment.</li>

  <li><strong>Minimum Global Score for Approval:</strong> Set the minimum global score that a study must reach
      in order to be accepted and move to the next stages of the review.</li>

  <li><strong>Data Extraction Questions:</strong> Register the questions that define which information
      you want to extract from the studies in order to answer the research questions.</li>

  <li><strong>Data Extraction Question Options:</strong> For each extraction question, configure answer types
      such as free text, multiple choice, or numeric fields, in a standardized and analysis-friendly way.</li>

  <li><strong>Extraction Table:</strong> Review the complete list of extraction questions.
      Use this view to identify gaps, edit items, and ensure that all required data will be collected.</li>
</ol>',
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
                    'denied' => 'A viewer cannot add, edit or delete domains.'
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
                    'denied' => 'A viewer cannot add, edit or delete languages.'
                ],
            ]
        ],
        'study_type' => [
            'title' => 'Study Types',
            'types' => [
                'Book' => 'Book',
                'Thesis' => 'Thesis',
                'Article in Press' => 'Article in Press',
                'Article' => 'Article',
                'Conference Paper' => 'Conference Paper',
                'All types' => 'All types',
            ],
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
                    'denied' => 'A viewer cannot add, edit or delete study types.',
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
                'content' => '
<p><strong>Keywords</strong> are terms or phrases that represent the core concepts of your research. They guide the search process in academic databases, helping retrieve studies that are relevant to your Systematic Literature Review (SLR).</p>

<p>Keywords can also be used to organize, categorize, and filter studies, making it easier to identify information aligned with your research topic.</p>

<p>Below are some examples of keywords in different research domains:</p>

<ul>
    <li><strong>Software Engineering:</strong> "software testing", "agile development", "software metrics", "DevOps", "requirements engineering".</li>
    <li><strong>Computer Science:</strong> "machine learning", "neural networks", "data mining", "cybersecurity", "cloud computing".</li>
    <li><strong>Health:</strong> "public health", "diabetes treatment", "mental health", "nutrition", "epidemiology".</li>
    <li><strong>Education:</strong> "e-learning", "pedagogical strategies", "assessment methods", "inclusive education", "remote learning".</li>
    <li><strong>Business/Management:</strong> "project management", "leadership", "organizational behavior", "strategic planning", "marketing analysis".</li>
</ul>

<p>Use a mix of broad and specific terms to improve search accuracy. When possible, check previous studies to identify commonly used keywords in your research area.</p>
',
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
                    'duplicate' => 'Keyword duplicated is not allowed.',
                    'denied' => 'A viewer cannot add, edit or delete keywords.'
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
                    'denied' => 'A viewer cannot add, edit or delete dates.',
                ],
            ]
        ],
    ],
    'research-questions' => [
        'title' => 'Research Questions',
        'help' => [
            'title' => 'Research Questions Help',
            'content' => '
<p><strong>What are Research Questions?</strong></p>

<p>
Research Questions (RQs) are the central questions that guide your entire Systematic Literature Review (SLR).
They define <em>exactly what you want to investigate</em>, directly influencing all subsequent phases: study selection, criteria definition, data extraction, quality assessment, and synthesis.
</p>

<p><strong>How to fill in the fields:</strong></p>

<ul>
<li>
    <strong>ID:</strong>
    A short and unique identifier for each research question.
    The recommended format is a simple code such as <strong>RQ01</strong>, <strong>RQ02</strong>, etc.
    This makes it easier to reference questions during quality assessment, data extraction, and reporting.
</li>

<li>
    <strong>Description:</strong>
    Write a clear, objective, and focused research question.
    The description should reflect exactly what you intend to answer through your review.
</li>
</ul>

<p><strong>Important tips:</strong></p>

<ul>
<li>Register one question at a time;</li>
<li>Ensure that each question can be fully answered using evidence from the studies;</li>
<li>Use simple, clear, and non-ambiguous formulations;</li>
<li>Review each question with your supervisor or research team to ensure conceptual alignment.</li>
</ul>

<p><strong>Practical examples:</strong></p>

<ul>
<li><strong>ID:</strong> RQ01 — <strong>Description:</strong> What requirements engineering methods are used in large-scale software projects?</li>

<li><strong>ID:</strong> RQ02 — <strong>Description:</strong> What are the main limitations reported in studies on automated testing?</li>

<li><strong>ID:</strong> RQ03 — <strong>Description:</strong> How has artificial intelligence been applied to support software development?</li>

<li><strong>ID:</strong> RQ04 — <strong>Description:</strong> What metrics are used to evaluate code quality in recent studies?</li>
</ul>

<p>
These research questions will serve as the main guide for your review.
All collected data throughout the process should contribute to answering them clearly, consistently, and with strong evidence.
</p>
'
        ],
        'form' => [
            'id' => 'ID',
            'description' => 'Description',
            'enter_description' => 'Enter research question description',
            'add' => 'Add',
            'update' => 'Update',
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
                'denied' => 'A viewer cannot add, edit or delete research questions.',
            ],
        ]
    ],
    'databases' => [
        'title' => 'Databases',
        'help' => [
            'title' => 'Databases',
            'content' => '
<p><strong>What are Databases?</strong></p>
<p>
Databases are online platforms that store scientific articles, technical reports, books, and other academic publications.
They work as large searchable catalogs where you can find studies using keywords or search strings.
</p>

<p>
In a Systematic Literature Review (SLR), databases are essential because they allow you to retrieve a comprehensive and reliable set of studies.
Each database covers different topics, types of publications, and scientific communities.
</p>

<p><strong>How to choose the best databases?</strong></p>
<ul>
<li>Consider your research area (e.g., Software Engineering, Health, Education, Business, etc.).</li>
<li>Check which databases are most cited or recommended in your field.</li>
<li>Use multiple databases to avoid missing relevant studies.</li>
<li>Select databases known for strong indexing and high-quality publications.</li>
</ul>

<p><strong>Examples of academic databases:</strong></p>
<ul>
<li><strong>Scopus:</strong> multidisciplinary and widely used worldwide.</li>
<li><strong>Web of Science:</strong> highly recognized, with well-indexed high-quality studies.</li>
<li><strong>IEEE Xplore:</strong> ideal for Computer Science, Engineering, and Technology.</li>
<li><strong>ACM Digital Library:</strong> essential for Computer Science research.</li>
<li><strong>PubMed:</strong> excellent for health-related areas.</li>
<li><strong>ScienceDirect:</strong> strong coverage of applied sciences and technology.</li>
</ul>

<p><strong>How to use this section in Thoth 2.0:</strong></p>
<ul>
<li>Select the databases you want to include in your review.</li>
<li>Add a new database if one relevant to your field is missing.</li>
<li>Remove databases that are not useful for your research scope.</li>
</ul>

<p>
Choosing proper databases ensures your review is comprehensive, reliable, and methodologically sound.
</p>
',
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
            'help' => [
                'title' => 'Suggest a New Database',
                'content' => '
<p>If your research requires a specific database that is **not listed in Thoth**, you can submit a suggestion for it to be added.
This is especially useful in cases where your study area relies on specialized repositories that are not part of the default system configuration.</p>

<p><strong>Important:</strong> The suggested database will <em>not</em> become available immediately.
It must first be reviewed and approved by the system administrators, who check its relevance, accessibility, and trustworthiness.</p>

<hr>

<p><strong>How to fill in the fields:</strong></p>

<ul>
<li>
    <strong>Database Name:</strong><br>
    Enter the official name of the database you want to suggest.<br>
    Examples:
    <ul>
        <li><em>ACM Digital Library</em></li>
        <li><em>PubMed</em></li>
        <li><em>Google Scholar</em></li>
        <li><em>ScienceDirect</em></li>
    </ul>
</li>

<li>
    <strong>Database Link:</strong><br>
    Provide the main URL of the database (its home page).<br>
    Examples:
    <ul>
        <li>https://dl.acm.org/</li>
        <li>https://pubmed.ncbi.nlm.nih.gov/</li>
        <li>https://scholar.google.com/</li>
        <li>https://www.sciencedirect.com/</li>
    </ul>
    The link should direct users to the main repository page, not a specific article or search result.
</li>
</ul>

<hr>

<p>After submitting your suggestion, please wait for the review process.
Once approved, the database will be added to the list and become available for use during your planning.</p>
',
            ],

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
                'denied' => 'A viewer cannot add, edit or delete databases.',
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
        'help' => 'Search string is a combination of search terms that you use to search for relevant literature in databases. Add search strings to each database to refine your search and improve the accuracy of your search results.
        <br>
        <hr>
<p><strong>How Thoth builds the Search String automatically:</strong></p>

<ul>
<li>
    Each <strong>main keyword</strong> is combined using the <strong>AND</strong> operator.
    Example:
    <code>(tools) AND (web-based) AND (systematic review)</code>
</li>

<li>
    Each <strong>synonym</strong> is combined using the <strong>OR</strong> operator.
    Example:
    <code>(tools OR "software tools" OR "support tools")</code>
</li>

<li>
    Thoth automatically generates the final string in the ideal academic search format.
</li>
</ul>

<hr>

<p><strong>Example of an Automatically Generated Search String:</strong></p>

<pre>
("systematic review" OR "literature review")
AND
(tools OR "software tools" OR "support tools")
AND
(web-based OR online OR "browser-based")
</pre>

<p>
This is the string that will later be used for searching academic databases defined in your project.
</p>

<p><strong>Final Tips:</strong></p>
<ul>
<li>Start by adding all core concepts;</li>
<li>Include widely used synonyms in the literature;</li>
<li>Prefer English keywords when searching international databases;</li>
<li>No need to worry about operators — Thoth handles that automatically.</li>
</ul>
        ',
        'form' => [
            'description' => 'Generic search string',
            'enter-description' => 'Enter search string description',
            'no-database'=> 'No database found for this project.',
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
            'help' => '<p><strong>What is a Search String?</strong></p>

<p>
A Search String is a structured combination of keywords, logical operators, and synonyms that you use to
search for studies in academic databases. A well-constructed string ensures that your search is
<em>accurate, comprehensive, and reproducible</em>, helping you find all relevant studies for your
Systematic Literature Review (SLR).
</p>

<p>
A good search string reduces bias, avoids missing important papers, and allows consistent comparison across
different databases (IEEE, Scopus, ACM, etc.).
</p>

<hr>

<p><strong>How to fill out the fields shown on the screen:</strong></p>

<ul>
<li>
    <strong>Search Term:</strong>
    These are the main concepts of your research.
    Example: <em>“tools”</em>, <em>“web-based”</em>, <em>“systematic review”</em>.
</li>

<li>
    <strong>Add Term:</strong>
    After typing the keyword, click <strong>“Add Term”</strong> to save it.
</li>

<li>
    <strong>Select a Term:</strong>
    Choose a previously added term to attach synonyms to it.
</li>

<li>
    <strong>Synonyms:</strong>
    These are alternative expressions or variations of the same idea.
    Example:
    <ul>
        <li>Term: <em>tools</em> → Synonyms: <em>software tools</em>, <em>support tools</em></li>
        <li>Term: <em>web-based</em> → Synonyms: <em>online</em>, <em>browser-based</em></li>
    </ul>
</li>

<li>
    <strong>Suggestion Language:</strong>
    Thoth automatically provides synonym suggestions based on the selected language.
    If no suitable suggestion appears, you may add your own synonyms manually.
</li>

<li>
    <strong>“+” Button (Add Synonym):</strong>
    Click to attach the synonym to the selected keyword.
</li>
</ul>
',
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
                    'validation' => 'The search term field is required.',
                    'synonym' => 'The synonym field is required.',
                    'denied' => 'A viewer cannot add, edit or delete search terms.',
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
        'success' => 'Search strategy updated successfully.',
        'denied' => 'A viewer cannot add, edit or delete search strategy.',
    ],
    'criteria' => [
        'title' => 'Inclusion/Exclusion Criteria',
        'help' => [
            'title' => 'Inclusion/Exclusion Criteria',
            'content' => '
                <p><strong>What are Inclusion and Exclusion Criteria?</strong></p>

<p>
Inclusion and Exclusion Criteria are essential rules that determine
<strong>which studies will be considered</strong> in your Systematic Literature Review (SLR)
and which ones should be removed.
They ensure that the selection process is <strong>clear, consistent, and reproducible</strong>,
preventing bias and keeping your review aligned with its objectives.
</p>

<p><strong>How to fill in the fields:</strong></p>

<ul>
    <li>
        <strong>ID:</strong>
        Use a short and unique identifier for each criterion.
        For Inclusion, use the pattern <strong>IC1, IC2, IC3...</strong>
        For Exclusion, use <strong>EC1, EC2, EC3...</strong>
        These identifiers make tracking and reporting easier.
    </li>

    <li>
        <strong>Description:</strong>
        Write a clear, objective, and verifiable rule.
        The description should allow any researcher to assess the study
        in the same way, reducing ambiguity.
        <br><em>Good examples:</em>
        <br>• “The study must provide an empirical evaluation of tool X.”
        <br>• “Duplicate articles must be excluded.”
    </li>

    <li>
        <strong>Type:</strong>
        Choose whether the criterion is <strong>Inclusion</strong> or <strong>Exclusion</strong>.
        This automatically organizes the tables and selection workflow.
    </li>
</ul>

<hr>

<p><strong>Inclusion Criteria (IC):</strong></p>
<p>
These are the conditions a study <strong>must fulfill</strong> to be considered relevant.
They define the scope of the review and ensure that only meaningful studies proceed.
</p>

<p><strong>Example:</strong><br>
IC1 — The publication must propose a tool to support performance testing.
</p>

<hr>

<p><strong>Exclusion Criteria (EC):</strong></p>
<p>
These conditions indicate that a study <strong>should not be included</strong>,
even if it meets some inclusion criteria.
They are typically used to remove noise, duplicates, or out-of-scope publications.
</p>

<p><strong>Examples:</strong><br>
EC1 — Duplicate articles.
EC2 — The study is not available in full text.
</p>

<hr>

<p><strong>Inclusion / Exclusion Rule (Important):</strong></p>

<p>This rule defines how the criteria will be applied:</p>

<ul>
    <li>
        <strong>All:</strong>
        The study must meet <strong>all selected criteria</strong>.
        More restrictive, ensuring high precision.
    </li>

    <li>
        <strong>At least:</strong>
        The study must meet <strong>a minimum number</strong> of selected criteria.
        Useful for broader areas or complementary criteria.
    </li>

    <li>
        <strong>Any:</strong>
        If the study meets <strong>any</strong> of the selected criteria, it will be marked.
        Less restrictive, increasing sensitivity.
    </li>
</ul>

<hr>

<p><strong>Practical tips:</strong></p>

<ul>
    <li>Avoid vague descriptions such as “relevant paper”.</li>
    <li>Prefer objective and testable conditions.</li>
    <li>Include exclusion rules to filter noise (e.g., posters, 1-page summaries).</li>
    <li>Review the criteria with your supervisor to ensure alignment.</li>
    <li>Use consistent IDs to facilitate data extraction.</li>
</ul>

<p>
These criteria form the foundation of your study selection process, ensuring
<strong>a transparent, auditable, and replicable SLR workflow</strong>.
</p>

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
                'in' => 'Select a valid type.'
            ],
            'logs' => [
                'added' => 'Criteria added',
                'updated' => 'Criteria updated',
                'deleted' => 'Criteria deleted',
            ],
            'toasts' => [
                'reset_paper_evaluations' => 'All paper evaluations have been reset to "Not Evaluated".',
                'no_criteria'=> 'No criteria found.',
                'added' => 'Criteria added successfully',
                'deleted' => 'Criteria deleted successfully',
                'updated' => 'Criteria updated successfully',
                'updated-inclusion' => 'Inclusion criteria rule updated',
                'updated-exclusion' => 'Exclusion criteria rule updated',
                'unique-id' => 'This ID is already in use. Please choose another an unique ID.',
                'denied' => 'A viewer cannot add, edit or delete criteria.',
                'type' => [
                    'required' => 'The type field is required.',
                ],
            ],
        ],
        'duplicate_id' => 'The provided ID already exists in this project.',
        'updated_success' => 'Criteria updated successfully.',
        'not_found' => 'Criteria not found.',
        'deleted_success' => 'Criteria deleted successfully.',
        'preselected_updated' => 'Pre-selected value updated successfully.',
    ],
    'quality-assessment' => [
        'title' => 'Quality Assessment',
        'generate-intervals' => 'Generate Intervals',
        'ranges' => [
            'label-updated' => 'Label updated successfully.',
            'interval-updated' => 'Interval updated successfully.',
            'deletion-restricted' => 'Cannot delete the interval ":description". There are  associated records/papers depending on this interval.',
            'generated' => 'Intervals generated successfully.',
            'reduction-not-allowed' => 'It is not possible to reduce the number of intervals because evaluations are already in progress for this project.',
            'new-label' => 'Range :n',
            'generated-successfully' => 'Scoring intervals successfully updated.',
        ],
        'qa-table'=>[
            'min-general-score' => 'Minimal Score to Approve',
        ],
        'general-score' => [
            'title' => 'General Score Interval',
            'help' => [
                'title' => 'General Score Interval',
                'content' => '<p>The <strong>general score ranges</strong> are used to classify the final quality level of each study after evaluating all quality questions. These ranges group the total score of a study into categories (e.g., “Very Low”, “Low”, “Good”, “Very Good”), making it easy to determine the quality tier of each study.</p>

<p>The generation of ranges is <strong>automatic</strong>. The user simply chooses <strong>how many ranges</strong> they want, and Thoth generates them based on the <strong>total sum of weights</strong> assigned to the quality questions. This total represents the <strong>maximum possible score</strong> a study can achieve.</p>

<p><strong>How to fill in the fields:</strong></p>

<ul>
    <li>In the <strong>"Generate ranges"</strong> field, enter the number of score ranges you want (e.g., 4, 5, 6).</li>
    <li>Click <strong>"Generate ranges"</strong>. Thoth will create the ranges automatically, including minimum values, maximum values, and default labels.</li>
    <li>The fields <strong>Min</strong> and <strong>Label</strong> can be edited by the user.</li>
    <li>The <strong>Max</strong> fields of intermediate ranges and any <strong>locked fields</strong> are automatically calculated by Thoth and <strong>cannot be edited</strong>.</li>
    <li>The <strong>Max value of the last range</strong> is always equal to the <strong>total sum of weights</strong> — this limit is mandatory and cannot be changed.</li>
</ul>

<p><strong>Important rules:</strong></p>
<ul>
    <li>If you modify quality questions (including their weights), review the score ranges again — the total weight may have changed.</li>
    <li>If you want to <strong>reduce the number of ranges</strong>, this is only possible if <strong>no studies have been evaluated yet</strong>.</li>
    <li>If you only want to <strong>recalculate the ranges</strong> based on updated weights, generate the same number of ranges again. Thoth will automatically adjust them.</li>
    <li>If you want to <strong>add new ranges</strong> (e.g., from 4 to 5), simply enter the new total. Thoth will generate only the missing range(s).</li>
</ul>

<p><strong>Example:</strong></p>

<table class="table table-bordered table-striped small">
    <thead>
        <tr>
            <th>Min</th>
            <th>Max</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>0.01</td>
            <td>1.25</td>
            <td>Very Low</td>
        </tr>
        <tr>
            <td>1.26</td>
            <td>2.5</td>
            <td>Low</td>
        </tr>
        <tr>
            <td>2.51</td>
            <td>3.75</td>
            <td>Good</td>
        </tr>
        <tr>
            <td>3.76</td>
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
                    'denied' => 'A viewer cannot add, edit or delete general scores.',
                ],
            ],

        ],
        'question-quality' => [
            'title' => 'Question Quality',
            'help' => [
                'title' => 'Quality Question',
                'content' => '
<p><strong>Quality Questions</strong> are used to assess how reliable, complete, and well-conducted each primary study is.
Even if a publication meets your inclusion criteria, its methodological quality can vary — and this evaluation helps you understand how trustworthy each study is when answering your Research Questions.</p>

<p><strong>Why is quality assessment important?</strong></p>

<ul>
    <li>Identifies more reliable and well-designed studies.</li>
    <li>Prevents weak studies from influencing your final conclusions.</li>
    <li>Allows you to assign more weight to stronger evidence.</li>
    <li>Improves transparency and credibility of the review process.</li>
    <li>Supports stronger interpretation and future recommendations.</li>
</ul>

<hr>

<p><strong>How to fill in the fields:</strong></p>

<ul>
    <li><strong>ID:</strong> A short and unique identifier for the quality question.
        Common examples include <strong>QA01</strong>, <strong>QA02</strong>, etc., which help organize the evaluation later.</li>

    <li><strong>Weight:</strong> Indicates how important this question is when computing the study’s final quality score.
        <ul>
            <li><strong>Higher weights</strong> = more influence on the final score.</li>
            <li><strong>Lower weights</strong> = less influence.</li>
        </ul>
        Assign weights carefully so that the most relevant questions have the most impact.</li>

    <li><strong>Description:</strong> Write a clear, objective question that evaluates some aspect of the study’s reliability or completeness.</li>
</ul>

<hr>

<p><strong>Important tips:</strong></p>
<ul>
    <li>Keep each question clear and specific.</li>
    <li>Register <strong>one question at a time</strong>.</li>
    <li>Use weights consistently based on the relevance of each item.</li>
    <li>Review the list of questions with your team or supervisor.</li>
</ul>

<hr>

<p><strong>Example:</strong></p>
<ul>
    <li><strong>ID:</strong> QA01</li>
    <li><strong>Weight:</strong> 2</li>
    <li><strong>Description:</strong> Does the study clearly describe the method used to conduct the review?</li>
</ul>

<p>These questions will be used later in the Quality Assessment step, where each study receives scores based on the answers to the questions you define here.</p>
',
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
                    'duplicate_id' => 'A question with this ID already exists.',
                    'added' => 'Question Quality added successfully.',
                    'updated' => 'Question Quality updated successfully.',
                    'deleted' => 'Question Quality deleted successfully.',
                    'min_weight' => 'The weight must be greater than 0.',
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
    <p>The <strong>Question Score</strong> step allows you to define how each quality question will be evaluated.
    Here you create the <strong>scoring rules</strong>, which function as the possible answers for each quality question.</p>

    <p>Each scoring rule contains:</p>
    <ul>
        <li><strong>A linked quality question</strong> (selected in the "Question" field);</li>
        <li><strong>A scoring rule name</strong> (e.g., Yes, No, Partial);</li>
        <li><strong>A percentage value</strong> (0% to 100%) representing the weight of that answer;</li>
        <li><strong>A description</strong> explaining exactly when that rule should be selected.</li>
    </ul>

    <p><strong>You must register one scoring rule at a time for each question.</strong><br>
    After registering all rules, each question will have its own set of possible answers and respective scores.</p>

    <hr>

    <h5><strong>How to fill in the fields:</strong></h5>

    <ul>
        <li>
            <strong>Question:</strong> Select the quality question that this scoring rule belongs to (e.g., QA01, QA02...).<br>
            Each rule is always linked to a single question.
        </li>

        <li>
            <strong>Scoring Rule:</strong> Short name for the answer option.<br>
            Common examples:
            <ul>
                <li>Yes</li>
                <li>Partial</li>
                <li>No</li>
                <li>High Evidence</li>
                <li>Moderate Evidence</li>
                <li>Low Evidence</li>
            </ul>
        </li>

        <li>
            <strong>Score:</strong> Select a value between 0% and 100% using the slider. <br>
            This score will be applied when the reviewer chooses that answer.
        </li>

        <li>
            <strong>Description:</strong> Provide a detailed explanation of when this rule should be applied. <br>
            Example:
            <em>"The study fully describes the implemented tool, including methodology and validation."</em>
        </li>
    </ul>

    <hr>

    <h5><strong>Complete Example</strong></h5>

    <p>Suppose quality question <strong>QA01</strong> is:</p>
    <p><em>"Does the study present the implementation of a tool for systematic literature review?"</em></p>

    <p>Example scoring rules:</p>

    <table class="table table-bordered table-striped small table-break-text">
        <thead>
            <tr>
                <th class="w-15">Question ID</th>
                <th class="w-15">Rule</th>
                <th class="w-20">Score</th>
                <th class="w-50 break-words">Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>QA01</td>
                <td><strong>Yes</strong></td>
                <td>100%</td>
                <td>The study clearly presents the full implementation of the tool, including methodology and validation.</td>
            </tr>
            <tr>
                <td>QA01</td>
                <td><strong>Partial*</strong></td>
                <td>50%</td>
                <td>The study presents the tool but does not describe all implementation or validation details.</td>
            </tr>
            <tr>
                <td>QA01</td>
                <td><strong>No</strong></td>
                <td>0%</td>
                <td>The study does not present the implementation of a tool.</td>
            </tr>
        </tbody>
    </table>

    <p>Repeat this process for <strong>each</strong> quality question.
    At the end, you will have a complete scoring matrix to evaluate all included studies.</p>
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
                'placeholder' => 'Select or type the Scoring Rule',
                'description' => 'Type/Explain with a description to the scoring rule',
                'yes' => 'Yes',
                'partial' => 'Partial',
                'insufficient' => 'Insufficient',
                'no' => 'No',
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
            'messages' => [
                'unique_score_rule' => 'The scoring rule already exists for this question.',
                'score_rule_only_letters' => 'The score rule may contain only letters and spaces.',
                'description_only_letters_numbers' => 'The description may contain only letters, numbers, and spaces.',
            ],
            'toasts' => [
                'added' => 'Quality Score added successfully.',
                'updated' => 'Quality Score updated successfully.',
                'deleted' => 'Quality Score deleted successfully.',
            ],
        ],

        'min-general-score' => [
            'title' => 'Minimal General Score to Approve',
            'help-content' => '
<p>After registering all quality questions, the sum of the weights of all previously recorded questions is automatically calculated by Thoth.</p>

<p>This total represents the <strong>maximum score limit</strong> that a study can achieve during the quality assessment stage.
For this reason, the <strong>upper bound of the general scoring intervals</strong> must always <strong>match the total sum of all weights</strong>
defined in the project. This alignment is essential to ensure that the scoring calculations and quality classifications
operate correctly during the review conduction phase.</p>

<p><strong>Minimum Overall Score for Approval:</strong><br>
This setting defines the minimum general scoring interval that will be considered the threshold to accept studies in the review.</p>

<p><strong>How does this work in practice?</strong><br>
During the <strong>quality assessment phase</strong>, each evaluated study receives a <strong>total score</strong>, calculated based on the rules and weights previously defined.
The purpose of the <strong>general scoring intervals</strong> is to classify this study within a level or category — for example, “Very Low”, “Low”, “Moderate”, or “High”.</p>

<p>After identifying which interval the study falls into, it is compared against the <strong>configured minimum overall interval</strong>.
Only studies whose scores are <strong>equal to or greater than the selected minimum interval</strong> will be <strong>accepted</strong> and can proceed to the next stage of the review.</p>

<hr>
<p><strong>Simple Example:</strong><br>
If the minimum interval configured is <strong>Moderate (2.6 – 3.75)</strong> and the evaluated study receives a score within the interval <strong>Low (1.26 – 2.5)</strong>, that study will be automatically <strong>rejected</strong>.</p>

<p><strong>Important:</strong><br>
In addition to the overall minimum score, each individual quality question also has a <strong>minimum score requirement</strong>.
This means that even if a study reaches an overall interval above the defined minimum,
it <strong>may still be rejected</strong> if it fails to meet the minimum score set for any specific quality question.
This ensures that all critical criteria are properly evaluated and respected.</p>

<hr>
<p><strong>Important:</strong> To correctly configure this step, you must first:
<ul>
    <li>Register all quality questions;</li>
    <li>Define scoring rules and weights for each question;</li>
    <li>Generate the general scoring intervals;</li>
    <li>Save the intervals in the review project.</li>
</ul>
Also ensure that the <strong>maximum value of the last interval</strong> always matches the <strong>sum of all question weights</strong>.</p>
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
            'title' => 'Data Extraction Question',
            'help' => [
                'title' => 'Data Extraction Question Form Help',
                'content' => '
            <p>Data extraction forms must be designed to collect all information required to answer the review questions and assess study quality.
            If quality criteria are used for inclusion/exclusion, they must be collected separately.
            If they are part of the analysis, they may be included in the same extraction form.</p>

            <p>In most cases, data extraction involves numeric values (e.g., sample size, treatment effect, confidence intervals).
            These values are essential for summarizing primary studies and conducting meta-analyses.</p>

            <p>Each extraction question must include: ID, description, and data type.</p>

            <p><strong>Data Types:</strong></p>
            <ul>
                <li><strong>Text:</strong> allows the researcher to freely describe the extracted data.</li>
                <li><strong>Single Choice List:</strong> the researcher must select only one predefined option.</li>
                <li><strong>Multiple Choice List:</strong> the researcher may select multiple predefined options.</li>
            </ul>

            <h5>How to fill in the fields:</h5>
            <ul>
                <li><strong>ID:</strong> unique identifier for the question (e.g., "DE1", "DE2").</li>
                <li><strong>Description:</strong> clearly describe what must be extracted (e.g., "How many participants are in the study?").</li>
                <li><strong>Type:</strong> select the appropriate answer format (Text, Single Choice, Multiple Choice).</li>
            </ul>

            <h5>Examples of questions:</h5>
            <ul>
                <li><strong>Text:</strong> "Describe the approach used by the study."</li>
                <li><strong>Single Choice:</strong> "What is the study type?" (Experimental, Observational, Survey)</li>
                <li><strong>Multiple Choice:</strong> "Which evaluation metrics were used?" (Accuracy, Recall, F1-Score, AUC)</li>
            </ul>
        ',
          ],
           'type-selection'=> [
                'title' => 'Select a Type',
            ],
            'types' => [
                'Text' => 'Text',
                'Pick One List' => 'Pick One List',
                'Multiple Choice List' => 'Multiple Choice List',
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
        <p>Use this form to create <strong>response options</strong> for data extraction questions that use list-based answers.
        Options help standardize responses and simplify the analysis of extracted data during the review.</p>

        <h5><strong>When can options be added?</strong></h5>
        <p>Options can only be added to questions whose data type is:</p>
        <ul>
            <li><strong>Single Choice List</strong></li>
            <li><strong>Multiple Choice List</strong></li>
        </ul>
        <p>Questions of type <strong>Text</strong> do not support predefined options, since the researcher must enter the response manually.</p>

        <h5><strong>How to fill in the fields?</strong></h5>
        <ul>
            <li><strong>Question:</strong> select the extraction question to which this option will belong. Only questions of list-based types will appear in this dropdown.</li>
            <li><strong>Option:</strong> enter the option that will be shown to the user during the data extraction phase.</li>
        </ul>

        <p>Each option must be added individually. If a question requires multiple options, you must register them one at a time.</p>

        <h5><strong>Examples:</strong></h5>
        <ul>
            <li><strong>Question:</strong> "Database Source" — Type: Single Choice List<br>
                <strong>Possible options:</strong> ACM, IEEE Xplore, Scopus, Web of Science</li>

            <li><strong>Question:</strong> "Which evaluation metrics are used?" — Type: Multiple Choice List<br>
                <strong>Possible options:</strong> Accuracy, Recall, F1-Score, AUC</li>
        </ul>
    ',
            ],
            'question-selection'=> [
                'title' => 'Select a Question',

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
        ],
        'toasts' => [
            'denied' => 'A viewer cannot add, edit or delete data extraction questions.',
        ]
    ]
];
