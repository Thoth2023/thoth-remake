<?php

return [
    'overview' => 'Overview',

    'project' => 'Project',
    'description' => 'Description',
    'objectives' => 'Objectives',
    'members' => 'Members',

    'progress' => 'Progress of Systematic Review',
    'planning' => 'Planning',
    'conducting' => 'Conducting',
    'study-selection' => 'Study Selection',
    'quality_assessment' => 'Quality Assessment',
    'snowballing' => 'Snowballing',
    'data_extraction' => 'Data Extraction',

    'project_status_help' => [
        'title' => 'How do project progress and status work?',
        'content' => '
        <p>The progress bars displayed on this page represent the individual progress of the currently logged-in user.</p>

        <p>Each researcher only sees their own progress in activities such as:</p>

        <ul>
            <li>Study Selection</li>
            <li>Quality Assessment</li>
            <li>Data Extraction</li>
            <li>Snowballing (when enabled)</li>
        </ul>

        <p>Therefore, different members of the same project may see different progress percentages.</p>

        <hr>

        <p>The project status indicates whether the systematic review is still in progress or has been officially completed.</p>

        <ul>
            <li><strong>Project in Progress:</strong> the project remains active and can still be modified.</li>
            <li><strong>Completed Project:</strong> the project administrator has declared the review completed.</li>
        </ul>

        <p>Only users with the <strong>Administrator</strong> role can change the project status.</p>

        <p>Even if all progress bars reach 100%, the project will only be considered completed after the administrator confirms it by selecting <strong>Mark as Completed</strong>.</p>

        <p>If necessary, a completed project can be reopened using the <strong>Reopen Project</strong> option.</p>
    ',
    ],

    'project_status' => 'Project Status',
    'finished_project' => 'Completed Project',
    'ongoing_project' => 'Project in Progress',
    'mark_as_finished' => 'Mark as Completed',
    'mark_as_ongoing' => 'Reopen Project',


    'activity_record' => 'Activity Record',
    'view_full_history' => 'View full history',
    'full_activity_history' => 'Full activity history',
    'no_activities' => 'No activities recorded.',
    'export' => 'Export data',

    // Activity Log messages
    'project_created' => 'Created the project :title',
    'project_edited' => 'Edited project :title',
    'admin_removed_member' => 'The admin removed the member :member from :project.',
    'sent_invitation' => 'Sent invitation to :member to join the project :project.',
    'admin_updated_member_level' => 'The admin updated :member level to :level.',
    'accepted_invitation' => 'Accepted invitation to join the project.',
    'close' => 'Close',
];
