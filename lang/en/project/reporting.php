<?php

return [

    'reporting' => 'Reporting',
    'content-helper' => '
        <p>The <strong>Reporting</strong> module brings together all the information generated throughout your Systematic Literature Review (SLR)
        or Systematic Mapping Study (SMS). In this section, you can explore charts, tables, counts, and statistics that summarize the progress
        and results of your review.</p>

        <h5><strong>How to use the reports?</strong></h5>
        <ul>
            <li><strong>Visualization:</strong> browse visual charts that represent each stage of the review — Importing, Study Selection, Quality Assessment, Snowballing, and Data Extraction.</li>
            <li><strong>Monitoring:</strong> view funnel charts, numbers of accepted, rejected, removed and duplicated studies, and other important metrics.</li>
            <li><strong>Verification:</strong> quickly confirm whether all stages were completed and identify possible inconsistencies.</li>
        </ul>

        <h5><strong>Data Export</strong></h5>
        <p>You can export tables and results in commonly used research formats:</p>
        <ul>
            <li><strong>CSV:</strong> for use in Excel, Google Sheets, or statistical scripts.</li>
            <li><strong>XML:</strong> useful for data exchange or custom automation workflows.</li>
            <li><strong>PDF:</strong> ideal for attaching to review reports, research papers, or official documents.</li>
        </ul>

        <p>The reporting module is designed to help you clearly understand your study, facilitate quantitative analysis,
        and provide ready-to-use data for scientific papers, dissertations, and technical reports.</p>
    ',
    'header' => [
        'overview' => 'Overview',
        'reliability' => 'Reliability',
        'import_studies' => 'Import Studies',
        'study_selection' => 'Study Selection',
        'quality_assessment' => 'Quality Assessment',
        'data_extraction' => 'Data Extraction',
        'snowballing' => 'Snowballing',
    ],

    'overview'=> [
        'systematic-mapping-study' => [
            'title' => 'Systematic Mapping Study on Domain-Specific Language Development Tools Funnel',
            'database' => [
                'title' => 'Database',
                'content'=>'Search in Digital Libraries',
            ],
            'imported-studies' => 'Imported Studies',
            'duplicates' => [
                'title'=> 'Duplicates',
                'content'=>'Duplicates Removal',
            ],
            'studies' => 'Studies',
            'study-selection' => [
                'title'=> 'Study Selection',
                'content'=>'I/E Removed',
            ],
            'studies-I/E-included'=> 'Studies I/E Included',
            'quality-assessment' => [
                'title' => 'Quality Assessment',
                'content'=> 'QA rejected',
            ],
            'studies-accepted' => [
                'title' => '#Avaiable Data Extraction',
                'content'=>'Studies accepted',
            ],
            'not-duplicate' => 'Not Duplicates',
            'status-selection' => 'Status Selection',
            'status-quality'=> 'Status Quality',
            'status-extration' => 'Status Extraction',
        ],
        'stages-systematic-review'=>'Stages of Systematic Literature Review or Systematic Mapping Study',
        'project-activities-overtime'=> 'Project Activities Over Time',
        'total-activities'=> 'Atividades Totais',
        'project'=> 'Project',
    ],

    'imported-studies'=> [
        'papers-database'=> [
            'title'=> 'Papers by Database',
            'content'=> 'Papers',
        ],
        'number-papers-year' => [
            'title'=> 'Number of Papers by Year',
            'year'=> 'Year',
            'number-of-papers'=> 'Number of Papers',
        ],
    ],

    'study-selection'=> [
        'papers-per-selection' => [
            'title'=> 'Papers per Status Selection',
            'content'=> 'Papers',
        ],
        'criteria-marked-user'=> [
            'title'=> 'Criteria Marked by User',
            'criteria-identified-study-selection' => 'Criteria Identified in Study Selection',
            'number-times' => 'Number of Times',
            'criteria' => 'Criteria',
            'user' => 'User',
            'value' => 'Value',
        ],
        'number-papers-user-status-selection' => [
            'title'=> 'Number of Papers by User and Status Selection',
            'users' => 'Users',
            'number-papers' => 'Number of Papers',
        ],
    ],

    'quality-assessment'=> [
        'papers-status-quality'=> [
            'title'=> 'Papers per Status Quality',
            'content'=> 'Papers',
        ],
        'papers-general-score'=> [
            'title'=> 'Papers per General Score',
            'content'=> 'Papers',
        ],
        'number-papers-user-status-quality'=> [
            'title' => 'Number of Papers per User and Status Quality',
            'users'=> 'User',
            'number-papers' => 'Number of Papers',
        ]
    ],

    'data-extraction'=> [
        'data-extraction-wordcloud'=> 'Data Extraction Wordcloud',
        'data-extraction-answer-packed-bubble'=> 'Data Extraction Answers - Packed Bubble',
        'comparasion-answers-question'=> [
            'title'=> 'Comparison of Answers per Question',
            'content'=> 'Answers',
        ]
    ],

    'reliability' =>[
        'selection' =>[
            'title' => 'Study Selection (Peer Review)',
            'content'=>'',
        ],
        'quality'=>[
            'title' => 'Quality Assessment (Peer Review)',
            'content'=>'',
        ],
        'agreement' => [
            'title' => 'Simple Agreement',
            'content' => '<p><strong>Simple Agreement</strong> (or "Crude Agreement") measures how often two or more researchers (raters) assign <strong>exactly the same classification</strong> (e.g., Accept or Reject) to a study. It\'s the most straightforward index of how frequently your team agreed.</p>
            <h4>How it Works in the Project?</h4>
            <p>It\'s calculated as the <strong>percentage of identical decisions</strong> relative to the total number of articles reviewed. For instance, if researchers agreed on 8 out of 10 studies, the agreement is 80%.</p>
            <h4>⚠️ Attention</h4>
            <p>While simple, this metric <strong>does not account for agreement that occurs by chance</strong> (luck). Therefore, its value tends to be <strong>inflated</strong> (higher than the actual agreement), and it is not the most robust measure of reliability.</p>',
            'title-modal' => 'Simple Agreement Analysis',
            'agreement-percentual' => 'Agreement Percentual (%)',
        ],
        'kappa' => [
            'title' => 'Method Kappa (Peer Review)',
            'content' => '<p>The <strong>Cohen\'s Kappa Coefficient</strong> is a statistical measure that assesses the agreement between raters on categorical data, but, critically, it <strong>discounts the proportion of agreement that would be expected by chance</strong>.</p>
            <p>It is the standard measure of <strong>reliability</strong> in scientific research. A high Kappa indicates that the observed agreement is significantly greater than chance.</p>
            <h4>Interpreting the Kappa Value</h4>
            <table class="table table-bordered">
                <thead>
                    <tr><th>Kappa Value</th><th>Level of Agreement</th></tr>
                </thead>
                <tbody>
                    <tr><td>0 to 0.20</td><td>None</td></tr>
                    <tr><td>0.21 to 0.39</td><td>Minimal</td></tr>
                    <tr><td>0.40 to 0.59</td><td>Weak</td></tr>
                    <tr><td>0.60 to 0.79</td><td><strong>Moderate</strong></td></tr>
                    <tr><td>0.80 to 0.90</td><td><strong>Strong</strong></td></tr>
                    <tr><td>&gt; 0.90</td><td>Almost Perfect</td></tr>
                </tbody>
            </table>
            <small>Reference: Adapted from McHugh (2012) and Landis & Koch (1977).</small>
            <h4>Relevance in the Project</h4>
            <p>A low Kappa (Weak or Minimal) in phases like <strong>Study Selection</strong> or <strong>Quality Assessment</strong> is a warning! It indicates that the criteria are ambiguous or that there is inconsistency in how the team is applying the rules.</p>',
            'title-modal' => 'Kappa Analysis',
            'kappa-value' => 'Kappa Value',
        ],
        'pesquisador'=>'Researcher',
        'peer-review'=>'Peer Review',
    ],

    'snowballing'=>[
        'relevant_papers' => 'relevant papers included',
        'seed_papers' => '{0} no seed papers|{1} 1 seed paper|[2,*] :count seed papers',
        'levels' => '{0} no levels|{1} 1 level|[2,*] :count levels',
        'legend' => 'Legend',
        'seed' => 'Seed Paper',
        'forward' => 'Forward',
        'backward' => 'Backward',
        'unknown' => 'Unknown',
        'chart_title' => 'Snowballing Iteration Tree',
        'tooltip_type' => 'Type',
        'tooltip_relevance' => 'Relevance',
        'no_data' => 'No data available to generate the chart.',
        'no_chart_data' => 'Not enough data for the chart.',
        'no_title' => 'Untitled',
    ],


    'check' => [
        'no_imported_studies' => 'No imported studies were found for this project.',
        'no_selected_studies' => 'No selected studies were found for this project.',
        'no_criteria_signed_by_anyone' => 'No criteria were signed by anyone.',
        'no_papers_and_status_selection' => 'No papers were selected by anyone for this project.',
        'no_evaluated_studies' => 'No evaluated studies were found for this project.',
        'no_papers_evaluated_by_anyone' => 'No papers were evaluated by anyone.',
        'no_extracted_data_by_anyone' => 'No data was extracted by anyone.',
        'study-selection'=> 'Study Selection',
        'quality-assessment'=> 'Quality Assessment',
    ]
];
