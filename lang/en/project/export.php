<?php

return [

    'export' => 'Export Content',
    'header' => [
        'latex' => [
            'title' => 'Latex Content',
            'help-content' => '
<p>This feature allows exporting system data in the <strong>LaTeX</strong> format, widely used for creating high-quality technical and scientific documents.</p>

<p><strong>How it works:</strong></p>
<ul>
    <li>Select the desired options, such as <em>Planning</em>, <em>Import Studies</em>, or <em>Quality Assessment</em>.</li>
    <li>The system will automatically generate the corresponding content in LaTeX format based on the information registered in the project.</li>
    <li>The generated text will be displayed in the editor below, where you can preview and manually edit the content if needed.</li>
</ul>

<p><strong>Exporting to Overleaf:</strong></p>
<p>By clicking on the <em>New project in Overleaf</em> button, the system compresses the generated content into a ZIP file and redirects you to a new project on Overleaf, an online platform for collaborative LaTeX document editing.</p>

<p><em>Note:</em> To ensure the integration with Overleaf works, you need to be logged in to the platform or log in when redirected.</p>

<p>This feature simplifies the creation, organization, and editing of project-related documents by integrating system information in a practical and efficient way.</p>
',
            'content-options'=> [
                'planning' => 'Planning',
                'import-studies' => 'Import Studies',
                'study-selection'=> 'Study Selection',
                'quality-assessment' => 'Quality Assessment',
                'snowballing' => 'Snowballing',
            ],
            'enter_description' => 'Select options to generate the latex content...',
        ],
        'bibtex' => [
            'title' => 'BibTex References',
            'help-content' => '<div>
    <p>
        The system allows the export of bibliographic references in the BibTeX format, which is widely used in reference managers and academic article production.
        With this feature, you can generate, view, and download references related to your project according to the selected option.
    </p>

    <h5>Available options:</h5>
    <ul>
        <li>
            <strong>Study Selection:</strong> Generates references only for the selected studies with the status
            <code>Accepted</code>. These references are extracted based on the criteria defined in your project.
        </li>
        <li>
            <strong>Quality Assessment:</strong> Generates references for studies that have passed the quality assessment with the status
            <code>Accepted</code>.
        </li>
        <li>
            <strong>Snowballing:</strong> Currently, this option displays a message indicating that there is no data available for generating references in this modality.
        </li>
    </ul>

    <h5>How it works:</h5>
    <ul>
        <li>Select one of the available options on the panel using the radio buttons.</li>
        <li>The references will be automatically generated in the text field below, in BibTeX format.</li>
        <li>If no data is available for the selected option, a message will appear in the text field indicating that no information is available.</li>
        <li>Once the references are generated, you can download them by clicking the download button.</li>
    </ul>

    <h5>Notes:</h5>
    <ul>
        <li>The BibTeX format is compatible with tools like LaTeX, Overleaf, and reference managers like Mendeley, Zotero, and JabRef.</li>
        <li>Ensure that your project information is complete to guarantee the correct export of references.</li>
    </ul>
</div>',
        'content-options'=> [
            'study-selection' => 'Study Selection',
            'quality-assessment' => 'Quality Assessment',
            'snowballing' => 'Snowballing',
        ],
        'enter_description' => 'Select options to generate the references...',
        ],
    ],
    'button' => [
        'overleaf' => 'New Project in Overleaf',
        'bibtex-download' => 'Download BibTex References',
        'copy-latex'=>'Copy LaTex',
    ]

];
